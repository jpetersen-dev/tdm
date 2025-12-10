<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría de Maicol | Lo Peor</title>
    
    <!-- FUENTES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400&family=Syne:wght@400;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- AUDIO LOOP -->
    <audio id="bg-audio" loop preload="auto">
        <source src="assets/audio/background_loop.mp3" type="audio/mpeg">
    </audio>

    <!-- CAPAS VISUALES -->
    <div class="bg-layer bg-engraving" id="engraving-layer"></div>
    <div class="bg-layer bg-handwriting" id="handwriting-layer"></div>
    <div class="bg-layer bg-noise"></div>

    <!-- PANTALLA INTRO -->
    <div id="intro-screen">
        <img src="assets/img/logo_tdm.jpg" alt="TDM Logo" class="intro-logo-img">
        <button id="explore-btn" class="intro-btn">Explora la Teoría</button>
    </div>

    <!-- BARRA REPRODUCTOR -->
    <div id="ambient-bar">
        <div class="track-info">
            <div class="live-indicator" id="live-dot"></div>
            <span>Ambiente: Lo Peor (Inst)</span>
        </div>
        <button id="toggle-audio-btn" class="control-btn">
            <span id="btn-text">Pausar</span>
            <svg id="btn-icon" class="control-icon" viewBox="0 0 12 16"><rect width="4" height="16"/><rect x="8" width="4" height="16"/></svg>
        </button>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div id="main-content">
        <!-- SECCIÓN HERO -->
        <section class="hero-section">
            <h1 class="logo">Teoría de Maicol</h1>
            <p class="subtitle">Lo Peor / Single DIC 2025</p>

            <div class="card-wrapper">
                <img src="assets/img/cover.jpg" alt="Carátula" class="art-image" id="art-image">

                <!-- VISTA 1: REGISTRO -->
                <form id="fan-form">
                    <div class="input-group">
                        <input type="text" id="name" placeholder="Nombre o Apodo" required autocomplete="name">
                    </div>
                    <div class="input-group">
                        <input type="email" id="email" placeholder="tu@email.com" required autocomplete="email">
                    </div>
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="opt-in" required>
                        <label for="opt-in">Acepto recibir comunicaciones de Teoría de Maicol.</label>
                    </div>
                    <button type="submit" class="submit-btn" id="submit-btn">Solicitar Acceso</button>
                </form>

                <!-- VISTA 2: VERIFICACIÓN -->
                <form id="verify-form" style="display: none;">
                    <h3 class="success-title" style="text-align: center; font-size: 1.2rem;">Verificar Identidad</h3>
                    <p style="font-size: 0.8rem; text-align: center; margin-bottom: 1.5rem; color: #aaa;">
                        Código enviado a tu correo.
                    </p>
                    <div class="input-group">
                        <input type="text" id="verify-code" placeholder="CÓDIGO" required 
                               style="text-align: center; letter-spacing: 5px; font-size: 1.5rem; text-transform: uppercase;" maxlength="6">
                    </div>
                    <button type="submit" class="submit-btn" id="verify-btn">Desbloquear</button>
                    <p id="verify-error" style="color: var(--accent); font-size: 0.8rem; text-align: center; margin-top: 15px; display: none;">Código incorrecto.</p>
                </form>

                <!-- VISTA 3: ÉXITO -->
                <div id="success-view">
                    <h3 class="success-title">Conexión Establecida</h3>
                    <p class="success-text" style="margin-bottom: 2rem; color: #ccc;">El material ha sido liberado.</p>
                    <a href="assets/downloads/TDM_Single_Master.wav" download class="download-btn">Descargar Canción <small>WAV • Master</small></a>
                    <a href="assets/downloads/TDM_Manuscrito.pdf" download class="download-btn">Descargar Manuscrito <small>PDF • Original</small></a>
                </div>
            </div>
        </section>

        <!-- DISCOGRAFÍA -->
        <section class="discography-section">
            <h2 class="section-title">Archivos Previos</h2>
            <div class="albums-grid" id="albums-grid">
                <p style="text-align:center; opacity:0.5; width:100%;">Cargando...</p>
            </div>
        </section>

        <footer>TEORÍA DE MAICOL © 2025</footer>
    </div>

    <!-- JS -->
    <script src="js/app.js"></script>
</body>
</html>