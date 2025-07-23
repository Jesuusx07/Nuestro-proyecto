let next = document.querySelector('.next');
let prev = document.querySelector('.prev');

next.addEventListener('click', function() {
    let items = document.querySelectorAll('.item');
    let slide = document.querySelector('.slide');

    // Aquí deberías especificar qué ítem vas a mover o mostrar
    // Por ejemplo, mover el primer ítem al final:
    if (items.length > 0) {
        slide.appendChild(items[0]);
    }
});

prev.addEventListener('click', function() {
    let items = document.querySelectorAll('.item');
    let slide = document.querySelector('.slide');

    if (items.length > 0) {
        slide.prepend(items[items.length - 1]);
    }
});

