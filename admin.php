<?php
// admin.php - Local/private-network admin panel for Nandar World.
$is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $is_https,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/common-file/php/game_helpers.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . e($_SESSION['csrf_token'] ?? '') . '">';
}

function csrf_valid()
{
    return hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '');
}

function admin_password_matches($input_password, $configured_password)
{
    $env_hash = getenv('NANDAR_ADMIN_PASSWORD_HASH');
    if (is_string($env_hash) && $env_hash !== '') {
        return password_verify($input_password, $env_hash);
    }

    if (is_string($configured_password) && preg_match('/^\$(2y|argon2id|argon2i)\$/', $configured_password)) {
        return password_verify($input_password, $configured_password);
    }

    return hash_equals((string)$configured_password, (string)$input_password);
}

try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $exception) {
    http_response_code(500);
    exit('Database connection failed.');
}

if (isset($_GET['logout'])) {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'] ?? '', $params['secure'], $params['httponly']);
    }
    session_destroy();
    header('Location: admin.php');
    exit;
}

if (empty($_SESSION['admin_logged_in'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        $now = time();
        $lock_until = (int)($_SESSION['admin_login_lock_until'] ?? 0);
        $user_input = trim((string)($_POST['username'] ?? ''));
        $pass_input = (string)($_POST['password'] ?? '');

        if ($lock_until > $now) {
            $login_error = 'Too many login attempts. Please wait and try again.';
        } elseif (!csrf_valid()) {
            $login_error = 'Security check failed. Please refresh and try again.';
        } elseif (hash_equals((string)$admin_user, $user_input) && admin_password_matches($pass_input, $admin_pass)) {
            session_regenerate_id(true);
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['admin_logged_in'] = true;
            unset($_SESSION['admin_login_attempts'], $_SESSION['admin_login_lock_until']);
            header('Location: admin.php');
            exit;
        } else {
            $_SESSION['admin_login_attempts'] = (int)($_SESSION['admin_login_attempts'] ?? 0) + 1;
            if ($_SESSION['admin_login_attempts'] >= 5) {
                $_SESSION['admin_login_lock_until'] = $now + 900;
            }
            $login_error = 'Incorrect username or password.';
        }
    }
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Login - Nandar World</title>
        <link href="common-file/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { min-height: 100vh; margin: 0; display: grid; place-items: center; background: radial-gradient(circle at top left, #16345f, #10131a 48%, #07080c); color: #f8fafc; }
            .login-card { width: min(420px, calc(100vw - 32px)); padding: 34px; border: 1px solid rgba(255,255,255,.12); border-radius: 22px; background: rgba(15,23,42,.82); box-shadow: 0 30px 90px rgba(0,0,0,.45); }
            .form-control { background: rgba(255,255,255,.08); border-color: rgba(255,255,255,.18); color: #fff; }
            .form-control:focus { background: rgba(255,255,255,.12); color: #fff; }
        </style>
    </head>
    <body>
        <main class="login-card">
            <h1 class="h3 mb-2">Nandar World Admin</h1>
            <p class="text-secondary mb-4">Restricted local/private-network access only.</p>
            <?php if (!empty($login_error)): ?>
                <div class="alert alert-danger"><?= e($login_error) ?></div>
            <?php endif; ?>
            <form method="post" autocomplete="off">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" id="password" name="password" type="password" required>
                </div>
                <button class="btn btn-primary w-100" type="submit" name="login" value="1">Sign In</button>
            </form>
        </main>
    </body>
    </html>
    <?php
    exit;
}

$success_message = null;
$error_message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valid()) {
        $error_message = 'Security check failed. Please refresh and try again.';
    } else {
        try {
            if (isset($_POST['add_game']) || isset($_POST['edit_game'])) {
                $game_id = (int)($_POST['game_id'] ?? 0);
                $name = trim((string)($_POST['name'] ?? ''));
                $game_url = trim((string)($_POST['game_url'] ?? ''));
                $image_url = trim((string)($_POST['image_url'] ?? ''));
                $category_ids = array_values(array_filter(array_map('intval', $_POST['category_ids'] ?? [])));

                if ($name === '' || $game_url === '' || $image_url === '') {
                    throw new RuntimeException('Please complete all required fields.');
                }

                $pdo->beginTransaction();
                if (isset($_POST['add_game'])) {
                    $stmt = $pdo->prepare('INSERT INTO games (name, game_url, image_url, clicks) VALUES (?, ?, ?, 0)');
                    $stmt->execute([$name, $game_url, $image_url]);
                    $game_id = (int)$pdo->lastInsertId();
                    $success_message = 'Game added successfully.';
                } else {
                    $stmt = $pdo->prepare('UPDATE games SET name = ?, game_url = ?, image_url = ? WHERE id = ?');
                    $stmt->execute([$name, $game_url, $image_url, $game_id]);
                    $stmt = $pdo->prepare('DELETE FROM game_category WHERE game_id = ?');
                    $stmt->execute([$game_id]);
                    $success_message = 'Game updated successfully.';
                }

                if ($category_ids) {
                    $stmt = $pdo->prepare('INSERT IGNORE INTO game_category (game_id, category_id) VALUES (?, ?)');
                    foreach ($category_ids as $category_id) {
                        $stmt->execute([$game_id, $category_id]);
                    }
                }
                $pdo->commit();
            } elseif (isset($_POST['delete_game'])) {
                $game_id = (int)($_POST['game_id'] ?? 0);
                $pdo->beginTransaction();
                $stmt = $pdo->prepare('DELETE FROM game_category WHERE game_id = ?');
                $stmt->execute([$game_id]);
                $stmt = $pdo->prepare('DELETE FROM games WHERE id = ?');
                $stmt->execute([$game_id]);
                $pdo->commit();
                $success_message = 'Game deleted successfully.';
            } elseif (isset($_POST['add_category']) || isset($_POST['edit_category'])) {
                $category_id = (int)($_POST['category_id'] ?? 0);
                $category_name = trim((string)($_POST['category_name'] ?? ''));
                $sort_order = (int)($_POST['sort_order'] ?? 0);

                if ($category_name === '') {
                    throw new RuntimeException('Please enter a category name.');
                }

                if (isset($_POST['add_category'])) {
                    $stmt = $pdo->prepare('INSERT INTO categories (category_name, sort_order) VALUES (?, ?)');
                    $stmt->execute([$category_name, $sort_order]);
                    $success_message = 'Category added successfully.';
                } else {
                    $stmt = $pdo->prepare('UPDATE categories SET category_name = ?, sort_order = ? WHERE id = ?');
                    $stmt->execute([$category_name, $sort_order, $category_id]);
                    $success_message = 'Category updated successfully.';
                }
            } elseif (isset($_POST['delete_category'])) {
                $category_id = (int)($_POST['category_id'] ?? 0);
                $stmt = $pdo->prepare('SELECT COUNT(*) FROM game_category WHERE category_id = ?');
                $stmt->execute([$category_id]);
                if ((int)$stmt->fetchColumn() > 0) {
                    throw new RuntimeException('This category cannot be deleted because games are still linked to it.');
                }
                $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
                $stmt->execute([$category_id]);
                $success_message = 'Category deleted successfully.';
            }
        } catch (Throwable $exception) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $error_message = $exception->getMessage();
        }
    }
}

$per_page = 300;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $per_page;
$total_games = (int)$pdo->query('SELECT COUNT(*) FROM games')->fetchColumn();
$total_pages = max(1, (int)ceil($total_games / $per_page));

$stmt = $pdo->prepare('
    SELECT g.*, GROUP_CONCAT(c.category_name ORDER BY c.category_name SEPARATOR ", ") AS category_names
    FROM games g
    LEFT JOIN game_category gc ON g.id = gc.game_id
    LEFT JOIN categories c ON gc.category_id = c.id
    GROUP BY g.id
    ORDER BY g.id DESC
    LIMIT :limit OFFSET :offset
');
$stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$games = $stmt->fetchAll();

$categories = $pdo->query('SELECT * FROM categories ORDER BY sort_order, category_name')->fetchAll();
$category_counts = [];
foreach ($pdo->query('SELECT category_id, COUNT(*) AS total FROM game_category GROUP BY category_id') as $row) {
    $category_counts[(int)$row['category_id']] = (int)$row['total'];
}

$edit_game = null;
$edit_category = null;
$edit_game_category_ids = [];
if (isset($_GET['edit_game'])) {
    $stmt = $pdo->prepare('SELECT * FROM games WHERE id = ?');
    $stmt->execute([(int)$_GET['edit_game']]);
    $edit_game = $stmt->fetch() ?: null;
    if ($edit_game) {
        $stmt = $pdo->prepare('SELECT category_id FROM game_category WHERE game_id = ?');
        $stmt->execute([(int)$edit_game['id']]);
        $edit_game_category_ids = array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
    }
}
if (isset($_GET['edit_category'])) {
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
    $stmt->execute([(int)$_GET['edit_category']]);
    $edit_category = $stmt->fetch() ?: null;
}

$total_categories = count($categories);
$total_clicks = (int)$pdo->query('SELECT COALESCE(SUM(clicks), 0) FROM games')->fetchColumn();
$hot_games = $pdo->query('
    SELECT g.name, g.clicks, GROUP_CONCAT(c.category_name ORDER BY c.category_name SEPARATOR ", ") AS categories
    FROM games g
    LEFT JOIN game_category gc ON g.id = gc.game_id
    LEFT JOIN categories c ON gc.category_id = c.id
    GROUP BY g.id
    ORDER BY g.clicks DESC
    LIMIT 10
')->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Nandar World</title>
    <link href="common-file/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fb; }
        .sidebar { min-height: 100vh; background: #111827; }
        .sidebar .nav-link { color: #e5e7eb; border-radius: 10px; margin: 2px 10px; }
        .sidebar .nav-link.active, .sidebar .nav-link:hover { background: #2563eb; color: #fff; }
        .main-content { padding: 22px; }
        .stats-card { border: 0; border-radius: 16px; box-shadow: 0 12px 35px rgba(15,23,42,.08); }
        .game-image-preview { width: 100px; height: 60px; object-fit: cover; background: #e5e7eb; }
        .table-actions { white-space: nowrap; }
        .code-link { max-width: 240px; display: inline-block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-2 sidebar p-0">
            <div class="p-3 text-center text-white">
                <h4>Nandar Admin</h4>
                <small class="text-secondary">Local/private access</small>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link active" href="#games" data-bs-toggle="tab">Games</a>
                <a class="nav-link" href="#categories" data-bs-toggle="tab">Categories</a>
                <a class="nav-link" href="#stats" data-bs-toggle="tab">Stats</a>
                <a class="nav-link text-warning mt-3" href="?logout=1">Sign Out</a>
            </nav>
        </aside>
        <main class="col-md-10 main-content">
            <?php if ($success_message): ?><div class="alert alert-success"><?= e($success_message) ?></div><?php endif; ?>
            <?php if ($error_message): ?><div class="alert alert-danger"><?= e($error_message) ?></div><?php endif; ?>

            <div class="tab-content">
                <section class="tab-pane fade show active" id="games">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-0">Game Management</h2>
                            <small class="text-muted">Showing <?= count($games) ?> of <?= number_format($total_games) ?> games.</small>
                        </div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#gameModal">Add Game</button>
                    </div>
                    <div class="card stats-card">
                        <div class="card-body table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead><tr><th>ID</th><th>Cover</th><th>Name</th><th>URL</th><th>Categories</th><th>Clicks</th><th>Created</th><th>Actions</th></tr></thead>
                                <tbody>
                                <?php foreach ($games as $game): ?>
                                    <tr>
                                        <td><?= (int)$game['id'] ?></td>
                                        <td><img class="game-image-preview rounded" src="<?= e(resolve_game_image_url($game)) ?>" alt="<?= e($game['name']) ?>" loading="lazy" decoding="async" onerror="this.onerror=null;this.src='common-file/img/default-game.jpg'"></td>
                                        <td><?= e($game['name']) ?></td>
                                        <td><a class="code-link" href="<?= e($game['game_url']) ?>" target="_blank" rel="noopener noreferrer"><?= e($game['game_url']) ?></a></td>
                                        <td><?= e($game['category_names'] ?: 'Uncategorized') ?></td>
                                        <td><?= number_format((int)$game['clicks']) ?></td>
                                        <td><?= e($game['created_at'] ?? '') ?></td>
                                        <td class="table-actions">
                                            <a class="btn btn-sm btn-warning" href="?edit_game=<?= (int)$game['id'] ?>">Edit</a>
                                            <form method="post" class="d-inline" onsubmit="return confirm('Delete this game?')">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="game_id" value="<?= (int)$game['id'] ?>">
                                                <button class="btn btn-sm btn-danger" type="submit" name="delete_game" value="1">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            <nav>
                                <ul class="pagination mb-0">
                                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= max(1, $page - 1) ?>">Previous</a></li>
                                    <li class="page-item disabled"><span class="page-link">Page <?= $page ?> / <?= $total_pages ?></span></li>
                                    <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </section>

                <section class="tab-pane fade" id="categories">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Category Management</h2>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">Add Category</button>
                    </div>
                    <div class="card stats-card"><div class="card-body table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead><tr><th>ID</th><th>Name</th><th>Sort</th><th>Games</th><th>Created</th><th>Actions</th></tr></thead>
                            <tbody>
                            <?php foreach ($categories as $category): $count = $category_counts[(int)$category['id']] ?? 0; ?>
                                <tr>
                                    <td><?= (int)$category['id'] ?></td>
                                    <td><?= e($category['category_name']) ?></td>
                                    <td><?= (int)$category['sort_order'] ?></td>
                                    <td><?= number_format($count) ?></td>
                                    <td><?= e($category['created_at'] ?? '') ?></td>
                                    <td class="table-actions">
                                        <a class="btn btn-sm btn-warning" href="?edit_category=<?= (int)$category['id'] ?>">Edit</a>
                                        <form method="post" class="d-inline" onsubmit="return confirm('Delete this category?')">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="category_id" value="<?= (int)$category['id'] ?>">
                                            <button class="btn btn-sm btn-danger" type="submit" name="delete_category" value="1" <?= $count > 0 ? 'disabled title="Games are still assigned"' : '' ?>>Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div></div>
                </section>

                <section class="tab-pane fade" id="stats">
                    <h2 class="mb-4">Statistics</h2>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3"><div class="card stats-card bg-primary text-white"><div class="card-body"><h4><?= number_format($total_games) ?></h4><p class="mb-0">Total Games</p></div></div></div>
                        <div class="col-md-3"><div class="card stats-card bg-success text-white"><div class="card-body"><h4><?= number_format($total_categories) ?></h4><p class="mb-0">Total Categories</p></div></div></div>
                        <div class="col-md-3"><div class="card stats-card bg-warning text-dark"><div class="card-body"><h4><?= number_format($total_clicks) ?></h4><p class="mb-0">Total Clicks</p></div></div></div>
                        <div class="col-md-3"><div class="card stats-card bg-info text-dark"><div class="card-body"><h4><?= number_format($total_clicks / max($total_games, 1), 1) ?></h4><p class="mb-0">Average Clicks</p></div></div></div>
                    </div>
                    <div class="card stats-card"><div class="card-header"><strong>Top Games by Clicks</strong></div><div class="card-body table-responsive">
                        <table class="table table-striped"><thead><tr><th>Rank</th><th>Name</th><th>Clicks</th><th>Categories</th></tr></thead><tbody>
                        <?php $rank = 1; foreach ($hot_games as $game): ?>
                            <tr><td><?= $rank++ ?></td><td><?= e($game['name']) ?></td><td><?= number_format((int)$game['clicks']) ?></td><td><?= e($game['categories'] ?: 'Uncategorized') ?></td></tr>
                        <?php endforeach; ?>
                        </tbody></table>
                    </div></div>
                </section>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="gameModal" tabindex="-1">
    <div class="modal-dialog modal-lg"><div class="modal-content">
        <form method="post">
            <?= csrf_field() ?>
            <div class="modal-header"><h5 class="modal-title"><?= $edit_game ? 'Edit Game' : 'Add Game' ?></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <?php if ($edit_game): ?><input type="hidden" name="game_id" value="<?= (int)$edit_game['id'] ?>"><?php endif; ?>
                <div class="mb-3"><label class="form-label">Game Name *</label><input class="form-control" name="name" value="<?= e($edit_game['name'] ?? '') ?>" required></div>
                <div class="mb-3"><label class="form-label">Game URL *</label><input class="form-control" name="game_url" value="<?= e($edit_game['game_url'] ?? '') ?>" required></div>
                <div class="mb-3"><label class="form-label">Image URL *</label><input class="form-control" name="image_url" value="<?= e($edit_game['image_url'] ?? '') ?>" required></div>
                <div class="mb-3"><label class="form-label">Categories</label><div class="row">
                    <?php foreach ($categories as $category): ?>
                        <div class="col-md-4 mb-2"><label class="form-check"><input class="form-check-input" type="checkbox" name="category_ids[]" value="<?= (int)$category['id'] ?>" <?= in_array((int)$category['id'], $edit_game_category_ids, true) ? 'checked' : '' ?>> <span class="form-check-label"><?= e($category['category_name']) ?></span></label></div>
                    <?php endforeach; ?>
                </div></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="submit" name="<?= $edit_game ? 'edit_game' : 'add_game' ?>" value="1"><?= $edit_game ? 'Update Game' : 'Add Game' ?></button></div>
        </form>
    </div></div>
</div>

<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <form method="post">
            <?= csrf_field() ?>
            <div class="modal-header"><h5 class="modal-title"><?= $edit_category ? 'Edit Category' : 'Add Category' ?></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <?php if ($edit_category): ?><input type="hidden" name="category_id" value="<?= (int)$edit_category['id'] ?>"><?php endif; ?>
                <div class="mb-3"><label class="form-label">Category Name *</label><input class="form-control" name="category_name" value="<?= e($edit_category['category_name'] ?? '') ?>" required></div>
                <div class="mb-3"><label class="form-label">Sort Order</label><input class="form-control" type="number" name="sort_order" value="<?= e($edit_category['sort_order'] ?? 0) ?>"></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button class="btn btn-primary" type="submit" name="<?= $edit_category ? 'edit_category' : 'add_category' ?>" value="1"><?= $edit_category ? 'Update Category' : 'Add Category' ?></button></div>
        </form>
    </div></div>
</div>

<script src="common-file/js/bootstrap.bundle.min.js"></script>
<?php if ($edit_game): ?><script>document.addEventListener('DOMContentLoaded', function(){ new bootstrap.Modal(document.getElementById('gameModal')).show(); });</script><?php endif; ?>
<?php if ($edit_category): ?><script>document.addEventListener('DOMContentLoaded', function(){ new bootstrap.Modal(document.getElementById('categoryModal')).show(); });</script><?php endif; ?>
</body>
</html>
