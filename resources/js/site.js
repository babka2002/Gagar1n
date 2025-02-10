// This is all you.

// Initialize Swiper
import Swiper from 'swiper/bundle';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

// Initialize AOS
import AOS from 'aos';
import 'aos/dist/aos.css';


var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    centeredSlides: true,
    freeMode: true,
    autoHeight: false,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: false,
    },
    breakpoints: {
        640: {
            slidesPerView: 1,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 40,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 50,
        },
    },
});
// Инициализация обработчиков событий Swiper, если элемент существует
function initializeSwiperEvents() {
    const swiperContainer = document.querySelector('.mySwiper');

    // Инициализируем события только если контейнер Swiper существует
    if (swiperContainer && typeof swiper !== 'undefined') {
        // События мыши
        swiperContainer.addEventListener('mouseenter', () => {
            swiper.autoplay.stop();
        });

        swiperContainer.addEventListener('mouseleave', () => {
            swiper.autoplay.start();
        });

        // События касания
        swiperContainer.addEventListener('touchstart', () => {
            swiper.autoplay.stop();
        });

        swiperContainer.addEventListener('touchend', () => {
            swiper.autoplay.start();
        });
    }
}

// Инициализация событий при загрузке DOM
document.addEventListener('DOMContentLoaded', initializeSwiperEvents);

// TRAINER SLIDER
var swiper2 = new Swiper(".mySwiper2", {
    slidesPerView: 1,
    spaceBetween: 16,
    centeredSlides: true,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },
    autoHeight: false,
    breakpoints: {
        640: {
            slidesPerView: 2,
            spaceBetween: 16,
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 16,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 16,
        },
        1440: {
            slidesPerView: 4,
            spaceBetween: 16,
        },
        1600: {
            slidesPerView: 5,
            spaceBetween: 16,
        },
    },
});

// Компонент формы
const ContactForm = {
    submit(e) {
        e.preventDefault();
        // Логика отправки формы
    },
};

// Мобильное меню
const MobileMenu = {
    isOpen: false,

    init() {
        // Получаем элементы один раз при инициализации
        this.menu = document.querySelector(".menu-items");
        this.toggleButton = document.querySelector(".menu-toggle"); // Предполагаем, что у кнопки есть такой класс

        if (this.menu && this.toggleButton) {
            // Скрываем меню при инициализации
            this.menu.classList.add("hidden");

            // Добавляем обработчики событий
            this.toggleButton.addEventListener("click", () => this.toggle());

            // Добавляем обработчик для всех ссылок в меню
            this.menu.querySelectorAll("a").forEach((link) => {
                link.addEventListener("click", () => this.close());
            });

            // Добавляем обработчик клика вне меню
            document.addEventListener("click", (event) => {
                if (
                    this.isOpen &&
                    !this.menu.contains(event.target) &&
                    !this.toggleButton.contains(event.target)
                ) {
                    this.close();
                }
            });
        }
    },

    toggle() {
        if (!this.menu) return;

        this.isOpen = !this.isOpen;
        this.menu.classList.toggle("hidden");

        // Опционально: блокировка прокрутки body при открытом меню
        document.body.style.overflow = this.isOpen ? "hidden" : "";
    },

    close() {
        if (!this.menu) return;

        this.isOpen = false;
        this.menu.classList.add("hidden");
        document.body.style.overflow = "";
    },
};
// Скрыть MENU по умолчанию
document.addEventListener("DOMContentLoaded", () => {
    MobileMenu.init();
});

// DIALOG
// DIALOG
const showBtns = document.querySelectorAll(".show");
const closeBtns = document.querySelectorAll(".close");
const autoplayDialog = document.getElementById("dialog-autoplay");

// Autoplay setup
function shouldShowDialog() {
    // Проверяем включен ли автопоказ
    const enabled = autoplayDialog.dataset.enabled == 1;
    if (!enabled) return false;

    const intervalDays = parseInt(autoplayDialog.dataset.interval);
    
    // Если интервал 0 или не задан, показываем каждый раз
    if (intervalDays === 0) return true;

    const lastShown = localStorage.getItem('dialogLastShown');
    const hasBeenShown = localStorage.getItem('dialogHasBeenShown');

    // Если никогда не показывался
    if (!hasBeenShown) return true;

    // Проверяем интервал показа из настроек
    if (lastShown) {
        const daysSinceLastShow = (Date.now() - parseInt(lastShown)) / (1000 * 60 * 60 * 24);
        return daysSinceLastShow >= intervalDays;
    }

    return false;
}

function handleAutoplayDialog() {
    if (!autoplayDialog || !shouldShowDialog()) return;

    // Получаем задержку из настроек
    const delaySeconds = parseInt(autoplayDialog.dataset.delay);
    
    // Функция показа диалога
    const showDialog = () => {
        autoplayDialog.showModal();
        localStorage.setItem('dialogLastShown', Date.now().toString());
        localStorage.setItem('dialogHasBeenShown', 'true');
    };

    // Если задержка 0 или не задана - показываем сразу
    if (delaySeconds === 0) {
        showDialog();
    } else {
        setTimeout(showDialog, delaySeconds * 1000);
    }
}
// End Autoplay setup


// Добавляем обработчик для каждой кнопки
if (showBtns.length > 0) {
    showBtns.forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault(); // Предотвращаем стандартное поведение ссылки
            const dialogId = btn.getAttribute("data-dialog"); // Получаем ID модального окна
            const dialogElem = document.getElementById(dialogId); // Находим модальное окно по ID
            if (dialogElem) {
                dialogElem.showModal(); // Открываем модальное окно
            }
        });
    });
}

// Добавляем обработчик для каждой кнопки закрытия
if (closeBtns.length > 0) {
    closeBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            const dialogElem = btn.closest("dialog"); // Находим родительское модальное окно
            if (dialogElem) {
                dialogElem.close(); // Закрываем модальное окно
            }
        });
    });
}

// Initialize autoplay functionality
document.addEventListener('DOMContentLoaded', handleAutoplayDialog);

// Optional: Close dialog when clicking outside
autoplayDialog?.addEventListener('click', (e) => {
    const dialogDimensions = autoplayDialog.getBoundingClientRect();
    if (
        e.clientX < dialogDimensions.left ||
        e.clientX > dialogDimensions.right ||
        e.clientY < dialogDimensions.top ||
        e.clientY > dialogDimensions.bottom
    ) {
        autoplayDialog.close();
    }
});
// const dialogElem = document.getElementById("dialog");
// const showBtns = document.querySelectorAll(".show"); // Получаем все элементы с классом show
// const closeBtn = document.querySelector(".close");


// // Добавляем обработчик для каждой кнопки
// if (dialogElem && showBtns.length > 0) {
//     showBtns.forEach(btn => {
//         btn.addEventListener("click", (e) => {
//             e.preventDefault(); // Предотвращаем стандартное поведение ссылки
//             dialogElem.showModal();
//         });
//     });
// }

// if (closeBtn && dialogElem) {
//     closeBtn.addEventListener("click", () => {
//         dialogElem.close();
//     });
// }


// Init ViewTransition
// document.addEventListener("click", (e) => {
//     const target = e.target.closest("a[href]");
//     if (target) {
//         e.preventDefault();

//         // Закрываем меню перед переходом
//         MobileMenu.close();

//         if (!document.startViewTransition) {
//             window.location = target.href;
//             return;
//         }

//         document.body.classList.add("fade-out");

//         document.startViewTransition(async () => {
//             try {
//                 const response = await fetch(target.href);
//                 const text = await response.text();

//                 document.body.innerHTML = text;
//                 window.history.pushState({}, "", target.href);
//                 window.scrollTo(0, 0);

//                 document.body.classList.remove("fade-out");
//                 document.body.classList.add("fade-in");

//                 // Переинициализируем меню на новой странице
//                 MobileMenu.init();
//             } catch (error) {
//                 console.error("Ошибка при переходе:", error);
//                 window.location = target.href; // Fallback при ошибке
//             }
//         });
//     }
// });

// Добавляем анимацию при загрузке страницы
document.addEventListener("DOMContentLoaded", () => {
    const body = document.body;
    body.classList.add("fade-in"); // Применяем класс для анимации появления

    // Удаляем класс fade-out, если он был добавлен ранее
    body.classList.remove("fade-out");
});

// Добавляем обработчик события перед перезагрузкой страницы
window.addEventListener("beforeunload", () => {
    document.body.classList.add("fade-out"); // Применяем класс для анимации исчезновения
});

// Обработчик события visibilitychange
document.addEventListener("visibilitychange", () => {
    if (document.visibilityState === "hidden") {
        document.body.classList.add("fade-out"); // Применяем класс fade-out при скрытии страницы
    } else {
        document.body.classList.remove("fade-out"); // Удаляем класс fade-out при возвращении на страницу
        document.body.classList.add("fade-in"); // Применяем класс fade-in при возвращении на страницу
    }
});

// PAGE ANIMATIONS
AOS.init({
  // Global settings:
  disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
  startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
  initClassName: 'aos-init', // class applied after initialization
  animatedClassName: 'aos-animate', // class applied on animation
  useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
  disableMutationObserver: false, // disables automatic mutations' detections (advanced)
  debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
  throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)


  // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
  offset: 120, // offset (in px) from the original trigger point
  delay: 100, // values from 0 to 3000, with step 50ms
  duration: 300, // values from 0 to 3000, with step 50ms
  easing: 'ease', // default easing for AOS animations
  once: false, // whether animation should happen only once - while scrolling down
  mirror: false, // whether elements should animate out while scrolling past them
  anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation
});


document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.toggle-button');
    const contents = document.querySelectorAll('.content');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetContent = document.getElementById(targetId);

            if (targetContent.classList.contains('active')) {
                // Если целевой блок уже активен, скрываем его
                targetContent.classList.remove('active');
                this.classList.remove('active');
            } else {
                // Скрываем все блоки и убираем активный класс с кнопок
                contents.forEach(content => content.classList.remove('active'));
                buttons.forEach(btn => btn.classList.remove('active'));

                // Показываем целевой блок и делаем кнопку активной
                targetContent.classList.add('active');
                this.classList.add('active');
            }
        });
    });
});
