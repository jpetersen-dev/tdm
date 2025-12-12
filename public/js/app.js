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

        // Excluir álbum específico por su ID de Spotify
        const filteredAlbums = albums.filter(album => album.id !== '2nemycrWx2BkZIRH9e1sh9');

        // Ordenar por fecha
        filteredAlbums.sort((a, b) => new Date(b.release_date) - new Date(a.release_date));

        filteredAlbums.forEach(album => {
            const imageUrl = album.images[0]?.url || 'assets/img/logo_tdm.jpg';
            const artists = album.artists.map(artist => artist.name).join(', ');
            
            // Lógica de tipo de producción simplificada y segura
            const albumType = album.album_type === 'single' ? 'Sencillo' : 'Álbum';

            // Formatear la fecha a dd-mm-aaaa
            const releaseDateObj = new Date(album.release_date);
            const formattedDate = releaseDateObj.toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
            });
            
            const card = document.createElement('div');
            card.className = 'album-card ink-effect'; 
            
            card.innerHTML = `
                <div class="album-art-wrapper">
                    <a href="${album.external_urls.spotify}" target="_blank" class="album-art-link">
                        <img src="${imageUrl}" alt="${album.name}" class="album-art">
                        <div class="album-overlay">
                            <span class="album-type">${albumType}</span>
                        </div>
                    </a>
                </div>
                <div class="album-info">
                    <h4 class="album-title">${album.name}</h4>
                    <p class="album-artist">${artists}</p>
                    <span class="album-date">${formattedDate}</span>
                    <a href="${album.external_urls.spotify}" target="_blank" class="album-link">Escuchar ↗</a>
                </div>
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
            artImage.style.borderColor = "#222"; // Reset to default border color
            artImage.style.boxShadow = "none"; // Remove red glow
            
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