<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$title = $title ?? 'Dashboard';
$content = $content ?? '';
$css_path = $css_path ?? '';

$menu = [
    [
        'label' => 'Dashboard',
        'href' => '/inventaris_gudang_elektronik/view/dashboard',
        'icon' => 'bi-grid',
        'code' => 'dashboard',
    ],
    [
        'label' => 'Data Barang',
        'href' => '/inventaris_gudang_elektronik/view/data-barang',
        'icon' => 'bi-box',
        'code' => 'data-barang',
    ],
    [
        'label' => 'Data Kategori',
        'href' => '/inventaris_gudang_elektronik/view/data-kategori',
        'icon' => 'bi-tags',
        'code' => 'data-kategori',
    ],
    [
        'label' => 'Aktivitas Barang',
        'href' => '/inventaris_gudang_elektronik/view/aktivitas-barang',
        'icon' => 'bi-activity',
        'code' => 'aktivitas-barang',
    ],
];

function is_active($code)
{
    $uri = strtolower($_SERVER['REQUEST_URI'] ?? '');
    return strpos($uri, strtolower($code)) !== false ? 'active' : '';
}

function render_menu($menu)
{
    foreach ($menu as $item) {
        $active = is_active($item['code']);
        $href = htmlspecialchars($item['href']);
        $icon = htmlspecialchars($item['icon']);
        $label = htmlspecialchars($item['label']);
        echo <<<HTML
        <a href="{$href}" class="{$active}">
            <i class="bi {$icon}"></i>
            <span class="ms-2">{$label}</span>
        </a>
        HTML;
    }
}

function render_fixed_bottom()
{
    $member_active = is_active('/inventaris_gudang_elektronik/view/member');
    echo <<<HTML
    <div class="position-absolute bottom-0 mb-3 w-100 start-0">
        <div class="d-flex flex-column gap-2">
            <a href="/inventaris_gudang_elektronik/view/member/" class="{$member_active}">
                <i class="bi bi-people"></i>
                <span class="ms-2">Anggota Kelompok</span>
            </a>
            <a target="_blank" href="https://github.com/dendik-creation/inventaris_gudang_elektronik">
                <i class="bi bi-github"></i>
                <span class="ms-2">Kontribusi Projek</span>
            </a>
        </div>
    </div>
    HTML;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <?php if ($css_path): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($css_path) ?>">
    <?php endif; ?>
</head>

<body>
    <div class="d-flex">
        <nav class="sidebar position-sticky top-0">
            <h5 class="p-3">Inventaris Gudang Elektronik 📦</h5>
            <?php render_menu($menu); ?>
            <?php render_fixed_bottom(); ?>
        </nav>
        <div class="container-fluid p-4">
            <h2 class="mb-3"><?= htmlspecialchars($title) ?></h2>
            <?= $content ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        function renderToast(message, type = "info") {
            let background = "#3498db";
            if (type === "success") background = "#28a745";
            else if (type === "error") background = "#dc3545";
            else if (type === "warning") background = "#ffc107";
            Toastify({
                text: message,
                duration: 3000,
                gravity: "bottom",
                position: "right",
                backgroundColor: background,
                close: true,
            }).showToast();
        }
    </script>
    <?php if (isset($_SESSION['success_message'])): ?>
    <script>
        renderToast("<?= htmlspecialchars($_SESSION['success_message'], ENT_QUOTES) ?>", "success");
    </script>
    <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
</body>

</html>
