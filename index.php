<?php include __DIR__ . "/components/database/db.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teatro Saturno</title>
  <link rel="stylesheet" href="/PP/css/style.css">
  <script src="https://kit.fontawesome.com/55ab9a7e05.js" crossorigin="anonymous"></script>
  <link rel="icon" href="/PP/components/img/gglogo.png" type="image/png">
</head>
<body>

<?php include __DIR__ . "/components/header/header.php"; ?>

<div class="banner">
  <img src="/PP/components/img/teatro.jpg" alt="Teatro Saturno">
  <div class="banner-text">
    <h1>Bienvenidos al Teatro Saturno</h1>
    <p>Descubrí nuestras próximas funciones, eventos y actividades culturales.</p>
    <p><a href="/PP/pages/cartelera.php" class="btn-banner">Ver cartelera completa →</a></p>
  </div>
</div>

<main>
  <section class="shows-section destacados">
    <h2>Shows Destacados</h2>

    <div class="slider-container">
      <button class="slider-btn prev" onclick="slideDestacados(-1)">‹</button>

      <div class="slider-track" id="sliderDestacados">
        <?php
          $sql = "SELECT * FROM shows WHERE destacado = 1 AND tipo = 'show' ORDER BY id DESC";
          $result = $conn->query($sql);

          while ($row = $result->fetch_assoc()):
            $imgPath = "/PP/components/img/shows/" . $row['imagen'];
        ?>
          <div class="show-card destacado-card">
            <div class="show-img">
              <img src="<?php echo $imgPath; ?>" alt="<?php echo $row['nombre']; ?>">
            </div>
            <div class="show-info">
              <h3><?php echo $row['nombre']; ?></h3>
              <p><?php echo $row['descripcion']; ?></p>
              <span>★ Destacado</span>
            </div>
          </div>
        <?php endwhile; ?>
      </div>

      <button class="slider-btn next" onclick="slideDestacados(1)">›</button>
    </div>
  </section>

  <section class="shows-section proximos">
    <h2>Próximos Shows</h2>

    <div class="shows-grid">
      <?php
        $sql = "SELECT * FROM shows WHERE tipo = 'show' ORDER BY id ASC LIMIT 6";
        $result = $conn->query($sql);
        $totalShows = $result->num_rows;

        while ($row = $result->fetch_assoc()):
          $imgPath = "/PP/components/img/shows/" . $row['imagen'];
      ?>
        <div class="show-card">
          <div class="show-img">
            <img src="<?php echo $imgPath; ?>" alt="<?php echo $row['nombre']; ?>">
          </div>
          <div class="show-info">
            <h3><?php echo $row['nombre']; ?></h3>
            <p><?php echo $row['descripcion']; ?></p>
            <span>Próximamente</span>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <?php if ($totalShows >= 6): ?>
      <div class="shows-btn-container">
        <a href="/PP/pages/cartelera.php" class="btn-ver-mas">Ver cartelera completa →</a>
      </div>
    <?php endif; ?>
  </section>

</main>

<?php include __DIR__ . "/components/footer/footer.php"; ?>

<script>
  let sliderIndex = 0;

  function slideDestacados(direction) {
    const track = document.getElementById('sliderDestacados');
    const card = track.querySelector('.show-card');
    const cardWidth = card.offsetWidth + 32;
    sliderIndex += direction;
    track.scrollTo({
      left: sliderIndex * cardWidth,
      behavior: 'smooth'
    });
  }
</script>

</body>
</html>
