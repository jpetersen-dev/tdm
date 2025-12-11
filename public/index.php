<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría de Maicol | Lo Peor</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400&family=Syne:wght@400;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <audio id="bg-audio" loop preload="auto">
        <source src="assets/audio/background_loop.mp3" type="audio/mpeg">
    </audio>

    <div class="parallax-wrapper">
        <div class="bg-layer bg-engraving" id="engraving-layer" data-speed="0.2"></div>
        <div class="bg-layer bg-handwriting" id="handwriting-layer" data-speed="0.1"></div>
        <div class="bg-layer bg-noise"></div>
    </div>

    <div id="intro-screen">
        <p class="intro-sup">DESCUBRE LO NUEVO DE</p>
        <h1 class="intro-highlight ink-effect">TEORÍA DE MAICOL</h1>
        
        <img src="assets/img/logo_tdm.jpg" alt="TDM Logo" class="intro-logo-img">
        
        <button id="explore-btn" class="intro-btn">COMENZAR</button>
    </div>

    <div id="ambient-bar">
        <div class="track-info">
            <div class="live-indicator" id="live-dot"></div>
            <span>Ambiente: Materia Prima (Inst)</span>
        </div>
        <button id="toggle-audio-btn" class="control-btn">
            <span id="btn-text">Pausar</span>
            <svg id="btn-icon" class="control-icon" viewBox="0 0 12 16"><rect width="4" height="16"/><rect x="8" width="4" height="16"/></svg>
        </button>
    </div>

    <div id="main-content">
        
        <section class="hero-section">
            <div class="titles-wrapper">
                <h2 class="main-title gradient-text ink-effect">TEORÍA DE MAICOL</h2>
                <h3 class="main-subtitle ink-effect delay-1">LO PEOR / <span class="lighter">NUEVO SINGLE 2025</span></h3>
            </div>

            <div class="card-wrapper">
                <img src="assets/img/cover.jpg" alt="Carátula Lo Peor" class="art-image" id="art-image">

                <form id="fan-form">
                    <p class="form-desc">
                        Déjanos tu contacto para descargar <strong>LO PEOR</strong> y un bonus sorpresa <strong>EXCLUSIVO</strong>.<br>
                        Además te estaremos avisando de nuevas fechas, lanzamientos y otras cosillas.
                    </p>

                    <div class="input-group">
                        <input type="text" id="name" placeholder="Nombre o Apodo" required autocomplete="name">
                    </div>
                    <div class="input-group">
                        <input type="email" id="email" placeholder="tu@email.com" required autocomplete="email">
                    </div>
                    
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="opt-in" required>
                        <label for="opt-in">Acepto recibir novedades de Teoría de Maicol.</label>
                    </div>
                    
                    <button type="submit" class="submit-btn" id="submit-btn">Solicitar Acceso</button>
                </form>

                <form id="verify-form" style="display: none;">
                    <h3 class="success-title">Verificar Identidad</h3>
                    <p class="form-desc">Código enviado a tu correo.</p>
                    <div class="input-group">
                        <input type="text" id="verify-code" placeholder="CÓDIGO" required maxlength="6" class="code-input">
                    </div>
                    <button type="submit" class="submit-btn" id="verify-btn">Desbloquear</button>
                    <p id="verify-error" class="error-msg">Código incorrecto.</p>
                </form>

                <div id="success-view">
                    <h3 class="success-title ink-effect">CÓDIGO VERIFICADO</h3>
                    <p class="success-text">
                        Gracias por ser parte de nuestra comunidad.<br>
                        Te mantendremos al tanto de nuestros movimientos.<br><br>
                        <span style="color: var(--accent);">Hemos liberado este material exclusivo para ti.</span>
                    </p>
                    
                    <a href="assets/downloads/TDM_Single_Master.wav" download class="download-btn">
                        DESCARGAR "LO PEOR"
                    </a>
                    <a href="assets/downloads/TDM_Manuscrito.pdf" download class="download-btn secondary">
                        DESCARGAR MANUSCRITO ORIGINAL
                    </a>

                    <div class="legal-footer">
                        <small>Todos los derechos reservados © Teoría de Maicol 2025.<br>
                        Prohibida su copia, venta o distribución no autorizada.</small>
                    </div>
                </div>
            </div>
        </section>

        <section class="discography-section">
            <h2 class="section-title ink-effect">Lanzamientos Previos</h2>
            <p class="section-subtitle">Escucha nuestro catálogo y agréganos a tus listas.</p>
            
            <div class="albums-grid" id="albums-grid">
                <p class="loading-text">Cargando discografía...</p>
            </div>
        </section>

        <footer>TEORÍA DE MAICOL © 2025</footer>
    </div>

    <script src="js/app.js"></script>
</body>
</html>