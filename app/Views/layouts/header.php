<?php
$siteTitle = isset($title) ? $title . ' · EligeCoche' : 'EligeCoche';
$pathNow = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$user = current_user();
$notice = take_flash();
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="EligeCoche: configura tu vehículo seleccionando carrocería, motor, pintura, ruedas y accesorios. Proyecto DAW de fabricación personalizada.">
<meta name="theme-color" content="#0b1425">
<title><?= e($siteTitle) ?></title>
<link rel="stylesheet" href="/assets/css/styles.css">
<script src="/assets/js/app.js" defer></script>
</head>
<body>
<a class="skip-link" href="#principal">Ir al contenido</a>
<header class="site-header">
 <div class="shell nav-bar">
  <a href="/" class="brand" aria-label="EligeCoche, inicio"><span class="brand-icon" aria-hidden="true">E<span class="brand-dot">.</span></span><span>ELIGE<span class="brand-accent">COCHE</span><small>BUILD YOUR DRIVE</small></span></a>
  <button class="menu-toggle" type="button" aria-label="Abrir menú" aria-controls="main-menu" aria-expanded="false"><span></span><span></span><span></span></button>
  <nav id="main-menu" class="main-nav" aria-label="Navegación principal">
    <a class="<?= $pathNow === '/' ? 'active' : '' ?>" href="/">Inicio</a>
    <a class="<?= in_array($pathNow, ['/configurador','/catalogo'], true) ? 'active' : '' ?>" href="/configurador">Configurador</a>
    <a class="<?= $pathNow === '/mercado' ? 'active' : '' ?>" href="/mercado">Mercado</a>
    <a class="<?= $pathNow === '/taller' ? 'active' : '' ?>" href="/taller">Taller</a>
    <a href="/proyecto">Proyecto</a>
    <?php if ($user): ?>
      <a href="<?= $user['role'] === 'staff' ? '/operarios' : '/pedidos' ?>" class="nav-account"><?= $user['role'] === 'staff' ? 'Panel de operarios' : 'Mis pedidos' ?></a>
      <form method="post" action="/salir" class="nav-logout"><?= csrf_field() ?><button type="submit" class="nav-logout-button">Salir</button></form>
    <?php else: ?>
      <a href="/acceder" class="nav-account">Acceder <span aria-hidden="true">↗</span></a>
    <?php endif; ?>
  </nav>
 </div>
</header>
<?php if ($notice): ?><div class="shell"><div class="flash <?= ($notice['type'] ?? '') === 'success' ? 'flash-success' : 'flash-error' ?>" role="status"><?= e($notice['message'] ?? '') ?></div></div><?php endif; ?>
<main id="principal">
