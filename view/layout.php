<?php
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
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <?php if ($css_path): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($css_path) ?>">
    <?php endif; ?>
</head>

<body>
    <div class="d-flex">
        <nav class="sidebar position-sticky top-0 vh-100 overflow-hidden" style="height:100vh;">
            <h5 class="p-3">Inventaris Gudang Elektronik 📦</h5>
            <?php foreach ($menu as $item): 
                $active = strpos(strtolower($_SERVER['REQUEST_URI']), strtolower($item['code'])) !== false ? 'active' : '';
            ?>
            <a href="<?= htmlspecialchars($item['href']) ?>" class="<?= $active ?>">
                <i class="bi <?= htmlspecialchars($item['icon']) ?>"></i>
                <span class="ms-2"><?= htmlspecialchars($item['label']) ?></span>
            </a>
            <?php endforeach; ?>
            <div class="position-absolute bottom-0 mb-3 w-100 start-0">
                <div class="d-flex flex-column gap-2">
                    <?php
                        $active = strpos(strtolower($_SERVER['REQUEST_URI']), '/inventaris_gudang_elektronik/view/member') !== false ? 'active' : '';
                    ?>
                    <a href="/inventaris_gudang_elektronik/view/member/" class="<?= $active ?>">
                        <i class="bi bi-people"></i>
                        <span class="ms-2">Anggota Kelompok</span>
                    </a>
                    <a target="_blank" href="https://github.com/dendik-creation/inventaris_gudang_elektronik">
                        <i class="bi bi-github"></i>
                        <span class="ms-2">Kontribusi Projek</span>
                    </a>
                </div>
            </div>
        </nav>
        <div class="container-fluid p-4">
            <h2 class="mb-3"><?= htmlspecialchars($title) ?></h2>
            <?= $content ?>
        </div>
    </div>
</body>

</html>
