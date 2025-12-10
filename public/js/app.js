// --- REFERENCIAS DOM ---
const audio = document.getElementById('bg-audio');
const exploreBtn = document.getElementById('explore-btn');
const introScreen = document.getElementById('intro-screen');
const mainContent = document.getElementById('main-content');
const ambientBar = document.getElementById('ambient-bar');
const toggleBtn = document.getElementById('toggle-audio-btn');
const btnText = document.getElementById('btn-text');
const btnIcon = document.getElementById('btn-icon');
const liveDot = document.getElementById('live-dot');

const form = document.getElementById('fan-form');
const verifyForm = document.getElementById('verify-form');
const successView = document.getElementById('success-view');
const submitBtn = document.getElementById('submit-btn');
const verifyBtn = document.getElementById('verify-btn');
const verifyCodeInput = document.getElementById('verify-code');
const verifyError = document.getElementById('verify-error');
const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');

const artImage = document.getElementById('art-image');
const albumsGrid = document.getElementById('albums-grid');

// CAPAS DE FONDO
const engravingLayer = document.getElementById('engraving-layer');
const handwritingLayer = document.getElementById('handwriting-layer');

// --- ESTADO ---
let fadeInterval;
let isHoveringSpotify = false;
const maxVolume = 0.8;
let userEmail = "";

// --- 1. CARGA DE ÁLBUMES ---
async function loadAlbums() {
    try {
        const response = await fetch('api/albums.php');
        const data = await response.json(); 
        
        console.log("Respuesta Spotify:", data); // DEBUG

        albumsGrid.innerHTML = ''; 
        
        // FIX: Detectar si 'items' viene dentro del objeto o es el objeto
        const albums = data.items ? data.items : data; 

        if (!Array.isArray(albums) || albums.length === 0) {
            albumsGrid.innerHTML = '<p style="text-align:center; opacity:0.5;">No se encontraron archivos clasificados.</p>';
            return;
        }

        // Ordenar por fecha
        albums.sort((a, b) => new Date(b.release_date) - new Date(a.release_date));

        albums.forEach(album => {
            const embed = document.createElement('div');
            embed.className = 'spotify-embed';
            // Usamos innerHTML para inyectar el iframe
            embed.innerHTML = `
                <iframe 
                    src="https://open.spotify.com/embed/album/${album.id}?utm_source=generator&theme=0" 
                    width="100%" height="352" 
                    frameBorder="0" 
                    allowfullscreen="" 
                    allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture">
                </iframe>
            `;
            embed.addEventListener('mouseenter', () => isHoveringSpotify = true);
            embed.addEventListener('mouseleave', () => isHoveringSpotify = false);
            albumsGrid.appendChild(embed);
        });
    } catch (error) {
        console.error("Error cargando discografía:", error);
        albumsGrid.innerHTML = '<p style="text-align:center; opacity:0.5;">Conexión interrumpida.</p>';
    }
}
loadAlbums(); 

// --- 2. DETECTOR PLAY SPOTIFY ---
window.addEventListener('blur', () => {
    if (isHoveringSpotify) {
        console.log("Play Spotify.");
        fadeAudioTo(0);
        updatePlayerUI(false);
    }
});

// --- 3. INTERACCIÓN INICIAL ---
exploreBtn.addEventListener('click', () => {
    audio.volume = 0;
    audio.play().then(() => {
        fadeAudioTo(maxVolume);
        updatePlayerUI(true);
    }).catch(e => console.log("Auto-play prevenido", e));

    introScreen.style.opacity = '0';
    
    // Switch de fondos
    engravingLayer.classList.add('hidden');
    handwritingLayer.classList.add('visible');

    setTimeout(() => {
        introScreen.style.display = 'none';
        mainContent.style.visibility = 'visible';
        mainContent.style.opacity = '1';
        ambientBar.classList.add('visible');
    }, 800);
});

// --- 4. CONTROL DE AUDIO ---
toggleBtn.addEventListener('click', () => {
    if (audio.paused || audio.volume === 0) {
        audio.play();
        fadeAudioTo(maxVolume);
        updatePlayerUI(true);
    } else {
        fadeAudioTo(0);
        updatePlayerUI(false);
    }
});

function updatePlayerUI(isPlaying) {
    if (isPlaying) {
        btnText.textContent = "Pausar";
        btnIcon.innerHTML = `<rect width="4" height="16"/><rect x="8" width="4" height="16"/>`;
        liveDot.classList.add('active');
    } else {
        btnText.textContent = "Reproducir";
        btnIcon.innerHTML = `<path d="M0 0 L12 8 L0 16 Z"/>`;
        liveDot.classList.remove('active');
    }
}

function fadeAudioTo(targetVolume) {
    clearInterval(fadeInterval);
    fadeInterval = setInterval(() => {
        if (audio.volume < targetVolume - 0.05) audio.volume += 0.05;
        else if (audio.volume > targetVolume + 0.05) audio.volume -= 0.05;
        else {
            audio.volume = targetVolume;
            clearInterval(fadeInterval);
            if (targetVolume === 0) audio.pause();
            if (targetVolume > 0 && audio.paused) audio.play();
        }
    }, 100);
}

// --- 5. SUSCRIPCIÓN ---
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    submitBtn.innerHTML = "Generando Código...";
    submitBtn.style.opacity = "0.7";
    
    userEmail = emailInput.value;
    const userName = nameInput.value;
    const optIn = document.getElementById('opt-in').checked;

    try {
        const response = await fetch('api/subscribe.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email: userEmail, name: userName, optIn: optIn })
        });
        const data = await response.json();

        if (data.status === 'success') {
            form.style.display = 'none';
            verifyForm.style.display = 'block';
            verifyForm.style.animation = "fadeIn 1s forwards"; 
            verifyCodeInput.focus();
        } else {
            alert("Error: " + (data.message || "No se pudo procesar"));
            submitBtn.innerHTML = "Solicitar Acceso";
            submitBtn.style.opacity = "1";
        }
    } catch (error) {
        console.error("Error en suscripción:", error);
        alert("Error de conexión.");
        submitBtn.innerHTML = "Solicitar Acceso";
        submitBtn.style.opacity = "1";
    }
});

// --- 6. VERIFICACIÓN ---
verifyForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    verifyBtn.innerHTML = "Verificando...";
    verifyError.style.display = 'none';
    
    const code = verifyCodeInput.value;

    try {
        const response = await fetch('api/verify.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email: userEmail, code: code })
        });
        const data = await response.json();

        if (data.status === 'success') {
            verifyForm.style.display = 'none';
            successView.style.display = 'block';
            successView.style.animation = "fadeIn 1s forwards";
            
            artImage.style.filter = "grayscale(0%) contrast(1.1)";
            artImage.style.borderColor = "var(--accent)";
            artImage.style.boxShadow = "0 0 30px rgba(238, 64, 54, 0.3)";
            
            // Si quieres que el manuscrito se vea más intenso al final
            handwritingLayer.style.opacity = "0.8"; 
        } else {
            verifyError.style.display = 'block';
            verifyError.textContent = "Código incorrecto.";
            verifyBtn.innerHTML = "Desbloquear";
        }
    } catch (error) {
        verifyBtn.innerHTML = "Desbloquear";
        verifyError.style.display = 'block';
        verifyError.textContent = "Error de conexión.";
    }
});