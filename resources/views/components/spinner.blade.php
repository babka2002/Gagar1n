<div
    x-data="{ isLoading: false }"
    x-init="
        $watch('isLoading', value => {
            if (value) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });

        window.addEventListener('load', () => isLoading = false);
        window.addEventListener('beforeunload', () => isLoading = true);

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', () => isLoading = true);
            });

            document.querySelectorAll('a:not([target=\'_blank\']):not([href^=\'#\'])').forEach(link => {
                link.addEventListener('click', () => isLoading = true);
            });
        });

        if (typeof Livewire !== 'undefined') {
            Livewire.hook('message.sent', () => isLoading = true);
            Livewire.hook('message.processed', () => isLoading = false);
            Livewire.hook('message.failed', () => isLoading = false);
        }

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


{{-- <div id="global-loader" class=" fixed inset-0 bg-gray-800 bg-opacity-80 flex items-center justify-center z-50">
    <x-bladewind::spinner size="medium" color="red" />
</div> --}}

{{-- <script>
    // alert('test');
    window.showSpinner = function() {
        document.getElementById('global-loader').classList.remove('hidden');
    }

    window.hideSpinner = function() {
        document.getElementById('global-loader').classList.add('hidden');
    }

    // Автоматически показывать спиннер при отправке форм
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                showSpinner();
            });
        });

        // Показывать спиннер при переходе по ссылкам
        document.querySelectorAll('a:not([target="_blank"])').forEach(link => {
            link.addEventListener('click', function() {
                showSpinner();
            });
        });

        // Показывать спиннер при загрузке страницы
        window.addEventListener('load', function() {
            hideSpinner();
        });

        // Скрывать спиннер при ошибке загрузки
        window.addEventListener('error', function() {
            hideSpinner();
        });
    });
</script> --}}

