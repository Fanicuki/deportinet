<?php

function deportinet_h($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function deportinet_lower(string $value): string
{
    return function_exists('mb_strtolower')
        ? mb_strtolower($value, 'UTF-8')
        : strtolower($value);
}

function deportinet_money($precio): string
{
    $n = (float) $precio;
    $decimals = abs($n - round($n)) < 0.001 ? 0 : 2;
    return '$ ' . number_format($n, $decimals, ',', '.');
}

function deportinet_public_category(array $category): bool
{
    return strpos(deportinet_lower((string) ($category['nombre_categoria'] ?? '')), 'defecto') === false;
}

function deportinet_tone(string $nombre): string
{
    $n = deportinet_lower($nombre);
    if (strpos($n, 'pelot') !== false) {
        return 'balls';
    }
    if (strpos($n, 'indument') !== false || strpos($n, 'remera') !== false || strpos($n, 'camis') !== false) {
        return 'apparel';
    }
    if (strpos($n, 'calz') !== false || strpos($n, 'botin') !== false || strpos($n, 'zapat') !== false) {
        return 'footwear';
    }
    return 'general';
}

function deportinet_request_filters(): array
{
    $q = trim((string) ($_GET['q'] ?? ''));
    $raw = (string) ($_GET['cat'] ?? 'all');
    $cat = ($raw === '' || $raw === 'all' || !ctype_digit($raw)) ? 'all' : (string) (int) $raw;
    return [$q, $cat];
}

function deportinet_matches(array $row, string $q, string $cat): bool
{
    if ($cat !== 'all' && (string) $row['id_categoria'] !== $cat) {
        return false;
    }
    if ($q === '') {
        return true;
    }
    $hay = deportinet_lower(
        ($row['nombre'] ?? '') . ' ' . ($row['descripcion'] ?? '') . ' ' . ($row['nombre_categoria'] ?? '')
    );
    return strpos($hay, deportinet_lower($q)) !== false;
}

function deportinet_resolve_table(mysqli $conn, array $candidates): ?string
{
    static $cache = [];
    $key = implode('|', $candidates);
    if (array_key_exists($key, $cache)) {
        return $cache[$key];
    }
    foreach ($candidates as $name) {
        $safe = str_replace('`', '', $name);
        try {
            $result = $conn->query("SHOW TABLES LIKE '" . $conn->real_escape_string($safe) . "'");
        } catch (Throwable $e) {
            $result = false;
        }
        if ($result instanceof mysqli_result && $result->num_rows > 0) {
            return $cache[$key] = $safe;
        }
    }
    return $cache[$key] = null;
}

function deportinet_productos(mysqli $conn, ?int $limit = null): ?array
{
    $productos = deportinet_resolve_table($conn, ['Productos', 'productos']);
    $categorias = deportinet_resolve_table($conn, ['Categorias', 'categorias']);
    if ($productos === null || $categorias === null) {
        return null;
    }
    $sql = "SELECT p.*, c.nombre_categoria
            FROM `$productos` p
            JOIN `$categorias` c ON p.id_categoria = c.id_categoria
            ORDER BY p.id_producto DESC";
    if ($limit !== null) {
        $sql .= ' LIMIT ' . (int) $limit;
    }
    try {
        $result = $conn->query($sql);
    } catch (Throwable $e) {
        return null;
    }
    if (!$result instanceof mysqli_result) {
        return null;
    }
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}

function deportinet_categorias(mysqli $conn): array
{
    $categorias = deportinet_resolve_table($conn, ['Categorias', 'categorias']);
    if ($categorias === null) {
        return [];
    }
    try {
        $result = $conn->query("SELECT * FROM `$categorias` ORDER BY nombre_categoria ASC");
    } catch (Throwable $e) {
        return [];
    }
    if (!$result instanceof mysqli_result) {
        return [];
    }
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}

function deportinet_safe_img($url): string
{
    $url = trim((string) $url);
    if ($url === '') {
        return '';
    }
    if (preg_match('#^https?://#i', $url)) {
        return $url;
    }
    if (preg_match('#^[\w./-]+$#', $url)) {
        return $url;
    }
    return '';
}

function deportinet_asset(array $opts, string $path): string
{
    $root = $opts['root'] ?? '';
    return $root . ltrim($path, '/');
}

function deportinet_open(array $opts): void
{
    $title = $opts['title'] ?? 'DeportiNet';
    $q = $opts['q'] ?? '';
    $cat = $opts['cat'] ?? 'all';
    $css = deportinet_asset($opts, 'cssMain/catalogo.css');
    $page = $opts['page'] ?? 'catalog';
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#9f1239">
    <title><?= deportinet_h($title) ?></title>
    <link rel="stylesheet" href="<?= deportinet_h($css) ?>">
</head>
<body class="storefront page-<?= deportinet_h($page) ?>" data-q="<?= deportinet_h($q) ?>" data-cat="<?= deportinet_h($cat) ?>">
    <div class="app-shell">
        <?php deportinet_sidebar($opts); ?>
        <div class="app-main">
            <?php deportinet_topbar($opts); ?>
    <?php
}

function deportinet_close(array $opts): void
{
    deportinet_toast();
    if (!empty($opts['admin_modal'])) {
        deportinet_admin_modal($opts['categories'] ?? []);
    }
    $js = deportinet_asset($opts, 'js/catalogo.js');
    ?>
        </div>
    </div>
    <script src="<?= deportinet_h($js) ?>"></script>
</body>
</html>
    <?php
}

function deportinet_sidebar(array $opts): void
{
    $active = $opts['active'] ?? '';
    $items = [
        ['key' => 'inicio', 'href' => $opts['home_href'], 'label' => 'Inicio', 'icon' => 'home'],
        ['key' => 'catalogo', 'href' => $opts['catalog_href'], 'label' => 'Catálogo', 'icon' => 'list'],
    ];
    if (!empty($opts['orders_href'])) {
        $items[] = ['key' => 'pedidos', 'href' => $opts['orders_href'], 'label' => 'Pedidos', 'icon' => 'clock'];
    }
    ?>
    <nav class="sidebar" id="sidebar" aria-label="Secciones">
        <p class="side-label">Menú</p>
        <?php foreach ($items as $item): ?>
            <a href="<?= deportinet_h($item['href']) ?>"<?= $active === $item['key'] ? ' aria-current="page"' : '' ?>>
                <?= deportinet_icon($item['icon']) ?>
                <span><?= deportinet_h($item['label']) ?></span>
            </a>
        <?php endforeach; ?>
    </nav>
    <button class="nav-backdrop" type="button" data-nav-backdrop hidden aria-label="Cerrar menú"></button>
    <?php
}

function deportinet_topbar(array $opts): void
{
    $brand = $opts['home_href'];
    $search = $opts['search_action'];
    ?>
    <header class="topbar">
        <button class="nav-toggle" type="button" data-nav-toggle aria-expanded="false" aria-controls="sidebar" aria-label="Abrir menú">
            <span></span><span></span><span></span>
        </button>
        <a class="brand" href="<?= deportinet_h($brand) ?>">
            <?= deportinet_icon('globe') ?>
            <span>DeportiNet</span>
        </a>
        <form class="searchbar" id="form" role="search" action="<?= deportinet_h($search) ?>" method="get">
            <label class="sr-only" for="query">Buscar productos</label>
            <input type="search" id="query" name="q" placeholder="Buscar pelotas, botines, remeras..." value="<?= deportinet_h($opts['q'] ?? '') ?>" autocomplete="off">
            <button type="submit" aria-label="Buscar">
                <?= deportinet_icon('search') ?>
            </button>
        </form>
        <div class="nav-actions">
            <?php if (($opts['auth'] ?? 'guest') === 'guest'): ?>
                <a class="btn-login" href="<?= deportinet_h($opts['login_href']) ?>">Iniciar sesión</a>
            <?php else: ?>
                <?php if (!empty($opts['cart_href'])): ?>
                    <a class="icon-btn" href="<?= deportinet_h($opts['cart_href']) ?>" aria-label="Carrito">
                        <?= deportinet_icon('cart') ?>
                        <span id="cart-count" class="cart-badge"<?= (int) ($opts['cart_count'] ?? 0) === 0 ? ' hidden' : '' ?>><?= (int) ($opts['cart_count'] ?? 0) ?></span>
                    </a>
                <?php endif; ?>
                <?php if (!empty($opts['usuario'])): ?>
                    <span class="user-chip"><?= deportinet_h($opts['usuario']) ?></span>
                <?php endif; ?>
                <div class="account">
                    <button class="icon-btn" type="button" data-account-toggle aria-expanded="false" aria-label="Cuenta">
                        <?= deportinet_icon('user') ?>
                    </button>
                    <div class="account-menu" data-account-menu hidden>
                        <a href="<?= deportinet_h($opts['logout_href']) ?>">Cerrar sesión</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </header>
    <?php
}

function deportinet_render_home(array $opts, ?array $products, array $categories): void
{
    $catalog = $opts['catalog_href'];
    $slides = [
        [
            'kicker' => 'Catálogo deportivo',
            'title' => 'Salí a la cancha',
            'text' => 'Pelotas, indumentaria y calzado para entrenar y competir.',
            'cta' => 'Ver catálogo',
            'href' => $catalog,
            'image' => 'https://i.pinimg.com/736x/fc/2d/3e/fc2d3e2f6283e20b536dc4864971e272.jpg',
        ],
        [
            'kicker' => 'Pelotas',
            'title' => 'La pelota del partido',
            'text' => 'Fútbol y básquet, en medidas oficiales y listas para usar.',
            'cta' => 'Ver pelotas',
            'href' => deportinet_tone_href($opts, $categories, 'balls'),
            'image' => 'https://i.pinimg.com/736x/51/f8/43/51f8430fbf1b5d19bacd9d858c38430d.jpg',
        ],
        [
            'kicker' => 'Indumentaria',
            'title' => 'Ropa para moverte',
            'text' => 'Remeras, camisetas y calzado pensados para el entrenamiento.',
            'cta' => 'Ver indumentaria',
            'href' => deportinet_tone_href($opts, $categories, 'apparel'),
            'image' => 'https://i.pinimg.com/564x/6f/39/0c/6f390c3851bf5d79a66724d5e01167eb.jpg',
        ],
    ];
    ?>
    <main class="main-content">
        <section class="hero" data-hero aria-roledescription="carrusel" aria-label="Destacados">
            <?php foreach ($slides as $i => $slide): ?>
                <article class="hero-slide<?= $i === 0 ? ' is-active' : '' ?>" data-slide style="--slide-image: url('<?= deportinet_h($slide['image']) ?>')" <?= $i === 0 ? '' : 'aria-hidden="true"' ?>>
                    <p class="eyebrow"><?= deportinet_h($slide['kicker']) ?></p>
                    <?php if ($i === 0): ?>
                        <h1 class="hero-title"><?= deportinet_h($slide['title']) ?></h1>
                    <?php else: ?>
                        <p class="hero-title"><?= deportinet_h($slide['title']) ?></p>
                    <?php endif; ?>
                    <p class="hero-text"><?= deportinet_h($slide['text']) ?></p>
                    <a class="btn-light" href="<?= deportinet_h($slide['href']) ?>"><?= deportinet_h($slide['cta']) ?></a>
                </article>
            <?php endforeach; ?>
            <div class="hero-dots" role="tablist" aria-label="Diapositivas">
                <?php foreach ($slides as $i => $slide): ?>
                    <button type="button" data-dot="<?= (int) $i ?>" role="tab" aria-label="<?= deportinet_h($slide['kicker']) ?>" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>" class="<?= $i === 0 ? 'is-active' : '' ?>"></button>
                <?php endforeach; ?>
            </div>
            <div class="hero-nav">
                <button type="button" data-hero-prev aria-label="Anterior"><?= deportinet_icon('chevron-left') ?></button>
                <button type="button" data-hero-next aria-label="Siguiente"><?= deportinet_icon('chevron-right') ?></button>
            </div>
        </section>

        <ul class="trust-bar">
            <li>Stock visible en cada producto</li>
            <li>Filtrá por categoría en un toque</li>
            <li><?= ($opts['auth'] ?? '') === 'cliente' ? 'Sumalo al carrito cuando quieras' : 'El mismo catálogo para ver y comprar' ?></li>
        </ul>

        <section class="home-block" aria-labelledby="cats-title">
            <div class="section-head">
                <h2 id="cats-title">Categorías</h2>
            </div>
            <div class="cat-grid">
                <?php
                $shown = 0;
                foreach ($categories as $category):
                    if (!deportinet_public_category($category)) {
                        continue;
                    }
                    $name = (string) $category['nombre_categoria'];
                    $tone = deportinet_tone($name);
                    $shown++;
                    ?>
                    <a class="cat-tile tone-<?= deportinet_h($tone) ?>" href="<?= deportinet_h($catalog . '?cat=' . (int) $category['id_categoria']) ?>">
                        <span class="cat-kicker">Categoría</span>
                        <strong><?= deportinet_h($name) ?></strong>
                        <em>Ver productos</em>
                    </a>
                <?php endforeach; ?>
                <?php if ($shown === 0): ?>
                    <p class="muted">Todavía no hay categorías cargadas.</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="home-block" aria-labelledby="latest-title">
            <div class="section-head">
                <h2 id="latest-title">Últimos productos</h2>
                <a class="link-more" href="<?= deportinet_h($catalog) ?>">Ver catálogo</a>
            </div>
            <?php if ($products === null): ?>
                <div class="catalog-empty is-static">
                    <h3>No pudimos cargar los productos</h3>
                    <p>Revisá que la base de datos de DeportiNet esté activa.</p>
                </div>
            <?php elseif (count($products) === 0): ?>
                <div class="catalog-empty is-static">
                    <h3>El catálogo está vacío</h3>
                    <p>Cuando haya productos, van a aparecer en esta vidriera.</p>
                </div>
            <?php else: ?>
                <div class="catalog-grid">
                    <?php foreach ($products as $i => $row): ?>
                        <?= deportinet_card($row, $opts, $i) ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        <?php deportinet_footer(); ?>
    </main>
    <?php
}

function deportinet_render_catalog(array $opts, ?array $products, array $categories): void
{
    $q = (string) ($opts['q'] ?? '');
    $cat = (string) ($opts['cat'] ?? 'all');
    $visible = 0;
    if (is_array($products)) {
        foreach ($products as $row) {
            if (deportinet_matches($row, $q, $cat)) {
                $visible++;
            }
        }
    }
    ?>
    <main class="main-content">
        <header class="catalog-hero">
            <div>
                <p class="eyebrow">DeportiNet</p>
                <h1>Catálogo</h1>
                <p class="lede">Pelotas, indumentaria y calzado. Elegí categoría, ordená por precio y encontrá lo que necesitás para el próximo partido.</p>
            </div>
            <div class="hero-aside">
                <div class="hero-stat">
                    <strong data-catalog-count><?= (int) $visible ?> <?= $visible === 1 ? 'producto' : 'productos' ?></strong>
                    <span>disponibles ahora</span>
                </div>
                <?php if (!empty($opts['admin_modal'])): ?>
                    <button class="btn-solid" type="button" data-open-modal>Añadir producto</button>
                <?php endif; ?>
            </div>
        </header>

        <div class="catalog-toolbar">
            <div class="chips" role="tablist" aria-label="Filtrar por categoría">
                <button class="chip<?= $cat === 'all' ? ' is-active' : '' ?>" type="button" data-filter="all">Todos</button>
                <?php foreach ($categories as $category): ?>
                    <?php
                    if (!deportinet_public_category($category)) {
                        continue;
                    }
                    $id = (string) (int) $category['id_categoria'];
                    ?>
                    <button class="chip<?= $cat === $id ? ' is-active' : '' ?>" type="button" data-filter="<?= deportinet_h($id) ?>">
                        <?= deportinet_h($category['nombre_categoria']) ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <label class="sort-control">
                <span>Ordenar</span>
                <select data-sort aria-label="Ordenar productos">
                    <option value="recent">Más recientes</option>
                    <option value="price-asc">Menor precio</option>
                    <option value="price-desc">Mayor precio</option>
                    <option value="name">Nombre</option>
                </select>
            </label>
        </div>

        <p class="results-line">
            <span data-catalog-query><?= $q !== '' ? 'Resultados para “' . deportinet_h($q) . '”' : 'Todo el catálogo' ?></span>
        </p>

        <?php if ($products === null): ?>
            <div class="catalog-empty is-static">
                <h2>No pudimos cargar el catálogo</h2>
                <p>Revisá la conexión con la base de datos e intentá de nuevo.</p>
            </div>
        <?php elseif (count($products) === 0): ?>
            <div class="catalog-empty is-static">
                <h2>Todavía no hay productos</h2>
                <p>Cuando se publiquen, vas a verlos acá en una grilla.</p>
            </div>
        <?php else: ?>
            <div class="catalog-grid" data-catalog-grid>
                <?php foreach ($products as $i => $row): ?>
                    <?php $show = deportinet_matches($row, $q, $cat); ?>
                    <?= deportinet_card($row, $opts, $i, $show) ?>
                <?php endforeach; ?>
            </div>
            <div class="catalog-empty" data-catalog-empty <?= $visible === 0 ? '' : 'hidden' ?>>
                <h2>Nada coincide con esa búsqueda</h2>
                <p>Probá con otra palabra o volvé a ver el catálogo completo.</p>
                <button class="btn-solid" type="button" data-reset-filters>Ver todo</button>
            </div>
        <?php endif; ?>
        <?php deportinet_footer(); ?>
    </main>
    <?php
}

function deportinet_card(array $row, array $opts, int $index, bool $show = true): string
{
    $name = (string) ($row['nombre'] ?? '');
    $desc = trim((string) preg_replace('/\s+/', ' ', (string) ($row['descripcion'] ?? '')));
    $catName = (string) ($row['nombre_categoria'] ?? '');
    $tone = deportinet_tone($catName);
    $img = deportinet_safe_img($row['img'] ?? '');
    $stock = (int) ($row['stock'] ?? 0);
    $id = (int) ($row['id_producto'] ?? 0);
    $price = (float) ($row['precio'] ?? 0);
    $delay = min($index, 12);
    $auth = $opts['auth'] ?? 'guest';

    if ($stock <= 0) {
        $stockLabel = 'Agotado';
        $stockClass = 'is-out';
        $stockCopy = 'Sin stock';
    } elseif ($stock <= 8) {
        $stockLabel = 'Últimas';
        $stockClass = 'is-low';
        $stockCopy = $stock . ' en stock';
    } else {
        $stockLabel = 'En stock';
        $stockClass = '';
        $stockCopy = $stock . ' disponibles';
    }

    $num = str_pad((string) (($id % 99) + 1), 2, '0', STR_PAD_LEFT);
    $hidden = $show ? '' : ' hidden';
    $new = $index < 2 && $stock > 0 ? '<span class="flag-new">Nuevo</span>' : '';

    $media = '<div class="product-media">';
    if ($img !== '') {
        $media .= '<img src="' . deportinet_h($img) . '" alt="' . deportinet_h($name) . '" loading="lazy" decoding="async">';
    }
    $media .= '<div class="media-fallback tone-' . deportinet_h($tone) . '">' . deportinet_fallback_art($tone, $num) . '</div>';
    $media .= $new;
    $media .= '<span class="stock-pill ' . $stockClass . '">' . deportinet_h($stockLabel) . '</span>';
    $media .= '<span class="media-chip">' . deportinet_h($catName) . '</span>';
    $media .= '</div>';

    $actions = '';
    if ($auth === 'cliente') {
        $disabled = $stock <= 0 ? ' disabled' : '';
        $max = max($stock, 1);
        $actions = '<form class="add-cart" method="post" action="' . deportinet_h($opts['add_action']) . '">'
            . '<input type="hidden" name="product_id" value="' . $id . '">'
            . '<div class="qty">'
            . '<button type="button" data-qty="-1" aria-label="Reducir cantidad"' . $disabled . '>−</button>'
            . '<input name="cantidad" value="1" inputmode="numeric" min="1" max="' . $max . '" aria-label="Cantidad"' . ($stock <= 0 ? ' disabled' : '') . '>'
            . '<button type="button" data-qty="1" aria-label="Aumentar cantidad"' . $disabled . '>+</button>'
            . '</div>'
            . '<button class="btn-cart" type="submit"' . $disabled . '>' . ($stock <= 0 ? 'Agotado' : 'Añadir') . '</button>'
            . '</form>';
    } elseif ($auth === 'guest') {
        $actions = '<a class="btn-cart" href="' . deportinet_h($opts['login_href']) . '">Comprar</a>';
    } else {
        $actions = '<p class="admin-note">ID ' . $id . ' · publicación interna</p>';
    }

    return '<article class="product-card" style="--i:' . $delay . '" data-id="' . $id . '" data-price="' . deportinet_h(number_format($price, 2, '.', '')) . '" data-name="' . deportinet_h($name) . '" data-description="' . deportinet_h($desc) . '" data-category="' . deportinet_h($catName) . '" data-category-id="' . (int) $row['id_categoria'] . '"' . $hidden . '>'
        . $media
        . '<div class="product-body">'
        . '<h3>' . deportinet_h($name) . '</h3>'
        . '<p>' . deportinet_h($desc) . '</p>'
        . '<div class="price-row"><span class="price">' . deportinet_h(deportinet_money($price)) . '</span><span class="stock-copy">' . deportinet_h($stockCopy) . '</span></div>'
        . $actions
        . '</div></article>';
}

function deportinet_fallback_art(string $tone, string $num): string
{
    if ($tone === 'balls') {
        return '<svg viewBox="0 0 120 120" aria-hidden="true"><circle cx="60" cy="60" r="46" stroke="#fff" stroke-width="3" fill="none"/><path d="M60 16l16 18H44L60 16zM60 104l-16-18h32L60 104z" fill="#fff"/><path d="M18 50l14 4 6 18-18 6-10-14 8-14zM102 50l-14 4-6 18 18 6 10-14-8-14z" fill="#fff" opacity=".8"/><circle cx="60" cy="60" r="7" fill="#fff"/></svg>';
    }
    if ($tone === 'apparel') {
        return '<span class="jersey-num">' . deportinet_h($num) . '</span><svg viewBox="0 0 120 120" aria-hidden="true"><path d="M36 30l24 14 24-14 18 12-12 16v46H30V58L18 42l18-12z" fill="rgba(255,255,255,.16)" stroke="#fff" stroke-width="3"/><path d="M48 44c3 8 21 8 24 0" stroke="#fff" stroke-width="3" fill="none"/></svg>';
    }
    if ($tone === 'footwear') {
        return '<svg viewBox="0 0 200 120" aria-hidden="true"><path fill="#fff" d="M48 90V58q0-18 20-16l22-16q18-6 28 12l38 4q22 8 24 28 2 14-14 20z"/><rect x="28" y="88" width="156" height="18" rx="9" fill="#fff"/><path d="M86 48h18M86 56h22M108 48h18M108 56h18" stroke="#1a1214" stroke-width="3" stroke-linecap="round" opacity=".55"/><path d="M64 70c28 8 70 6 96-10" stroke="#1a1214" stroke-width="4" fill="none" opacity=".28" stroke-linecap="round"/></svg>';
    }
    return '<svg viewBox="0 0 120 120" aria-hidden="true"><circle cx="60" cy="60" r="36" stroke="#fff" stroke-width="3" fill="none"/><path d="M60 28v64M28 60h64" stroke="#fff" stroke-width="3"/></svg>';
}

function deportinet_tone_href(array $opts, array $categories, string $tone): string
{
    foreach ($categories as $category) {
        if (deportinet_tone((string) $category['nombre_categoria']) === $tone) {
            return $opts['catalog_href'] . '?cat=' . (int) $category['id_categoria'];
        }
    }
    return $opts['catalog_href'];
}

function deportinet_footer(): void
{
    ?>
    <footer class="store-footer">
        <span>DeportiNet</span>
        <span>Catálogo deportivo</span>
    </footer>
    <?php
}

function deportinet_toast(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE || empty($_SESSION['flash'])) {
        return;
    }
    $type = $_SESSION['flash_type'] ?? 'ok';
    $message = (string) $_SESSION['flash'];
    unset($_SESSION['flash'], $_SESSION['flash_type']);
    if ($type !== 'error') {
        $type = 'ok';
    }
    echo '<div class="toast-note toast-' . $type . '" role="status">' . deportinet_h($message) . '</div>';
}

function deportinet_admin_modal(array $categories): void
{
    ?>
    <div class="product-modal" id="addProductModal" hidden>
        <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <button class="modal-close" type="button" data-close-modal aria-label="Cerrar">&times;</button>
            <p class="eyebrow">Nuevo</p>
            <h2 id="modal-title">Añadir producto</h2>
            <form class="stack-form" method="post" action="añadir_producto.php">
                <label class="field"><span>Nombre</span><input type="text" name="nombre" maxlength="100" required></label>
                <label class="field"><span>Descripción</span><textarea name="descripcion" rows="3" required></textarea></label>
                <div class="field-row">
                    <label class="field"><span>Precio</span><input type="number" name="precio" min="0" step="0.01" required></label>
                    <label class="field"><span>Stock</span><input type="number" name="stock" min="0" step="1" required></label>
                </div>
                <label class="field">
                    <span>Categoría</span>
                    <select name="id_categoria" required>
                        <?php if (count($categories) === 0): ?>
                            <option value="1">Pelotas</option>
                            <option value="2">Indumentaria deportiva</option>
                            <option value="3">Calzado deportivo</option>
                        <?php else: ?>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= (int) $category['id_categoria'] ?>"><?= deportinet_h($category['nombre_categoria']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </label>
                <label class="field"><span>Foto (enlace, opcional)</span><input type="url" name="img" maxlength="200" placeholder="https://"></label>
                <button class="btn-solid" type="submit">Publicar en el catálogo</button>
            </form>
        </div>
    </div>
    <?php
}

function deportinet_icon(string $name): string
{
    $common = 'width="22" height="22" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" viewBox="0 0 24 24" aria-hidden="true"';
    switch ($name) {
        case 'globe':
            return '<svg width="34" height="34" fill="none" stroke="#c1121f" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.8 3.8 5.8 3.8 9S14.5 18.2 12 21c-2.5-2.8-3.8-5.8-3.8-9S9.5 5.8 12 3z"/></svg>';
        case 'home':
            return '<svg ' . $common . '><path d="M4 10.5 12 4l8 6.5V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1v-9.5z"/></svg>';
        case 'list':
            return '<svg ' . $common . '><path d="M9 6h11M9 12h11M9 18h11"/><circle cx="5" cy="6" r="1" fill="currentColor" stroke="none"/><circle cx="5" cy="12" r="1" fill="currentColor" stroke="none"/><circle cx="5" cy="18" r="1" fill="currentColor" stroke="none"/></svg>';
        case 'clock':
            return '<svg ' . $common . '><circle cx="12" cy="12" r="8"/><path d="M12 8v5l3 2"/></svg>';
        case 'search':
            return '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>';
        case 'cart':
            return '<svg ' . $common . '><path d="M6 6h15l-1.5 9h-12z"/><path d="M6 6 5 3H2"/><circle cx="9" cy="20" r="1.2" fill="currentColor" stroke="none"/><circle cx="18" cy="20" r="1.2" fill="currentColor" stroke="none"/></svg>';
        case 'user':
            return '<svg ' . $common . '><circle cx="12" cy="8" r="3.2"/><path d="M5 19.2a7 7 0 0 1 14 0"/></svg>';
        case 'chevron-left':
            return '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 6 8 12l6 6"/></svg>';
        case 'chevron-right':
            return '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="m10 6 6 6-6 6"/></svg>';
        default:
            return '';
    }
}
