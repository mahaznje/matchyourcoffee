if (document.querySelector('.home')) {
    const home = document.querySelector('.home');
    const backgrounds = document.querySelectorAll('.background-image');
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');

    const images = [
        'assets/matcha3.jpg',
        'assets/matcha.webp',
        'assets/matcha1.jpg',
        'assets/matcha2.jpg',
        'assets/coffe.jpg',
        'assets/coffe1.jpg',
        'assets/coffe2.jpg',
    ];

    let currentImageIndex = 0;
    let nextImageIndex = 1;

    function preloadImage(url) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = resolve;
            img.onerror = reject;
            img.src = url;
        });
    }

    async function changeBackground() {
        await preloadImage(images[nextImageIndex]);
        backgrounds[1].style.backgroundImage = `url(${images[nextImageIndex]})`;
        [currentImageIndex, nextImageIndex] = [nextImageIndex, (nextImageIndex + 1) % images.length];
        setTimeout(() => {
            backgrounds[0].style.backgroundImage = backgrounds[1].style.backgroundImage;
        }, 1000);
    }

    function nextImage() {
        nextImageIndex = (currentImageIndex + 1) % images.length;
        changeBackground();
    }

    function prevImage() {
        nextImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        changeBackground();
    }

    setInterval(nextImage, 5000);
    nextButton.addEventListener('click', nextImage);
    prevButton.addEventListener('click', prevImage);
    backgrounds[0].style.backgroundImage = `url(${images[0]})`;
}

if (document.querySelector('.avis-item')) {
    const slides = document.querySelectorAll('.avis-item');
    let index = 0;

    function nextSlide() {
        slides[index].classList.remove('active');
        index = (index + 1) % slides.length;
        slides[index].classList.add('active');
    }

    function prevSlide() {
        slides[index].classList.remove('active');
        index = (index - 1 + slides.length) % slides.length;
        slides[index].classList.add('active');
    }
}


/*** nav */
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.header');
    const userBtn = document.querySelector('#user-btn'); // Ensure this selector matches your HTML
    const navList = document.querySelector('.navlist');
    const userBox = document.querySelector('.user-box'); // Select the user box

    function fixeNavbar() {
        header.classList.toggle('scrolled', window.pageYOffset > 0);
    }

    fixeNavbar();

    window.addEventListener('scroll', fixeNavbar);

    // Toggle navigation menu
    const menu = document.querySelector('#menu-icon');

    menu.addEventListener('click', function() {
        navList.classList.toggle('active');
        userBox.classList.remove('active'); // Close user box if nav is opened
    });

    // Toggle user box
    userBtn.addEventListener('click', function() {
        userBox.classList.toggle('active');
        navList.classList.remove('active'); // Optionally close nav list if it's open
        // Close other open menus if necessary
        if (userBox.classList.contains('active')) {
            navList.classList.remove('active');
        }

        // Optional - Close user box when clicking outside
        document.addEventListener('click', function(event) {
            if (!userBox.contains(event.target) && !userBtn.contains(event.target)) {
                userBox.classList.remove('active');
            }
        });

        // Prevent event bubbling
        event.stopPropagation();

    });
});


function showNotification(message, type = 'success', duration = 3000) {
    const container = document.getElementById('notification-container');

    // Créer l'élément de notification
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;

    // Ajouter une icône selon le type
    const icon = document.createElement('span');
    icon.className = 'notification-icon';
    icon.innerHTML = getIconForType(type);

    // Créer le message
    const messageSpan = document.createElement('span');
    messageSpan.textContent = message;



    // Ajouter les éléments à la notification
    notification.appendChild(icon);
    notification.appendChild(messageSpan);

    // Ajouter la notification au conteneur
    container.appendChild(notification);

    // Supprimer la notification après un certain temps
    setTimeout(() => removeNotification(notification), duration);
}

function getIconForType(type) {
    switch (type) {
        case 'success':
            return '✅'; // Emoji pour succès
        case 'info':
            return 'ℹ️'; // Emoji pour info
        case 'error':
            return '❌'; // Emoji pour erreur
        default:
            return '🔔'; // Emoji par défaut
    }
}

function removeNotification(notification) {
    notification.style.animation = 'fadeOut 0.5s ease-out';
    notification.addEventListener('animationend', () => {
        notification.remove();
    });

}