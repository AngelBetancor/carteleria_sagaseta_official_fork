<?php
define('BASE_URL', '/Proyectos/carteleria_sagaseta_official');
include_once 'src/db/cx_alert.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cartelería - Home</title>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/styles/base/normalize.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/styles/base/base.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/styles/header.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/styles/footer.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/styles/index.css">
</head>

<body>

  <div>
    <section>
      <?php
        // Mostrar las alertas si la función generaAlertasFechas se ejecuta
        if (isset($conn) && $conn) {
            generarAlertasFechas($conn);
        }
      ?>
    </section>

    <header class="header_container">
      <a href="<?php echo BASE_URL; ?>/index.php" class="logo_sagaseta_container"><img src="<?php echo BASE_URL; ?>/src/img/logo_sagaseta.svg" alt="logo" class="logo_sagaseta"></a>
      <h1 class="header_title">Concurso día de Canarias</h1>
    </header>

    <div class="nav">
      <a href="<?php echo BASE_URL; ?>/src/pages/participate.php">Participar</a>
      <a href="<?php echo BASE_URL; ?>/src/pages/results.php">Resultados</a>
      <a href="<?php echo BASE_URL; ?>/src/pages/gallery.php">Galería de carteles</a>
    </div>
  </div>

  <main>
    Espacio para el main del index
  </main>

  <footer class="footer_container">
    <div class="nav">
      <a href="<?php echo BASE_URL; ?>/src/pages/participate.php">Participar</a>
      <a href="<?php echo BASE_URL; ?>/src/pages/results.php">Resultados</a>
      <a href="<?php echo BASE_URL; ?>/src/pages/gallery.php">Galería de carteles</a>
    </div>
    <p>2ºDAW IES Fernando Sagaseta</p>
  </footer>

</body>

</html>
