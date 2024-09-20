const dropArea = document.getElementById('dropArea');
const imageArea = document.getElementById('imageArea');
const correctSound = document.getElementById('correctSound');
const scoreElement = document.getElementById('score');
const timeElapsedElement = document.getElementById('timeElapsed');
const errorMessage = document.getElementById('errorMessage'); // Agregar elemento de mensaje de error
let draggedImage = null;
let score = 0;
let timer;
let timeElapsed = 0;

const ordenCorrecto = ["Imagen 1", "Imagen 2", "Imagen 3","Imagen 4"];
let ordenActual = [];

document.querySelectorAll('.draggable').forEach(image => {
    image.addEventListener('dragstart', function (event) {
        draggedImage = event.target;
        setTimeout(() => (event.target.style.visibility = 'hidden'), 0);
        if (!timer) {
            startTimer();
        }
    });

    image.addEventListener('dragend', function (event) {
        setTimeout(() => (event.target.style.visibility = 'visible'), 0);
    });
});

dropArea.addEventListener('dragover', function (event) {
    event.preventDefault();
});

dropArea.addEventListener('drop', function (event) {
    event.preventDefault();
    if (draggedImage) {
        const altText = draggedImage.getAttribute('alt');
        const nextPosition = ordenActual.length;

        if (ordenCorrecto[nextPosition] === altText) {
            draggedImage.style.visibility = 'visible';
            dropArea.appendChild(draggedImage);
            draggedImage.draggable = false;
            ordenActual.push(altText);

            score += 10;
            scoreElement.textContent = score;

            correctSound.play();

            if (ordenActual.length === ordenCorrecto.length) {
                clearInterval(timer);
                guardarDatos(score); // Llamada para guardar datos
            }
        } else {
            mostrarError("Orden incorrecto. Intenta de nuevo."); // Mostrar mensaje de error
            draggedImage.style.visibility = 'visible';
        }
    }
});

function shuffleImages() {
    const images = Array.from(document.querySelectorAll('.draggable'));
    for (let i = images.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [images[i], images[j]] = [images[j], images[i]];
    }
    images.forEach(img => imageArea.appendChild(img));
}

document.getElementById('resetButton').addEventListener('click', function () {
    ordenActual = [];
    score = 0;
    scoreElement.textContent = score;
    timeElapsed = 0;
    timeElapsedElement.textContent = timeElapsed + 's';
    clearInterval(timer);
    timer = null;

    document.querySelectorAll('.draggable').forEach(image => {
        image.draggable = true;
        image.style.visibility = 'visible'; // Asegurarse de que sean visibles
        imageArea.appendChild(image);
    });
    shuffleImages();
});


function startTimer() {
    timer = setInterval(() => {
        timeElapsed++;
        timeElapsedElement.textContent = timeElapsed + 's';
    }, 1000);
}

document.getElementById('navigateButton').addEventListener('click', function () {
    const score = scoreElement.textContent;  // Obtener el puntaje
    const id_juego = 9;  // id del juego fijo ACA LO TENGO QUE CAMBIAR EN LOS DEMAS 
    const id_modulo = 3;  // id del módulo fijo

    // Realizar la solicitud POST a PHP
    fetch('/php/progresoPalabras.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            score: score,
            id_juego: id_juego,
            id_modulo: id_modulo,
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirigir a otra página si se guarda correctamente
            window.location.href = "principal.php";
        } else {
            alert('Error al guardar el progreso.');
        }
    })
    .catch(error => console.error('Error:', error));
});


function mostrarError(mensaje) {
    errorMessage.textContent = mensaje;
    errorMessage.style.display = 'block'; // Mostrar mensaje de error
    setTimeout(() => {
        errorMessage.style.display = 'none'; // Ocultarlo después de 5 segundos
    }, 5000);
}

shuffleImages();
