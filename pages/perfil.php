<?php
session_start();
include __DIR__ . "/../components/database/db.php";

if (!isset($_SESSION['usuario_id'])) {
  header("Location: /PP/pages/login.php");
  exit;
}

$usuario_id = $_SESSION['usuario_id'];
$seccion = $_GET['s'] ?? 'perfil';
$mensaje = "";
$mostrar_verificacion = false;
$verificado = false;

if ($seccion !== 'perfil') {
  unset($_SESSION['seguridad_ok']);
}

if (isset($_POST['iniciar_cambio'])) {
  $mostrar_verificacion = true;
}

if (isset($_POST['verificar'])) {
  $respuesta = $_POST['respuesta_seguridad'];

  $stmt = $conn->prepare("SELECT respuesta_seguridad FROM usuarios WHERE id = ?");
  $stmt->bind_param("i", $usuario_id);
  $stmt->execute();
  $hash = $stmt->get_result()->fetch_assoc()['respuesta_seguridad'];

  if (password_verify($respuesta, $hash)) {
    $_SESSION['seguridad_ok'] = true;
    $verificado = true;
  } else {
    $mensaje = "Respuesta incorrecta";
    $mostrar_verificacion = true;
  }
}

if (isset($_SESSION['seguridad_ok'])) {
  $verificado = true;
}

if (isset($_POST['guardar_seguridad']) && $verificado) {
  if (!empty($_POST['nuevo_email'])) {
    $stmt = $conn->prepare("UPDATE usuarios SET email = ? WHERE id = ?");
    $stmt->bind_param("si", $_POST['nuevo_email'], $usuario_id);
    $stmt->execute();
  }

  if (!empty($_POST['nueva_password'])) {
    $hashPass = password_hash($_POST['nueva_password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashPass, $usuario_id);
    $stmt->execute();
  }

  unset($_SESSION['seguridad_ok']);
  $verificado = false;
  $mostrar_verificacion = false;
  $mensaje = "Datos de seguridad actualizados correctamente";
}

if (isset($_POST['perfil'])) {
  $nombre = trim($_POST['nombre']);
  $fecha = $_POST['fecha_nacimiento'];
  $foto_sql = "";

  if (!empty($_FILES['foto']['name'])) {
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $nombre_foto = "user_" . $usuario_id . "_" . time() . "." . $ext;

    move_uploaded_file(
      $_FILES['foto']['tmp_name'],
      __DIR__ . "/../uploads/perfiles/" . $nombre_foto
    );

    $foto_sql = ", foto = '$nombre_foto'";
    $_SESSION['foto'] = $nombre_foto;
  }

  $sql = "UPDATE usuarios SET nombre = ?, fecha_nacimiento = ? $foto_sql WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssi", $nombre, $fecha, $usuario_id);
  $stmt->execute();

  $mensaje = "Perfil actualizado correctamente";
}

$stmt = $conn->prepare("SELECT nombre, email, fecha_nacimiento, foto, pregunta_seguridad FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$u = $stmt->get_result()->fetch_assoc();

$foto = $u['foto']
  ? "/PP/uploads/perfiles/" . $u['foto'] . "?v=" . time()
  : "/PP/uploads/perfiles/default.png";
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mi Cuenta</title>
<link rel="stylesheet" href="/PP/css/style.css">
<script src="https://kit.fontawesome.com/55a2b5b2d3.js" crossorigin="anonymous"></script>
</head>

<body>

<?php include __DIR__ . "/../components/header/header.php"; ?>

<main style="
  margin-top:120px;
  display:flex;
  padding:40px;
  gap:40px;
  padding-bottom:160px;
">

<aside style="width:240px;">
  <div style="background:#fff; padding:20px; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.15);">
    <img src="<?= $foto ?>" style="width:120px; height:120px; border-radius:50%; display:block; margin:0 auto 15px;">
    <h3 style="text-align:center;"><?= htmlspecialchars($u['nombre']) ?></h3>

    <a href="?s=perfil" style="display:block; padding:12px; margin-top:20px; border-radius:10px; text-decoration:none; background:<?= $seccion=='perfil'?'#7a139b':'#eee' ?>; color:<?= $seccion=='perfil'?'#fff':'#000' ?>;">👤 Perfil</a>

    <a href="?s=entradas" style="display:block; padding:12px; margin-top:10px; border-radius:10px; text-decoration:none; background:<?= $seccion=='entradas'?'#7a139b':'#eee' ?>; color:<?= $seccion=='entradas'?'#fff':'#000' ?>;">🎟️ Mis entradas</a>
  </div>
</aside>

<section style="flex:1;">
<div style="background:#fff; padding:40px; border-radius:20px; box-shadow:0 12px 35px rgba(0,0,0,.2);">

<?php if ($mensaje): ?>
<p style="color:green; margin-bottom:20px;"><?= $mensaje ?></p>
<?php endif; ?>

<?php if ($seccion === 'perfil'): ?>

<h1>Mi perfil</h1>

<form method="post" enctype="multipart/form-data">
<input type="hidden" name="perfil">

<div style="text-align:center; margin-bottom:20px;">
  <label for="foto" style="cursor:pointer;">
    <img id="previewFoto" src="<?= $foto ?>" style="width:140px; height:140px; border-radius:50%; object-fit:cover;">
    <div style="margin-top:10px; color:#7a139b; font-weight:bold;">
      Cambiar foto de perfil
    </div>
  </label>
  <input type="file" id="foto" name="foto" accept="image/*" style="display:none;" onchange="previewFotoPerfil(this)">
</div>

<input type="text" name="nombre" value="<?= htmlspecialchars($u['nombre']) ?>" required style="width:100%; padding:14px; margin-bottom:15px;">

<input type="date" name="fecha_nacimiento" value="<?= $u['fecha_nacimiento'] ?>" required style="width:100%; padding:14px; margin-bottom:15px;">

<input type="email" value="<?= htmlspecialchars($u['email']) ?>" disabled style="width:100%; padding:14px; background:#eee;">

<button style="width:100%; padding:14px; background:#7a139b; color:#fff; border:none; border-radius:12px; margin-top:20px;">
Guardar perfil
</button>
</form>

<hr style="margin:40px 0;">

<h2>Seguridad</h2>

<?php if (!$mostrar_verificacion && !$verificado): ?>
<form method="post">
<button name="iniciar_cambio" style="width:100%; padding:14px; background:#333; color:#fff; border:none; border-radius:12px;">
Cambiar mail o contraseña
</button>
</form>
<?php endif; ?>

<?php if ($mostrar_verificacion && !$verificado): ?>
<form method="post">
<p><b><?= htmlspecialchars($u['pregunta_seguridad']) ?></b></p>
<input type="password" name="respuesta_seguridad" required style="width:100%; padding:14px; margin-bottom:20px;">
<button name="verificar" style="width:100%; padding:14px; background:#333; color:#fff; border:none; border-radius:12px;">
Verificar identidad
</button>
</form>
<?php endif; ?>

<?php if ($verificado): ?>
<form method="post">
<input type="hidden" name="guardar_seguridad">

<input type="email" name="nuevo_email" placeholder="Nuevo email" style="width:100%; padding:14px; margin-bottom:15px;">

<input type="password" name="nueva_password" placeholder="Nueva contraseña" style="width:100%; padding:14px; margin-bottom:20px;">

<button style="width:100%; padding:14px; background:#7a139b; color:#fff; border:none; border-radius:12px;">
Guardar cambios
</button>
</form>
<?php endif; ?>

<?php else: ?>

<h1>Mis entradas</h1>
<p>Próximamente vas a ver acá tus entradas compradas.</p>

<?php endif; ?>

</div>
</section>
</main>

<?php include __DIR__ . "/../components/footer/footer.php"; ?>

<script>
function previewFotoPerfil(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => document.getElementById('previewFoto').src = e.target.result;
    reader.readAsDataURL(input.files[0]);
  }
}
</script>

</body>
</html>
