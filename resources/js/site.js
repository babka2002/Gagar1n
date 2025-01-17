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
const dialogElem = document.getElementById("dialog");
const showBtn = document.querySelector(".show");
const closeBtn = document.querySelector(".close");

showBtn.addEventListener("click", () => {
    dialogElem.showModal();
});

closeBtn.addEventListener("click", () => {
    dialogElem.close();
});

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
