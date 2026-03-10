<?php
session_start();
include __DIR__ . "/../components/database/db.php";

$error = "";

if ($_POST) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM usuarios WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
      $_SESSION['usuario'] = $user['email'];
      $_SESSION['usuario_id'] = $user['id'];
      header("Location: /PP/index.php");
      exit;
    } else {
      $error = "Contraseña incorrecta";
    }
  } else {
    $error = "El usuario no existe";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="/PP/css/style.css"></head>
  <script src="https://kit.fontawesome.com/55ab9a7e05.js" crossorigin="anonymous"></script>
<body>

<?php include __DIR__ . "/../components/header/header.php"; ?>

<main style="margin-top:120px; min-height:70vh; display:flex; flex-direction:column; align-items:center;">
  
  <div style="max-width:600px; text-align:center; margin-bottom:30px;">
    <h1 style="font-size:2.2em; margin-bottom:10px;">Bienvenido a Teatro Saturno</h1>
    <p style="font-size:1.1em; color:#555;">
      Iniciá sesión para acceder a tu perfil, comprar entradas y recibir novedades exclusivas.
    </p>
  </div>

  <form method="post" style="background:#fff; margin-top:50px; padding:40px; border-radius:20px; width:380px; box-shadow:0 12px 35px rgba(0,0,0,.25);">
    <h2 style="text-align:center; margin-bottom:20px;">Iniciar sesión</h2>

    <?php if ($error): ?>
      <p style="color:red; text-align:center; margin-bottom:15px;">
        <?= $error ?>
      </p>
    <?php endif; ?>

    <input type="email" name="email" placeholder="Email" required
      style="width:100%; padding:12px; margin-bottom:15px; border-radius:10px; border:1px solid #ccc;">

    <input type="password" name="password" placeholder="Contraseña" required
      style="width:100%; padding:12px; margin-bottom:20px; border-radius:10px; border:1px solid #ccc;">

    <button type="submit"
      style="width:100%; padding:12px; border:none; border-radius:10px; background:#7a139b; color:#fff; font-weight:bold; cursor:pointer;">
      Entrar
    </button>
  </form>

  <p style="text-align:center; margin-top:20px; font-size:0.95em; color:#555;">
  ¿Todavía no tenés cuenta?
  <a href="/PP/pages/register.php" style="color:#7a139b; font-weight:bold; text-decoration:none;">
    Registrate acá
  </a>
  </p>


</main>

<?php include __DIR__ . "/../components/footer/footer.php"; ?>

</body>
</html>
