const pistas = window.pistas ?? [];
let i = Number(sessionStorage.getItem('sonora-indice') ?? 0);
if (i >= pistas.length) i = 0;
let t = Number(sessionStorage.getItem('sonora-tiempo') ?? 0);
let temporizador = null;
let aleatorio = false;
const favoritas = new Set(JSON.parse(localStorage.getItem('sonora-favs') ?? '[1]'));

const $ = (sel) => document.querySelector(sel);
const $$ = (sel) => document.querySelectorAll(sel);
const fmt = (s) => `${String(Math.floor(s / 60)).padStart(2, '0')}:${String(s % 60).padStart(2, '0')}`;

function guardarEstado() {
    try {
        sessionStorage.setItem('sonora-indice', String(i));
        sessionStorage.setItem('sonora-tiempo', String(t));
    } catch (_) {}
}

function pintar() {
    const p = pistas[i];
    if (!p) return;

    const pct = Math.min(100, Math.round((t / p.dur) * 100));

    // Barra inferior
    if ($('#titulo')) $('#titulo').textContent = p.titulo;
    if ($('#artista')) $('#artista').textContent = p.artista;
    if ($('#tiempo')) $('#tiempo').textContent = fmt(t);
    if ($('#duracion')) $('#duracion').textContent = fmt(p.dur);
    if ($('#relleno')) $('#relleno').style.width = `${pct}%`;
    if ($('#barra')) $('#barra').setAttribute('aria-valuenow', pct);

    // Vista Reproductor completo
    if ($('#rep-titulo')) $('#rep-titulo').textContent = p.titulo;
    if ($('#rep-artista')) $('#rep-artista').textContent = `${p.artista} · ${p.album}`;
    if ($('#rep-tiempo')) $('#rep-tiempo').textContent = fmt(t);
    if ($('#rep-duracion')) $('#rep-duracion').textContent = fmt(p.dur);
    if ($('#rep-relleno')) $('#rep-relleno').style.width = `${pct}%`;
    if ($('#rep-barra')) $('#rep-barra').setAttribute('aria-valuenow', pct);

    // Favoritos en vista Reproductor
    if ($('#btn-like')) {
        const esFav = favoritas.has(p.id);
        $('#btn-like').setAttribute('aria-pressed', esFav ? 'true' : 'false');
        $('#feedback-rep')?.classList.toggle('hidden', !esFav);
        $('#feedback-rep')?.classList.toggle('flex', esFav);
    }

    // Marcar fila activa en listas
    $$('[data-pista-id]').forEach((fila) => {
        if (Number(fila.dataset.pistaId) === p.id) fila.setAttribute('aria-current', 'true');
        else fila.removeAttribute('aria-current');
    });

    guardarEstado();
}

function reproduciendo() { return temporizador !== null; }

function pintarBoton() {
    const activo = reproduciendo();
    $('#icono-play')?.classList.toggle('hidden', activo);
    $('#icono-pausa')?.classList.toggle('hidden', !activo);
    $('#rep-icono-play')?.classList.toggle('hidden', activo);
    $('#rep-icono-pausa')?.classList.toggle('hidden', !activo);

    $$('[data-accion="alternar"]').forEach((btn) => {
        btn.setAttribute('aria-label', activo ? 'Pausar' : 'Reproducir');
    });
}

function reproducir() {
    clearInterval(temporizador);
    temporizador = setInterval(() => {
        t++;
        if (t >= pistas[i].dur) { cambiar(i + 1); return; }
        pintar();
    }, 1000);
    pintarBoton();
}

function pausar() {
    clearInterval(temporizador);
    temporizador = null;
    pintarBoton();
}

function cambiar(nueva) {
    if (!pistas.length) return;
    if (aleatorio && pistas.length > 1) {
        let azar;
        do { azar = Math.floor(Math.random() * pistas.length); } while (azar === i);
        i = azar;
    } else {
        i = (nueva + pistas.length) % pistas.length;
    }
    t = 0;
    pintar();
}

function ajustarProgreso(e, barraEl) {
    if (!pistas[i]) return;
    const rect = barraEl.getBoundingClientRect();
    const ratio = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
    t = Math.round(ratio * pistas[i].dur);
    pintar();
}

document.addEventListener('click', (e) => {
    const accion = e.target.closest('[data-accion]')?.dataset.accion;
    if (accion === 'alternar') { reproduciendo() ? pausar() : reproducir(); return; }
    if (accion === 'siguiente') { cambiar(i + 1); return; }
    if (accion === 'anterior') { cambiar(i - 1); return; }

    const fila = e.target.closest('[data-pista-id]');
    if (fila) {
        const idBuscado = Number(fila.dataset.pistaId);
        const idx = pistas.findIndex(p => p.id === idBuscado);
        if (idx !== -1) {
            i = idx;
            t = 0;
            pintar();
            reproducir();
        }
    }
});

// Botón Reproducir todo en vista Playlist
$('#btn-pl-reproducir')?.addEventListener('click', (e) => {
    const primerId = Number(e.currentTarget.dataset.primerTrack);
    const idx = pistas.findIndex(p => p.id === primerId);
    if (idx !== -1) { i = idx; t = 0; pintar(); reproducir(); }
});

// Botón Guardar playlist en biblioteca
$('#btn-pl-guardar')?.addEventListener('click', (e) => {
    const btn = e.currentTarget;
    const guardada = btn.getAttribute('aria-pressed') === 'true';
    btn.setAttribute('aria-pressed', guardada ? 'false' : 'true');
    $('#txt-pl-guardar').textContent = !guardada ? 'Quitar de tu biblioteca' : 'Guardar en tu biblioteca';
    $('#estado-pl-guardado').classList.toggle('hidden', guardada);
    $('#estado-pl-guardado').classList.toggle('flex', !guardada);
});

// Aleatorio, Me gusta y Volumen en vista Reproductor
$('#btn-shuffle')?.addEventListener('click', (e) => {
    aleatorio = !aleatorio;
    e.currentTarget.setAttribute('aria-pressed', aleatorio ? 'true' : 'false');
});

$('#btn-like')?.addEventListener('click', () => {
    const id = pistas[i]?.id;
    if (!id) return;
    if (favoritas.has(id)) favoritas.delete(id);
    else favoritas.add(id);
    localStorage.setItem('sonora-favs', JSON.stringify([...favoritas]));
    pintar();
});

$('#control-volumen')?.addEventListener('input', (e) => {
    $('#txt-volumen').textContent = `${e.target.value}%`;
});

// Barras de progreso interactivas (clic y flechas del teclado)
['#barra', '#rep-barra'].forEach((sel) => {
    const el = $(sel);
    if (!el) return;
    el.addEventListener('click', (e) => ajustarProgreso(e, el));
    el.addEventListener('keydown', (e) => {
        if (!pistas[i]) return;
        if (e.key === 'ArrowRight') { e.preventDefault(); t = Math.min(pistas[i].dur, t + 5); pintar(); }
        if (e.key === 'ArrowLeft') { e.preventDefault(); t = Math.max(0, t - 5); pintar(); }
    });
});

// Tema claro/oscuro persistente
const raiz = document.documentElement;
try { raiz.dataset.theme = localStorage.getItem('tema') ?? 'dark'; } catch (_) {}
function alternarTema() {
    raiz.dataset.theme = raiz.dataset.theme === 'dark' ? 'light' : 'dark';
    try { localStorage.setItem('tema', raiz.dataset.theme); } catch (_) {}
}
$('#tema')?.addEventListener('click', alternarTema);
$('#tema-movil')?.addEventListener('click', alternarTema);

pintar();