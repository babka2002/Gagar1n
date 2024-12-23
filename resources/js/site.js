// This is all you.

// Init ViewTransition
document.addEventListener("click", (e) => {
    // Проверяем, является ли элемент ссылкой или его родителем
    const target = e.target.closest("a[href]");
    if (target) {
        e.preventDefault();

        // Проверяем поддержку API
        if (!document.startViewTransition) {
            window.location = target.href;
            return;
        }

        // Применяем класс fade-out перед переходом
        document.body.classList.add("fade-out");

        // Запускаем переход
        document.startViewTransition(async () => {
            // Загружаем новую страницу
            const response = await fetch(target.href);
            const text = await response.text();

            // Обновляем DOM
            document.body.innerHTML = text;
            window.history.pushState({}, "", target.href);

            // Применяем класс fade-in после обновления DOM
            document.body.classList.remove("fade-out"); // Удаляем класс fade-out
            document.body.classList.add("fade-in"); // Применяем класс fade-in
        });
    }
});

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
    }
});
