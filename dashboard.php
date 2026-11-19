<?php
require __DIR__ . '/app.php';
require_login();

$shopId = (int) $_SESSION['shop_id'];
$branchId = $_SESSION['branch_id'];
$currentRole = current_role();

$metricsStatement = db()->prepare(
    'SELECT COUNT(*) AS product_count,
            COALESCE(SUM(quantity), 0) AS total_units,
            COALESCE(SUM(CASE WHEN quantity <= min_quantity THEN 1 ELSE 0 END), 0) AS low_stock_count,
            COALESCE(SUM(CASE WHEN expiry_date < CURDATE() THEN 1 ELSE 0 END), 0) AS expired_count,
            COALESCE(SUM(CASE WHEN expiry_date >= CURDATE()
                AND expiry_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) THEN 1 ELSE 0 END), 0) AS expiring_count
     FROM products WHERE shop_id = ?'
);
$metricsStatement->execute([$shopId]);
$inventoryMetrics = $metricsStatement->fetch();

$monthlyExportsSql = 'SELECT COALESCE(SUM(quantity), 0) FROM exports
    WHERE shop_id = ? AND export_date >= DATE_FORMAT(CURDATE(), "%Y-%m-01")';
$monthlyExportsParams = [$shopId];
if ($branchId !== null) {
    $monthlyExportsSql .= ' AND branch_id = ?';
    $monthlyExportsParams[] = (int) $branchId;
}
$monthlyExportsStatement = db()->prepare($monthlyExportsSql);
$monthlyExportsStatement->execute($monthlyExportsParams);
$monthlyExportUnits = $monthlyExportsStatement->fetchColumn();

$alertsStatement = db()->prepare(
    'SELECT item_code, name, quantity, min_quantity, expiry_date
     FROM products
     WHERE shop_id = ?
       AND (quantity <= min_quantity OR (expiry_date IS NOT NULL AND expiry_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)))
     ORDER BY (expiry_date < CURDATE()) DESC, expiry_date ASC, (quantity <= min_quantity) DESC, name
     LIMIT 8'
);
$alertsStatement->execute([$shopId]);
$inventoryAlerts = $alertsStatement->fetchAll();

$recentExportsSql = 'SELECT b.name AS branch_name, p.name AS product_name,
        x.quantity, x.export_date
    FROM exports x
    JOIN branches b ON b.id = x.branch_id AND b.shop_id = x.shop_id
    JOIN products p ON p.id = x.product_id AND p.shop_id = x.shop_id
    WHERE x.shop_id = ?';
$recentExportsParams = [$shopId];
if ($branchId !== null) {
    $recentExportsSql .= ' AND x.branch_id = ?';
    $recentExportsParams[] = (int) $branchId;
}
$recentExportsSql .= ' ORDER BY x.export_date DESC, x.id DESC LIMIT 6';
$recentExportsStatement = db()->prepare($recentExportsSql);
$recentExportsStatement->execute($recentExportsParams);
$recentExports = $recentExportsStatement->fetchAll();

page_start('الرئيسية');
?>
<section class="welcome-panel">
    <div>
        <span class="eyebrow">نظرة عامة على عمليات التوزيع</span>
        <h2>مرحبًا بعودتك</h2>
        <p>تابع المخزون والتنبيهات وحركة الفروع من مكان واحد.</p>
    </div>
    <a class="button-link" href="exports.php">تسجيل حركة توزيع <span aria-hidden="true">←</span></a>
</section>

<section class="metric-grid" aria-label="ملخص المخزون">
    <article class="metric-card metric-blue">
        <span class="metric-icon">▦</span>
        <span class="metric-label">عدد الأصناف</span>
        <strong><?= e($inventoryMetrics['product_count']) ?></strong>
        <a href="GEB2.php">عرض المخزون <span aria-hidden="true">←</span></a>
    </article>
    <article class="metric-card metric-teal">
        <span class="metric-icon">▤</span>
        <span class="metric-label">الوحدات المتاحة</span>
        <strong><?= e(number_format((float) $inventoryMetrics['total_units'], 2)) ?></strong>
        <span class="metric-note">مجموع الكميات الحالية</span>
    </article>
    <article class="metric-card metric-amber">
        <span class="metric-icon">!</span>
        <span class="metric-label">أصناف تحتاج متابعة</span>
        <strong><?= e($inventoryMetrics['low_stock_count']) ?></strong>
        <a href="GEB2.php?status=low">أقل من حد إعادة الطلب <span aria-hidden="true">←</span></a>
    </article>
    <article class="metric-card metric-purple">
        <span class="metric-icon">↗</span>
        <span class="metric-label">التوزيع هذا الشهر</span>
        <strong><?= e(number_format((float) $monthlyExportUnits, 2)) ?></strong>
        <a href="exports.php">عرض الحركات <span aria-hidden="true">←</span></a>
    </article>
</section>

<section class="dashboard-grid">
    <article class="panel">
        <div class="panel-heading">
            <div><span class="eyebrow">تنبيهات تشغيلية</span><h2>المخزون والصلاحية</h2></div>
            <a class="text-link" href="GEB2.php">كل الأصناف</a>
        </div>
        <div class="alert-summary">
            <a href="GEB2.php?status=low"><strong><?= e($inventoryMetrics['low_stock_count']) ?></strong><span>مخزون منخفض</span></a>
            <a href="GEB2.php?status=expired"><strong><?= e($inventoryMetrics['expired_count']) ?></strong><span>منتهي الصلاحية</span></a>
            <a href="GEB2.php?status=expiring"><strong><?= e($inventoryMetrics['expiring_count']) ?></strong><span>ينتهي خلال 30 يومًا</span></a>
        </div>
        <?php if ($inventoryAlerts): ?>
            <div class="compact-list">
                <?php foreach ($inventoryAlerts as $alertItem): ?>
                    <div class="compact-row">
                        <div><strong><?= e($alertItem['name']) ?></strong><small><?= e($alertItem['item_code']) ?></small></div>
                        <div class="alert-details">
                            <?php if ((float) $alertItem['quantity'] <= (float) $alertItem['min_quantity']): ?>
                                <span class="status-pill status-low">المتاح <?= e($alertItem['quantity']) ?> · الحد <?= e($alertItem['min_quantity']) ?></span>
                            <?php endif; ?>
                            <?php if ($alertItem['expiry_date'] !== null && $alertItem['expiry_date'] <= date('Y-m-d', strtotime('+30 days'))): ?>
                                <span class="status-pill <?= $alertItem['expiry_date'] < date('Y-m-d') ? 'status-expired' : 'status-expiring' ?>">
                                    <?= $alertItem['expiry_date'] < date('Y-m-d') ? 'منتهي' : 'الصلاحية ' . e($alertItem['expiry_date']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="empty-state">لا توجد تنبيهات للمخزون أو الصلاحية حاليًا.</p>
        <?php endif; ?>
    </article>

    <article class="panel">
        <div class="panel-heading">
            <div><span class="eyebrow">آخر التحديثات</span><h2>حركات التوزيع</h2></div>
            <a class="text-link" href="exports.php">كل الحركات</a>
        </div>
        <?php if ($recentExports): ?>
            <div class="compact-list">
                <?php foreach ($recentExports as $exportRecord): ?>
                    <div class="compact-row">
                        <div><strong><?= e($exportRecord['product_name']) ?></strong><small><?= e($exportRecord['branch_name']) ?> · <?= e($exportRecord['export_date']) ?></small></div>
                        <span class="quantity-chip">−<?= e($exportRecord['quantity']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="empty-state">لم تُسجل حركات توزيع بعد.</p>
        <?php endif; ?>
        <a class="secondary-action" href="exports.php">+ تسجيل حركة جديدة</a>
    </article>
</section>
<?php page_end(); ?>

