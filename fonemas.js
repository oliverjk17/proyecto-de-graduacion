
const images = [
    { src: 'fonemas/fonemaP/pala.png', audio: 'fonemas/fonemaP/pala.mp3', phoneme: 'P' },
    { src: 'fonemas/fonemaP/pato.png', audio: 'fonemas/fonemaP/pato.mp3', phoneme: 'P' },
    { src: 'fonemas/fonemaL/lapiz.png', audio: 'fonemas/fonemaL/lapiz.mp3', phoneme: 'L' },
    { src: 'fonemas/fonemaL/leche.png', audio: 'fonemas/fonemaL/leche.mp3', phoneme: 'L' },
    { src: 'fonemas/fonemaR/rama.png', audio: 'fonemas/fonemaR/rama.mp3', phoneme: 'R' },
    { src: 'fonemas/fonemaR/raton.png', audio: 'fonemas/fonemaR/raton.mp3', phoneme: 'R' },
];

const generalContainer = document.getElementById('general-container');
const containers = {
    P: document.getElementById('container-p'),
    L: document.getElementById('container-l'),
    R: document.getElementById('container-r')
};

images.forEach((image, index) => {
    const img = document.createElement('img');
    img.src = image.src;
    img.draggable = true;
    img.dataset.phoneme = image.phoneme;
    img.dataset.index = index;
    img.addEventListener('click', () => {
        const audio = new Audio(image.audio);
        audio.play();
    });
    img.addEventListener('dragstart', dragStart);
    generalContainer.appendChild(img);
});

function dragStart(event) {
    event.dataTransfer.setData('src', event.target.src);
    event.dataTransfer.setData('phoneme', event.target.dataset.phoneme);
    event.dataTransfer.setData('index', event.target.dataset.index);
}

Object.keys(containers).forEach(phoneme => {
    containers[phoneme].addEventListener('dragover', dragOver);
    containers[phoneme].addEventListener('drop', drop);
});

function dragOver(event) {
    event.preventDefault();
}
const successSound = document.getElementById('success-sound');

function drop(event) {
    event.preventDefault();
    const src = event.dataTransfer.getData('src');
    const phoneme = event.dataTransfer.getData('phoneme');
    const index = event.dataTransfer.getData('index');
    const targetContainer = event.currentTarget;

    if (targetContainer.id === `container-${phoneme.toLowerCase()}`) {
        if (targetContainer.childElementCount < 8) {
            const img = document.createElement('img');
            img.src = src;
            img.addEventListener('click', () => {
                const audio = new Audio(images[index].audio);
                audio.play();
            });
            targetContainer.appendChild(img);

            const imgs = generalContainer.querySelectorAll('img');
            imgs.forEach(img => {
                if (img.dataset.index === index) {
                    generalContainer.removeChild(img);
                }
            });
            successSound.play();
            incrementCorrectCounter();
        } else {
            showError('Este contenedor ya tiene 8 imágenes.');
        }
    } else {
        showError('¡Inténtalo de nuevo! Imagen en lugar incorrecto.');
    }
}

function showError(message) {
    const errorMessage = document.getElementById('error-message');
    errorMessage.textContent = message;
    errorMessage.classList.add('visible');

    setTimeout(() => {
        errorMessage.classList.remove('visible');
    }, 3000); // El mensaje desaparece después de 3 segundos
}

let time = 0;
let correctImagesCount = 0;

function startTimer() {
    setInterval(() => {
        time++;
        document.getElementById('timer').innerText = `Tiempo: ${time}s`;
    }, 1000);
}



window.onload = () => {
    startTimer();
};


// Función de reinicio
function reiniciarJuego() {
    // Limpia los contenedores de fonemas pero conserva los títulos
    Object.keys(containers).forEach(phoneme => {
        const container = containers[phoneme];
        // Mantén el primer hijo (el título) y elimina el resto
        while (container.children.length > 1) {
            container.removeChild(container.lastChild);
        }
    });

    // Restaurar las imágenes en el contenedor general
    generalContainer.innerHTML = ''; // Limpia el contenedor general
    images.forEach((image, index) => {
        const img = document.createElement('img');
        img.src = image.src;
        img.draggable = true;
        img.dataset.phoneme = image.phoneme;
        img.dataset.index = index;
        img.addEventListener('click', () => {
            const audio = new Audio(image.audio);
            audio.play();
        });
        img.addEventListener('dragstart', dragStart);
        generalContainer.appendChild(img);
    });

    // Reiniciar el contador de imágenes correctas
    correctImagesCount = 0;
    document.getElementById('correct-counter').innerText = 'Imágenes Correctas: 0';

    // Reiniciar el temporizador
    time = 0;
    document.getElementById('timer').innerText = 'Tiempo: 0s';
}

// Añadir evento al botón de reinicio
document.getElementById('reset-button').addEventListener('click', reiniciarJuego);

 

//codigo real 
function incrementCorrectCounter() {
    correctImagesCount+=10; //cambiar variable de imagenes correctas
    document.getElementById('correct-counter').innerText = `Imágenes Correctas: ${correctImagesCount}`;
}
//modificaciones
document.querySelector('.btn-siguiente').addEventListener('click', function() {
    // Crear una solicitud AJAX para enviar el conteo de imágenes correctas
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/php/progresofonemas.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Enviar el id del usuario, id_modulo, id_juego y el correctImagesCount
    xhr.send(`id_usuario=${usuarioId}&id_modulo=2&id_juego=4&progreso_usuario=${correctImagesCount}`);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText); // Mensaje de confirmación
        }
    };
});
