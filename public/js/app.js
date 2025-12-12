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

let fadeInterval;
let userEmail = "";
const maxVolume = 0.8;

// --- 1. EFECTO TINTA (Ink Reveal) ---
const observerOptions = { threshold: 0.1 };
const inkObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('revealed');
        }
    });
}, observerOptions);

document.querySelectorAll('.ink-effect').forEach(el => inkObserver.observe(el));

// --- 3. CARGA DE ÁLBUMES (Diseño Personalizado) ---
async function loadAlbums() {
    try {
        const response = await fetch('api/albums.php');
        const data = await response.json(); 
        const albums = data.items ? data.items : data; 

        albumsGrid.innerHTML = ''; 

        if (!Array.isArray(albums) || albums.length === 0) {
            albumsGrid.innerHTML = '<p class="loading-text">No hay lanzamientos disponibles.</p>';
            return;
        }

        // Ordenar por fecha
        albums.sort((a, b) => new Date(b.release_date) - new Date(a.release_date));

        albums.forEach(album => {
            const releaseYear = album.release_date.split('-')[0];
            const imageUrl = album.images[0]?.url || 'assets/img/logo_tdm.jpg';

            const card = document.createElement('div');
            card.className = 'album-card ink-effect'; 
            
            card.innerHTML = `
                <a href="${album.external_urls.spotify}" target="_blank">
                    <img src="${imageUrl}" alt="${album.name}" class="album-art">
                </a>
                <h4 class="album-title">${album.name}</h4>
                <span class="album-date">Lanzamiento: ${album.release_date}</span>
                <a href="${album.external_urls.spotify}" target="_blank" class="album-link">Escuchar en Spotify ↗</a>
            `;
            
            albumsGrid.appendChild(card);
            inkObserver.observe(card);
        });

    } catch (error) {
        console.error("Error cargando discografía:", error);
        albumsGrid.innerHTML = '<p class="loading-text">Conexión interrumpida con Spotify.</p>';
    }
}
loadAlbums();

// --- 4. INTERACCIÓN INTRO ---
exploreBtn.addEventListener('click', () => {
    audio.volume = 0;
    audio.play().then(() => {
        fadeAudioTo(maxVolume);
        updatePlayerUI(true);
    }).catch(e => console.log("Auto-play prevenido", e));

    introScreen.style.opacity = '0';
    engravingLayer.classList.add('hidden');
    handwritingLayer.classList.add('visible');

    setTimeout(() => {
        introScreen.style.display = 'none';
        mainContent.style.visibility = 'visible';
        mainContent.style.opacity = '1';
        ambientBar.classList.add('visible');
    }, 800);
});

// --- 5. CONTROL AUDIO ---
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

// --- 6. FORMULARIO & VERIFICACIÓN ---
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    submitBtn.innerHTML = "Procesando...";
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
            verifyCodeInput.focus();
        } else {
            alert("Error: " + (data.message || "No se pudo procesar"));
            submitBtn.innerHTML = "Solicitar Acceso";
        }
    } catch (error) {
        console.error(error);
        alert("Error de conexión.");
        submitBtn.innerHTML = "Solicitar Acceso";
    }
});

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
            
            artImage.style.filter = "grayscale(0%) contrast(1.1)";
            artImage.style.borderColor = "var(--accent)";
            artImage.style.boxShadow = "0 0 40px rgba(238, 64, 54, 0.5)";
            
            handwritingLayer.style.opacity = "0.5"; 
            
        } else {
            verifyError.style.display = 'block';
            verifyBtn.innerHTML = "Desbloquear";
        }
    } catch (error) {
        verifyBtn.innerHTML = "Desbloquear";
        verifyError.style.display = 'block';
    }
});

// --- 7. SLIDER DRAG-TO-SCROLL (NUEVO) ---
let isDown = false;
let startX;
let scrollLeft;

albumsGrid.addEventListener('mousedown', (e) => {
    isDown = true;
    albumsGrid.classList.add('active'); // Cursor "grabbing"
    startX = e.pageX - albumsGrid.offsetLeft;
    scrollLeft = albumsGrid.scrollLeft;
});

albumsGrid.addEventListener('mouseleave', () => {
    isDown = false;
    albumsGrid.classList.remove('active');
});

albumsGrid.addEventListener('mouseup', () => {
    isDown = false;
    albumsGrid.classList.remove('active');
});

albumsGrid.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    
    e.preventDefault(); // Importante para evitar seleccionar texto
    
    const x = e.pageX - albumsGrid.offsetLeft;
    const walk = (x - startX) * 2; // Velocidad de arrastre (x2)
    albumsGrid.scrollLeft = scrollLeft - walk;
});