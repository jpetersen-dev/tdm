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
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;700&display=swap" rel="stylesheet">
    
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="page-bg"></div>

    <div class="parallax-wrapper">
        <div class="bg-layer bg-engraving" id="engraving-layer" data-speed="0.2"></div>
        <div class="bg-layer bg-handwriting" id="handwriting-layer" data-speed="0.1"></div>
        <div class="bg-layer bg-noise"></div>
    </div>

    <!-- AUDIO LOOP -->
    <audio id="bg-audio" loop preload="auto">
        <source src="assets/audio/background_loop.mp3" type="audio/mpeg">
    </audio>

    <!-- PANTALLA INTRO -->
    <div id="intro-screen">
        <p class="intro-sup">DESCUBRE LO NUEVO DE</p>
        <h1 class="intro-highlight ink-effect">TEORÍA DE MAICOL</h1>
        
        <img src="assets/img/logo_tdm.jpg" alt="TDM Logo" class="intro-logo-img">
        
        <button id="explore-btn" class="intro-btn">COMENZAR</button>
    </div>

    <!-- BARRA REPRODUCTOR -->
    <div id="ambient-bar">
        <div class="track-info">
            <div class="live-indicator" id="live-dot"></div>
            <span>Estas escuchando: Se me va la onda (Instrumental)</span>
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
            <img src="assets/img/logo_tdm.jpg" alt="TDM Logo" class="main-logo">
            <div class="titles-wrapper">
                <h2 class="main-title ink-effect">TEORÍA DE MAICOL</h2>
                <h3 class="main-subtitle ink-effect delay-1">LANZAMIENTO EXCLUSIVO</h3>
            </div>

            <div class="card-wrapper">
                <img src="assets/img/cover.jpg" alt="Carátula Lo Peor" class="art-image" id="art-image">

                <h4 class="form-single-title">LO PEOR / <span class="lighter">NUEVO SINGLE 2025</span></h4>

                <form id="fan-form">
                    <p class="form-desc">
                        Déjanos tu contacto y desbloquea el acceso completo a nuestro material exclusivo. <br>
                        Podrás descargar el single <strong>"LO PEOR"</strong> con sus dos tracks:
                        <br><br>
                        1. Se me va la onda<br>
                        2. Terminó
                        <br><br>
                        Además te estaremos avisando de nuevas fechas, lanzamientos y otras cosillas.
                        <br><br>  

                        Más abajo puedes descubrir nuestras producciones anteriores !
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
                    
                    <p class="download-description">
                        ¡Gracias por tu apoyo! Aquí tienes el material exclusivo que desbloqueaste:
                    </p>

                    <div class="download-content-preview">
                        <h4>Contenido del paquete "LO PEOR (2025).rar":</h4>
                        <ul class="content-list">
                            <li><strong>Tracks del single:</strong>
                                <ul>
                                    <li>01. Se me va la onda (MP3)</li>
                                    <li>02. Terminó (MP3)</li>
                                </ul>
                            </li>
                            <li><strong>Arte:</strong>
                                <ul>
                                    <li>Cover Art oficial "Lo Peor" (JPG)</li>
                                    <li>Arte Extendido de "Lo Peor" (JPG)</li>
                                </ul>
                            </li>
                        </ul>
                        <p class="download-hint">Todo empaquetado en un archivo .RAR para tu comodidad.</p>
                    </div>

                    <a href="assets/downloads/LO PEOR - TEORIA DE MAICOL (2025).rar" download class="download-btn">
                        DESCARGAR PACK "LO PEOR"
                    </a>

                    <div class="download-options-uncompressed">
                        <p class="download-description-uncompressed">
                            ¿Problemas con el .RAR en tu móvil? Descarga el contenido sin comprimir aquí:
                        </p>
                        <h5 class="download-group-title">LO PEOR (Single 2025)</h5>
                        <a href="assets/downloads/Teoría de Maicol - LO PEOR (Single 2025)/01. Se me va la onda.mp3" download class="download-btn-small">
                            01. Se me va la onda (MP3)
                        </a>
                        <a href="assets/downloads/Teoría de Maicol - LO PEOR (Single 2025)/02. Terminó.mp3" download class="download-btn-small">
                            02. Terminó (MP3)
                        </a>
                        <a href="assets/downloads/Teoría de Maicol - LO PEOR (Single 2025)/Cover_art_Lo_Peor_Teoría_de_Maicol.jpg" download class="download-btn-small">
                            Cover Art (JPG)
                        </a>

                        <h5 class="download-group-title">Bonus</h5>
                        <a href="assets/downloads/Bonus/LO PEOR - Teoría de Maicol (Arte del Single Versión Etendida).JPG" download class="download-btn-small">
                            Arte del Single (Extendido JPG)
                        </a>
                    </div>

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
            <p class="scroll-hint">Desliza para explorar ‹ ›</p>
        </section>

        <footer>TEORÍA DE MAICOL © 2025</footer>
    </div>

    <!-- JS -->
    <script src="js/app.js"></script>
</body>
</html>