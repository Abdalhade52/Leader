<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    $isHttpsConnection = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    session_set_cookie_params([
        'httponly' => true,
        'secure' => $isHttpsConnection,
        'samesite' => 'Lax',
        'path' => '/',
    ]);
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('X-Frame-Options: DENY');
    header("Content-Security-Policy: default-src 'self'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'; object-src 'none'");
}

const ROLE_LABELS = [
    'employee' => 'موظف',
    'branch_manager' => 'مدير فرع',
    'company_manager' => 'مدير الشركة',
    'owner' => 'صاحب المشروع',
];

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function db(): PDO
{
    static $connection = null;
    if ($connection instanceof PDO) {
        return $connection;
    }

    $localDatabaseConfig = is_file(__DIR__ . '/config.local.php')
        ? require __DIR__ . '/config.local.php'
        : [];
    if (!is_array($localDatabaseConfig)) {
        $localDatabaseConfig = [];
    }

    $databaseHost = getenv('APP_DB_HOST');
    $databaseName = getenv('APP_DB_NAME');
    $databaseUser = getenv('APP_DB_USER');
    $databasePassword = getenv('APP_DB_PASS');

    $databaseHost = $databaseHost === false ? ($localDatabaseConfig['host'] ?? '') : $databaseHost;
    $databaseName = $databaseName === false ? ($localDatabaseConfig['name'] ?? '') : $databaseName;
    $databaseUser = $databaseUser === false ? ($localDatabaseConfig['user'] ?? '') : $databaseUser;
    $databasePassword = $databasePassword === false ? ($localDatabaseConfig['pass'] ?? '') : $databasePassword;

    if (!$databaseHost || !$databaseName || !$databaseUser) {
        http_response_code(500);
        exit('إعدادات قاعدة البيانات غير مكتملة.');
    }

    $connection = new PDO(
        "mysql:host=$databaseHost;dbname=$databaseName;charset=utf8mb4",
        $databaseUser,
        $databasePassword,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    return $connection;
}

function require_login(): void
{
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    $userStatement = db()->prepare(
        'SELECT id, shop_id, role, branch_id, email FROM users WHERE id = ? LIMIT 1'
    );
    $userStatement->execute([(int) $_SESSION['user_id']]);
    $userRecord = $userStatement->fetch();

    if (!$userRecord) {
        $_SESSION = [];
        session_destroy();
        header('Location: login.php');
        exit;
    }

    $_SESSION['shop_id'] = (int) $userRecord['shop_id'];
    $_SESSION['role'] = $userRecord['role'];
    $_SESSION['branch_id'] = $userRecord['branch_id'] === null
        ? null
        : (int) $userRecord['branch_id'];
    $_SESSION['email'] = $userRecord['email'];

    if (
        in_array($userRecord['role'], ['employee', 'branch_manager'], true)
        && $userRecord['branch_id'] === null
    ) {
        http_response_code(403);
        exit('يجب أن يعيّن لك مدير الشركة فرعًا قبل استخدام النظام.');
    }
}

function require_roles(array $allowedRoles): void
{
    require_login();
    if (!in_array($_SESSION['role'], $allowedRoles, true)) {
        http_response_code(403);
        exit('ليس لديك صلاحية لهذه الصفحة.');
    }
}

function current_role(): string
{
    return (string) ($_SESSION['role'] ?? '');
}

function branch_allowed(int $branchId): bool
{
    return in_array(current_role(), ['owner', 'company_manager'], true)
        || (!empty($_SESSION['branch_id']) && (int) $_SESSION['branch_id'] === $branchId);
}

function validate_branch(int $branchId): bool
{
    $branchStatement = db()->prepare('SELECT id FROM branches WHERE id = ? AND shop_id = ?');
    $branchStatement->execute([$branchId, (int) $_SESSION['shop_id']]);
    return (bool) $branchStatement->fetch() && branch_allowed($branchId);
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void
{
    $submittedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($submittedToken) || !hash_equals(csrf_token(), $submittedToken)) {
        http_response_code(403);
        exit('انتهت صلاحية النموذج، أعد تحميل الصفحة.');
    }
}

function page_start(string $pageTitle): void
{
    $currentRole = current_role();
    $stylesheetVersion = (string) (filemtime(__DIR__ . '/css/app.css') ?: 1);
    echo '<!doctype html><html lang="ar" dir="rtl"><head><meta charset="utf-8">'
        . '<meta name="viewport" content="width=device-width,initial-scale=1">'
        . '<title>' . e($pageTitle) . ' - مدار للتوزيع</title>'
        . '<link rel="stylesheet" href="css/app.css?v=' . e($stylesheetVersion) . '"></head><body>'
        . '<header class="topbar"><a class="brand" href="dashboard.php"><span class="brand-icon">م</span><span>مدار للتوزيع</span></a><nav>'
        . '<a href="dashboard.php">الرئيسية</a><a href="GEB2.php">المخزون</a><a href="branches.php">الفروع</a>'
        . '<a href="exports.php">التوزيع</a>'
        . (in_array($currentRole, ['owner', 'company_manager', 'branch_manager'], true)
            ? '<a href="Statics.php">الإحصاءات</a><a href="users.php">المستخدمون</a>'
            : '')
        . '<a href="accauntseting2.php">الحساب</a><a href="logout.php">خروج</a>'
        . '</nav></header><main class="container"><p class="role-badge">'
        . e(ROLE_LABELS[$currentRole] ?? '') . '</p><h1>' . e($pageTitle) . '</h1>';
}

function page_end(): void
{
    echo '</main><footer class="footer">مدار للتوزيع</footer></body></html>';
}

