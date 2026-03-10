<?php include __DIR__ . "/../components/database/db.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cartelera - Teatro Saturno</title>
  <link rel="stylesheet" href="../css/style2.css">
</head>
<body>
<?php include __DIR__ . "/../components/header/header.php"; ?>

<main>
  <h2>Cartelera</h2>

  <div class="cartelera-grid">
    <?php
      $sql = "SELECT * FROM shows ORDER BY id ASC";
      $result = $conn->query($sql);

      while($row = $result->fetch_assoc()):
        $imgPath = "/PP/components/img/shows/" . $row['imagen'];
    ?>
    <div class="show-card">
      <img src="<?php echo $imgPath; ?>" alt="<?php echo $row['nombre']; ?>">
      <div class="show-info">
        <h3><?php echo $row['nombre']; ?></h3>
        <p><?php echo $row['descripcion']; ?></p>
        <span>Próximamente</span>
      </div>
    </div>
    <?php endwhile; ?>
  </div>

</main>

<?php include __DIR__ . "/../components/footer/footer.php"; ?>
</body>
</html>
