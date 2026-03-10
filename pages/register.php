<?php
session_start();
include __DIR__ . "/../components/database/db.php";

$error = "";
$ok = "";

if ($_POST) {
  $nombre = trim($_POST['nombre']);
  $fecha_nacimiento = $_POST['fecha_nacimiento'];
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $pregunta = trim($_POST['pregunta_seguridad']);
  $respuesta = trim($_POST['respuesta_seguridad']);

  if (strlen($password) < 6) {
    $error = "La contraseña debe tener al menos 6 caracteres";
  } elseif ($pregunta === "" || $respuesta === "") {
    $error = "Debés completar la pregunta y respuesta de seguridad";
  } else {
    $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
      $error = "Ese email ya está registrado";
    } else {
      $hashPass = password_hash($password, PASSWORD_DEFAULT);
      $hashResp = password_hash($respuesta, PASSWORD_DEFAULT);

      $sql = "INSERT INTO usuarios 
        (nombre, fecha_nacimiento, email, password, foto, pregunta_seguridad, respuesta_seguridad)
        VALUES (?, ?, ?, ?, 'default.png', ?, ?)";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssssss", $nombre, $fecha_nacimiento, $email, $hashPass, $pregunta, $hashResp);

      if ($stmt->execute()) {
        $ok = "Usuario creado correctamente";
      } else {
        $error = "Error al crear el usuario";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear cuenta</title>
  <link rel="stylesheet" href="/PP/css/style.css">
  <script src="https://kit.fontawesome.com/55ab9a7e05.js" crossorigin="anonymous"></script>
</head>
<body>

<?php include __DIR__ . "/../components/header/header.php"; ?>

<main style="margin-top:120px; min-height:70vh; display:flex; flex-direction:column; align-items:center;">

  <div style="max-width:600px; text-align:center; margin-bottom:30px;">
    <h1 style="font-size:2.2em; margin-bottom:10px;">Crear cuenta</h1>
    <p style="font-size:1.1em; color:#555;">
      Registrate para comprar entradas y acceder a beneficios exclusivos.
    </p>
  </div>

  <form method="post" style="background:#fff; padding:40px; border-radius:20px; width:380px; box-shadow:0 12px 35px rgba(0,0,0,.25);">
    <h2 style="text-align:center; margin-bottom:20px;">Registro</h2>

    <?php if ($error): ?>
      <p style="color:red; text-align:center; margin-bottom:15px;"><?= $error ?></p>
    <?php endif; ?>

    <?php if ($ok): ?>
      <p style="color:green; text-align:center; margin-bottom:15px;"><?= $ok ?></p>
    <?php endif; ?>

    <input type="text" name="nombre" placeholder="Nombre completo" required
      style="width:100%; padding:12px; margin-bottom:15px; border-radius:10px; border:1px solid #ccc;">

    <input type="date" name="fecha_nacimiento" required
      style="width:100%; padding:12px; margin-bottom:15px; border-radius:10px; border:1px solid #ccc;">

    <input type="email" name="email" placeholder="Email" required
      style="width:100%; padding:12px; margin-bottom:15px; border-radius:10px; border:1px solid #ccc;">

    <input type="password" name="password" placeholder="Contraseña (mín. 6)" required
      style="width:100%; padding:12px; margin-bottom:15px; border-radius:10px; border:1px solid #ccc;">

    <select name="pregunta_seguridad" required
      style="width:100%; padding:12px; margin-bottom:15px; border-radius:10px; border:1px solid #ccc;">
      <option value="">Pregunta de seguridad</option>
      <option value="¿Nombre de tu primera mascota?">¿Nombre de tu primera mascota?</option>
      <option value="¿Ciudad donde naciste?">¿Ciudad donde naciste?</option>
      <option value="¿Tu película favorita?">¿Tu película favorita?</option>
      <option value="¿Nombre de tu escuela primaria?">¿Nombre de tu escuela primaria?</option>
    </select>

    <input type="text" name="respuesta_seguridad" placeholder="Respuesta de seguridad" required
      style="width:100%; padding:12px; margin-bottom:20px; border-radius:10px; border:1px solid #ccc;">

    <button type="submit"
      style="width:100%; padding:12px; border:none; border-radius:10px; background:#7a139b; color:#fff; font-weight:bold;">
      Crear usuario
    </button>
  </form>

  <p style="text-align:center; margin-top:20px; font-size:0.95em; color:#555;">
    ¿Ya tenés cuenta?
    <a href="/PP/pages/login.php" style="color:#7a139b; font-weight:bold; text-decoration:none;">
      Iniciar sesión
    </a>
  </p>

</main>

<?php include __DIR__ . "/../components/footer/footer.php"; ?>

</body>
</html>
