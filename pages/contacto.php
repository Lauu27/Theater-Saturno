<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contacto - Teatro Saturno</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    /* Body y tipografía */
    body {
      font-family: 'Nunito', sans-serif;
      margin: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background-color: #fafafa;
      padding-top: 80px; /* altura del header fijo */
    }

    /* Main */
    main {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px 20px;
      gap: 40px;
    }

    h2 {
      font-size: 2.5rem;
      color: #222;
      margin: 0;
      text-align: center;
    }

    /* Contenedor de tarjetas */
    .contact-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 25px;
      width: 100%;
      max-width: 600px;
    }

    /* Tarjetas de contacto */
    .contact-card {
      padding: 20px;
      border-radius: 10px;
      background-color: #fff;
      width: 100%;
      text-align: center;
      transition: background-color 0.2s;
    }

    .contact-card:hover {
      background-color: #f0f0f0;
    }

    .contact-card p {
      margin: 0;
      font-size: 1.1rem;
      color: #333;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .contact-card span {
      font-size: 1.5rem;
      color: #a91bd4;
    }

    /* Mapa */
    .map-container {
      width: 100%;
      max-width: 600px;
      height: 350px;
      border-radius: 10px;
      overflow: hidden;
    }

    .map-container iframe {
      width: 100%;
      height: 100%;
      border: 0;
    }

    /* Responsive */
    @media (max-width: 600px) {
      main {
        padding: 30px 15px;
        gap: 30px;
      }
      .map-container {
        height: 250px;
      }
    }
  </style>
</head>
<body>
  <?php include "../components/header/header.php"; ?>

  <main>
    <h2>Contacto</h2>

    <div class="contact-container">
      <div class="contact-card">
        <p><span>📍</span>Obelisco, Buenos Aires</p>
      </div>
      <div class="contact-card">
        <p><span>📞</span>11 - 5022 - 2208</p>
      </div>
      <div class="contact-card">
        <p><span>📧</span>info@teatrosaturno.com</p>
      </div>
    </div>

    <div class="map-container">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3280.7930020740936!2d-58.380866284773864!3d-34.60373828045874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcca4b0c15c3f7%3A0x9b0e5e83d3c6f9a9!2sObelisco%2C%20Buenos%20Aires%2C%20Argentina!5e0!3m2!1ses!2sar!4v1702268525315!5m2!1ses!2sar" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>

  </main>

  <?php include "../components/footer/footer.php"; ?>
</body>
</html>
