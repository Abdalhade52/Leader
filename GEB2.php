<?php
require __DIR__ . '/app.php';
require_login();

$shopId = (int) $_SESSION['shop_id'];
$canManageInventory = in_array(current_role(), ['owner', 'company_manager'], true);
$saveError = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    require_roles(['owner', 'company_manager']);
    verify_csrf();

    $itemCode = trim((string) ($_POST['itemcode'] ?? ''));
    $itemName = trim((string) ($_POST['itemname'] ?? ''));
    $itemCategory = trim((string) ($_POST['category'] ?? ''));
    $itemUnit = (string) ($_POST['unit'] ?? 'قطعة');
    $itemQuantity = filter_var($_POST['quantity'] ?? null, FILTER_VALIDATE_FLOAT);
    $minimumQuantity = filter_var($_POST['min_quantity'] ?? null, FILTER_VALIDATE_FLOAT);
    $costPrice = filter_var($_POST['costprice'] ?? null, FILTER_VALIDATE_FLOAT);
    $sellPrice = filter_var($_POST['sellprice'] ?? null, FILTER_VALIDATE_FLOAT);
    $expiryDate = (string) ($_POST['expiry_date'] ?? '');

    $isValidProduct = $itemCode !== ''
        && $itemName !== ''
        && $itemQuantity !== false && $itemQuantity >= 0
        && $minimumQuantity !== false && $minimumQuantity >= 0
        && $costPrice !== false && $costPrice >= 0
        && $sellPrice !== false && $sellPrice >= 0
        && in_array($itemUnit, ['قطعة', 'كرتون', 'كيلو', 'لتر'], true);

    if (!$isValidProduct) {
        http_response_code(422);
        exit('بيانات الصنف غير صالحة.');
    }

    try {
        $insertProductStatement = db()->prepare(
            'INSERT INTO products
                (shop_id, item_code, name, category, unit, quantity, min_quantity, cost_price, sell_price, expiry_date)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $insertProductStatement->execute([
            $shopId, $itemCode, $itemName, $itemCategory, $itemUnit,
            $itemQuantity, $minimumQuantity, $costPrice, $sellPrice,
            $expiryDate !== '' ? $expiryDate : null,
        ]);
        header('Location: GEB2.php?saved=1');
        exit;
    } catch (PDOException $databaseException) {
        $saveError = 'تعذر حفظ الصنف، تحقق من الكود.';
    }
}

$searchTerm = trim((string) ($_GET['q'] ?? ''));
$inventoryFilter = (string) ($_GET['status'] ?? 'all');
$validInventoryFilters = ['all', 'low', 'out', 'expired', 'expiring'];
if (!in_array($inventoryFilter, $validInventoryFilters, true)) {
    $inventoryFilter = 'all';
}

$inventoryConditions = ['shop_id = ?'];
$inventoryParameters = [$shopId];
if ($searchTerm !== '') {
    $inventoryConditions[] = '(item_code LIKE ? OR name LIKE ? OR category LIKE ?)';
    $searchPattern = '%' . $searchTerm . '%';
    array_push($inventoryParameters, $searchPattern, $searchPattern, $searchPattern);
}
switch ($inventoryFilter) {
    case 'low': $inventoryConditions[] = 'quantity <= min_quantity'; break;
    case 'out': $inventoryConditions[] = 'quantity = 0'; break;
    case 'expired': $inventoryConditions[] = 'expiry_date < CURDATE()'; break;
    case 'expiring': $inventoryConditions[] = 'expiry_date >= CURDATE() AND expiry_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)'; break;
}

$inventorySql = 'SELECT item_code, name, category, unit, quantity, min_quantity,
        cost_price, sell_price, expiry_date
    FROM products WHERE ' . implode(' AND ', $inventoryConditions)
    . ' ORDER BY (quantity <= min_quantity) DESC, expiry_date IS NULL, expiry_date, name';
$inventoryStatement = db()->prepare($inventorySql);
$inventoryStatement->execute($inventoryParameters);
$products = $inventoryStatement->fetchAll();

page_start('المخزون');
if (isset($_GET['saved'])) echo '<p class="success">تم حفظ الصنف بنجاح.</p>';
if ($saveError !== '') echo '<p class="alert">' . e($saveError) . '</p>';
?>
<section class="page-intro">
    <div><span class="eyebrow">إدارة الأصناف</span><p>تابع الرصيد وحد إعادة الطلب وتواريخ الصلاحية.</p></div>
</section>

<?php if ($canManageInventory): ?>
<details class="panel add-product-panel">
    <summary><span>إضافة صنف جديد</span><span class="summary-hint">افتح النموذج</span></summary>
    <form method="post" class="form-grid">
        <?= csrf_field() ?>
        <label>كود الصنف<input name="itemcode" required maxlength="80"></label>
        <label>اسم الصنف<input name="itemname" required maxlength="160"></label>
        <label>التصنيف<input name="category" maxlength="120"></label>
        <label>الوحدة<select name="unit"><option>قطعة</option><option>كرتون</option><option>كيلو</option><option>لتر</option></select></label>
        <label>الكمية الحالية<input type="number" name="quantity" min="0" step=".01" value="0" required></label>
        <label>حد إعادة الطلب<input type="number" name="min_quantity" min="0" step=".01" value="0" required></label>
        <label>سعر التكلفة<input type="number" name="costprice" min="0" step=".01" value="0" required></label>
        <label>سعر البيع<input type="number" name="sellprice" min="0" step=".01" value="0" required></label>
        <label>تاريخ الانتهاء<input type="date" name="expiry_date"></label>
        <div class="form-actions"><button type="submit">حفظ الصنف</button></div>
    </form>
</details>
<?php endif; ?>

<section class="panel inventory-panel">
    <div class="panel-heading">
        <div><span class="eyebrow">كتالوج المنشأة</span><h2>الأصناف <span class="result-count"><?= e(count($products)) ?></span></h2></div>
    </div>
    <form method="get" class="inventory-toolbar">
        <label class="search-field">بحث<input type="search" name="q" value="<?= e($searchTerm) ?>" placeholder="اسم الصنف أو الكود أو التصنيف"></label>
        <label>تصفية الحالة
            <select name="status">
                <option value="all" <?= $inventoryFilter === 'all' ? 'selected' : '' ?>>كل الأصناف</option>
                <option value="low" <?= $inventoryFilter === 'low' ? 'selected' : '' ?>>أقل من حد إعادة الطلب</option>
                <option value="out" <?= $inventoryFilter === 'out' ? 'selected' : '' ?>>نفد المخزون</option>
                <option value="expired" <?= $inventoryFilter === 'expired' ? 'selected' : '' ?>>منتهي الصلاحية</option>
                <option value="expiring" <?= $inventoryFilter === 'expiring' ? 'selected' : '' ?>>ينتهي خلال 30 يومًا</option>
            </select>
        </label>
        <button type="submit" class="button-secondary">تطبيق</button>
        <a class="clear-filter" href="GEB2.php">مسح التصفية</a>
    </form>

    <div class="table-wrap">
        <table class="inventory-table">
            <thead><tr><th>الصنف</th><th>التصنيف</th><th>الرصيد</th><th>حد الطلب</th><?php if ($canManageInventory): ?><th>التكلفة</th><th>البيع</th><?php endif; ?><th>الصلاحية</th><th>الحالة</th></tr></thead>
            <tbody>
            <?php foreach ($products as $product):
                $isLowStock = (float) $product['quantity'] <= (float) $product['min_quantity'];
                $isExpired = $product['expiry_date'] !== null && $product['expiry_date'] < date('Y-m-d');
                $isExpiringSoon = $product['expiry_date'] !== null
                    && $product['expiry_date'] >= date('Y-m-d')
                    && $product['expiry_date'] <= date('Y-m-d', strtotime('+30 days'));
            ?>
                <tr>
                    <td><strong><?= e($product['name']) ?></strong><small class="table-subtext"><?= e($product['item_code']) ?></small></td>
                    <td><?= e($product['category'] !== '' ? $product['category'] : '—') ?></td>
                    <td class="numeric-cell"><?= e($product['quantity']) ?> <small><?= e($product['unit']) ?></small></td>
                    <td><?= e($product['min_quantity']) ?></td>
                    <?php if ($canManageInventory): ?><td><?= e(number_format((float) $product['cost_price'], 2)) ?></td><td><?= e(number_format((float) $product['sell_price'], 2)) ?></td><?php endif; ?>
                    <td><?= e($product['expiry_date'] ?? '—') ?></td>
                    <td><?php if ($isExpired): ?><span class="status-pill status-expired">منتهي</span><?php elseif ($isLowStock): ?><span class="status-pill status-low">مخزون منخفض</span><?php elseif ($isExpiringSoon): ?><span class="status-pill status-expiring">قرب الانتهاء</span><?php else: ?><span class="status-pill status-ok">متوفر</span><?php endif; ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$products): ?><tr><td colspan="<?= $canManageInventory ? '8' : '6' ?>" class="empty-cell">لا توجد أصناف تطابق البحث أو التصفية.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php page_end(); ?>
