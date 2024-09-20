

const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');

// Tamaño del canvas y funcionalidad responsive
function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}

resizeCanvas();
window.addEventListener('resize', resizeCanvas);

// Variables para el juego
let isDrawing = false;
let startX, startY, startItem;
let lines = [];
let correctCount = 0;
let usedItems = new Set();  // Para asegurarse de que cada imagen solo se una una vez
let timerStarted = false;
let timerInterval;
let startTime;
const items = document.querySelectorAll('.item-container');
const successSound = document.getElementById('success-sound');
const correctCountElement = document.getElementById('correct-count');
const timerElement = document.getElementById('timer');

// Función para obtener las coordenadas de un elemento
function getElementCoordinates(element) {
    const rect = element.getBoundingClientRect();
    return {
        x: rect.left + rect.width / 2,
        y: rect.top + rect.height / 2
    };
}

// Evitar selección de texto o imágenes
items.forEach(item => {
    item.addEventListener('mousedown', (e) => {
        e.preventDefault();
        startLine(e);
    });
    item.addEventListener('mouseup', (e) => {
        e.preventDefault();
        endLine(e);
    });
});

function startLine(e) {
    if (!timerStarted) {
        startTimer();
        timerStarted = true;
    }
    const coords = getElementCoordinates(e.currentTarget);
    startX = coords.x;
    startY = coords.y;
    startItem = e.currentTarget;

    // Verificar si el elemento ya ha sido usado
    if (usedItems.has(startItem)) return;

    isDrawing = true;
    canvas.addEventListener('mousemove', drawLine);
    document.addEventListener('mouseup', resetLine);
}

function endLine(e) {
    if (!isDrawing) return;

    const coords = getElementCoordinates(e.currentTarget);
    const endX = coords.x;
    const endY = coords.y;

    const startImageAlt = startItem.querySelector('img').alt;
    const endImageAlt = e.currentTarget.querySelector('img').alt;

    if (startImageAlt === endImageAlt && startItem !== e.currentTarget && !usedItems.has(startItem) && !usedItems.has(e.currentTarget)) {
        lines.push({ startX, startY, endX, endY });
        successSound.play();
        correctCount += 10;
        correctCountElement.textContent = correctCount;
        usedItems.add(startItem);
        usedItems.add(e.currentTarget);
    } else {
        // Añadir clase de error visual cuando no coincidan
        startItem.classList.add('error');
        e.currentTarget.classList.add('error');
        setTimeout(() => {
            startItem.classList.remove('error');
            e.currentTarget.classList.remove('error');
        }, 500);  // Tiempo para mostrar el efecto de error
    }

    canvas.removeEventListener('mousemove', drawLine);
    document.removeEventListener('mouseup', resetLine);
    clearCanvas();
    drawAllLines();
    isDrawing = false;
}


function drawLine(e) {
    if (!isDrawing) return;

    clearCanvas();
    drawAllLines();

    const currentX = e.clientX;
    const currentY = e.clientY;

    ctx.beginPath();
    ctx.moveTo(startX, startY);
    ctx.lineTo(currentX, currentY);
    ctx.strokeStyle = '#00f';
    ctx.lineWidth = 4;
    ctx.stroke();
    ctx.closePath();
}

function drawAllLines() {
    lines.forEach(line => {
        ctx.beginPath();
        ctx.moveTo(line.startX, line.startY);
        ctx.lineTo(line.endX, line.endY);
        ctx.strokeStyle = '#00f';
        ctx.lineWidth = 4;
        ctx.stroke();
        ctx.closePath();
    });
}

function clearCanvas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

function resetLine() {
    if (isDrawing) {
        clearCanvas();
        drawAllLines();
        isDrawing = false;
        canvas.removeEventListener('mousemove', drawLine);
        document.removeEventListener('mouseup', resetLine);
    }
}

// Función de reinicio
document.getElementById('btn-reset').addEventListener('click', () => {
    lines = [];
    clearCanvas();
    correctCount = 0;
    correctCountElement.textContent = correctCount;
    usedItems.clear();
    resetTimer();
});



// Función para iniciar el temporizador
function startTimer() {
    startTime = Date.now();
    timerInterval = setInterval(() => {
        const elapsedTime = Date.now() - startTime;
        const seconds = Math.floor(elapsedTime / 1000);
        timerElement.textContent = `Tiempo: ${seconds}s`;
    }, 1000);
}

// Función para reiniciar el temporizador
function resetTimer() {
    clearInterval(timerInterval);
    timerElement.textContent = 'Tiempo: 0s';
    timerStarted = false;
}



function guardarProgreso(usuarioId, juegoId, respuestasCorrectas, tiempo) {
    fetch('/php/guardar_progreso.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            usuarioId: usuarioId,  // Ahora se pasa el ID del usuario de la sesión
            juegoId: juegoId,
            respuestasCorrectas: correctCount,
            tiempo: timerElement.textContent.replace('Tiempo: ', '').replace('s', ''),
            idModulo: 1  // Se agrega el id_modulo con modulo 1
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Progreso guardado:', data);
    })
    .catch(error => {
        console.error('Error al guardar el progreso:', error);
    });
}


// Llamar a esta función cuando el usuario termine la prueba
document.getElementById('btn-redirigir').addEventListener('click', function() {
    guardarProgreso(usuarioId, 1,correctCount, timerElement.textContent);
    redirigir();
});


function mostrarMensajeError() {
    const mensajeError = document.createElement('div');
    mensajeError.id = 'mensaje-error';
    mensajeError.textContent = 'Inténtalo de nuevo';
    document.body.appendChild(mensajeError);

    // Elimina el mensaje después de 5 segundos
    setTimeout(() => {
        mensajeError.remove();
    }, 1000);
}

function endLine(e) {
    if (!isDrawing) return;

    const coords = getElementCoordinates(e.currentTarget);
    const endX = coords.x;
    const endY = coords.y;

    const startImageAlt = startItem.querySelector('img').alt;
    const endImageAlt = e.currentTarget.querySelector('img').alt;

    if (startImageAlt === endImageAlt && startItem !== e.currentTarget && !usedItems.has(startItem) && !usedItems.has(e.currentTarget)) {
        lines.push({ startX, startY, endX, endY });
        successSound.play();  
        correctCount += 10;  
        correctCountElement.textContent = correctCount;
        usedItems.add(startItem);
        usedItems.add(e.currentTarget);
    } else {
        mostrarMensajeError();  // Mostrar el mensaje si la unión no es correcta
    }

    canvas.removeEventListener('mousemove', drawLine);
    document.removeEventListener('mouseup', resetLine);
    clearCanvas();
    drawAllLines();
    isDrawing = false;
}
