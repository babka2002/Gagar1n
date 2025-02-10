<div
    x-data="{
        isLoading: false,
        handlePageShow(e) {
            // Проверяем, загружена ли страница из кэша
            if (e.persisted) {
                this.isLoading = false;
            }
        }
    }"
    x-init="
        $watch('isLoading', value => {
            if (value) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });

        // Добавляем обработчик pageshow
        window.addEventListener('pageshow', e => handlePageShow(e));

        // Обработка загрузки страницы
        if (document.readyState === 'complete') {
            isLoading = false;
        } else {
            window.addEventListener('load', () => isLoading = false);
        }

        // Устанавливаем состояние загрузки при уходе со страницы
        window.addEventListener('beforeunload', () => isLoading = true);

        document.addEventListener('DOMContentLoaded', () => {
            // Обработка отправки форм
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', (e) => {
                    // Проверяем, что форма действительно отправляется
                    if (form.checkValidity()) {
                        isLoading = true;
                    }
                });
            });

            // Обработка переходов по ссылкам
            document.querySelectorAll('a:not([target=\'_blank\']):not([href^=\'#\'])').forEach(link => {
                link.addEventListener('click', () => {
                    // Проверяем, что ссылка ведет на другую страницу
                    if (link.href !== window.location.href) {
                        isLoading = true;
                    }
                });
            });
        });

        // Поддержка Livewire если он используется
        if (typeof Livewire !== 'undefined') {
            Livewire.hook('message.sent', () => isLoading = true);
            Livewire.hook('message.processed', () => isLoading = false);
            Livewire.hook('message.failed', () => isLoading = false);
        }

        // Глобальные методы управления спиннером
        window.showSpinner = () => isLoading = true;
        window.hideSpinner = () => isLoading = false;
    "
    x-show="isLoading"
    x-transition.opacity.duration.500ms
    class="fixed inset-0 bg-gray-800/85 flex items-center justify-center z-[9999]"
    style="display: none;"
>
    <div class="text-center">
        <x-bladewind::spinner size="xl" color="red" />
        <div class="mt-4 text-white text-sm">Загрузка...</div>
    </div>
</div>
