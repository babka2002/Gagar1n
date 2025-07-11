<?php

namespace App\Http\Controllers;

use App\Services\TrainerService;
use Statamic\Facades\Entry;
use Statamic\View\View;
use Statamic\Facades\Site;
use Statamic\Facades\Markdown;

class TrainerController extends Controller
{
    public function __construct(
        private readonly TrainerService $trainerService
    ) {}

    /**
     * Определяет сайт на основе URL
     */
    private function getSiteFromUrl(): string
    {
        $url = request()->getPathInfo();

        if (str_starts_with($url, '/gun1or')) {
            return 'Gun1or';
        } elseif (str_starts_with($url, '/gfoodcafe')) {
            return 'GFoodcafe';
        } else {
            return 'Grelka';
        }
    }

    private function formatTrainerData($trainer, $source = 'api')
    {
        if ($source === 'api') {
            return $trainer;
        } else {
            $position = $trainer->get('position');
            $department = $trainer->get('department');

            // Обработка Markdown контента с проверкой
            $description = $trainer->get('content_markdown');
            $parsedDescription = $description ? \Statamic\Facades\Markdown::parse($description) : '';

            // Обработка короткого описания
            $shortDescription = $trainer->get('short_description_markdown');
            $parsedShortDescription = $shortDescription ? \Statamic\Facades\Markdown::parse($shortDescription) : '';

            // Получаем term для позиции
            $positionTerm = null;
            if (!empty($position) && is_array($position) && !empty($position[0])) {
                $positionTerm = \Statamic\Facades\Term::query()
                    ->where('taxonomy', 'positions')
                    ->where('slug', $position[0])
                    ->first();
            }
            $positionTitle = $positionTerm ? $positionTerm->get('title') : 'Не определена';

            // Аналогично для department
            $departmentTerm = null;
            if (!empty($department) && is_array($department) && !empty($department[0])) {
                $departmentTerm = \Statamic\Facades\Term::query()
                    ->where('taxonomy', 'departments')
                    ->where('slug', $department[0])
                    ->first();
            }
            $departmentTitle = $departmentTerm ? $departmentTerm->get('title') : $positionTitle;

            return (object)[
                'id' => $trainer->id(),
                'name' => $trainer->get('name'),
                'second_name' => $trainer->get('second_name'),
                'last_name' => $trainer->get('last_name'),
                'description' => $parsedDescription,
                'short_description' => $parsedShortDescription, // Добавляем новое поле
                'localPhotoPath' => $trainer->get('localPhotoPath') ? '/assets/' . $trainer->get('localPhotoPath') : null,
                'position' => (object)[
                    'id' => null,
                    'title' => $positionTitle
                ],
                'department' => (object)[
                    'title' => $departmentTitle
                ],
                'specializations' => $trainer->get('specializations') ?? [],
                'experience' => $trainer->get('experience'),
                'slug' => $trainer->slug(),
                // SEO
                'seo_title' => $trainer->get('seo_title'),
                'field_meta_description' => $trainer->get('field_meta_description'),
                'field_meta_keywords' => $trainer->get('field_meta_keywords'),
            ];
        }
    }


    public function showTrainerBySlug(string $slug)
    {
        // Определяем сайт на основе URL
        $currentSite = $this->getSiteFromUrl();

        // Ищем тренера по slug только для текущего сайта
        $statamicTrainer = \Statamic\Facades\Entry::query()
            ->where('collection', 'trainers')
            ->where('is_active', true)
            ->where('slug', $slug)
            ->get()
            ->filter(function ($trainer) use ($currentSite) {
                // Проверяем принадлежность тренера к сайту через путь файла
                $path = $trainer->path();
                return str_contains($path, '/' . $currentSite . '/');
            })
            ->first();

        if ($statamicTrainer) {
            $trainer = $this->formatTrainerData($statamicTrainer, 'statamic');
        }

        if (!isset($trainer)) {
            abort(404, 'Тренер не найден');
        }

        // Формируем SEO title
        $seoTitle = $trainer->seo_title;
        if (empty($seoTitle)) {
            $seoTitle = $trainer->name . ' ' . $trainer->last_name . ' | GAGAR1N Симферополь';
        }

        return (new View)
            ->template(strtolower($currentSite) . '/trainer_single')
            ->layout(strtolower($currentSite) . '/layout')
            ->with([
                'trainer' => $trainer,
                'title' => $seoTitle,
                'field_meta_description' => $trainer->field_meta_description,
                'field_meta_keywords' => $trainer->field_meta_keywords
            ]);
    }

    public function showTrainer(string $employeeId)
    {
        $currentSite = strtolower(Site::current()->handle());

        $statamicTrainer = Entry::query()
            ->where('collection', 'trainers')
            ->where('is_active', true)
            ->where(function ($query) use ($employeeId) {
                $query->where('external_id', $employeeId)
                    ->orWhere('id', $employeeId);
            })
            ->first();

        if ($statamicTrainer) {
            $trainer = $this->formatTrainerData($statamicTrainer, 'statamic');
        }

        if (!isset($trainer)) {
            abort(404, 'Тренер не найден');
        }

        // Формируем SEO title
        $seoTitle = $trainer->seo_title;
        if (empty($seoTitle)) {
            $seoTitle = $trainer->name . ' ' . $trainer->last_name . ' | GAGAR1N Симферополь';
        }

        return (new View)
            ->template($currentSite . '/trainer_single')
            ->layout($currentSite . '/layout')
            ->with([
                'trainer' => $trainer,
                'title' => $seoTitle,
                'field_meta_description' => $trainer->field_meta_description,
                'field_meta_keywords' => $trainer->field_meta_keywords
            ]);
    }
    public function showTrainers()
    {
        // Определяем сайт на основе URL
        $currentSite = $this->getSiteFromUrl();

        // Ищем страницу тренеров для текущего сайта
        $page = \Statamic\Facades\Entry::query()
            ->where('collection', 'pages')
            ->where('slug', 'trainers')
            ->get()
            ->filter(function ($page) use ($currentSite) {
                // Проверяем принадлежность страницы к сайту через путь файла
                $path = $page->path();
                return str_contains($path, '/' . $currentSite . '/');
            })
            ->first();

        // Получаем тренеров только для текущего сайта
        $statamicTrainers = \Statamic\Facades\Entry::query()
            ->where('collection', 'trainers')
            ->where('is_active', true)
            ->get()
            ->filter(function ($trainer) use ($currentSite) {
                // Проверяем принадлежность тренера к сайту через путь файла
                $path = $trainer->path();
                return str_contains($path, '/' . $currentSite . '/');
            });

        $trainersByDepartment = [];
        foreach ($statamicTrainers as $trainer) {
            $formattedTrainer = $this->formatTrainerData($trainer, 'statamic');
            $departmentTitle = $formattedTrainer->department->title ?? $formattedTrainer->position->title ?? 'Не определена';

            if (!isset($trainersByDepartment[$departmentTitle])) {
                $trainersByDepartment[$departmentTitle] = [];
            }

            $trainersByDepartment[$departmentTitle][] = $formattedTrainer;
        }

        // Подготавливаем базовые данные
        $viewData = [
            'trainersByDepartment' => $trainersByDepartment,
            'title' => $page?->get('hero_title') ?? 'Тренеры',
            'field_meta_description' => $page?->get('field_meta_description'),
            'field_meta_keywords' => $page?->get('field_meta_keywords'),
        ];

        // Добавляем специфичные для сайта данные
        if ($currentSite === 'Gun1or') {
            // Данные для детского сайта Gun1or
            $viewData = array_merge($viewData, [
                // Hero секция
                'hero_title' => $page?->get('hero_title') ?? 'Наши тренеры для детей',
                'hero_subtitle' => $page?->get('hero_subtitle') ?? 'Профессионалы, которые сделают спорт увлекательным приключением!',
                'hero_image' => $page?->get('hero_image') ?? 'img/kids-hero.jpg',

                // CTA блок
                'cta_title' => $page?->get('cta_title') ?? 'Хочешь попробовать?',
                'cta_main_title' => $page?->get('cta_main_title') ?? 'Первое занятие БЕСПЛАТНО!',
                'cta_description' => $page?->get('cta_description') ?? 'Приходи познакомиться с нашими тренерами и попробовать детский фитнес.',
                'cta_button_text' => $page?->get('cta_button_text') ?? 'Записаться на пробное занятие',
                'cta_emoji' => $page?->get('cta_emoji') ?? '🏃‍♀️👦👧',
                'cta_link' => $page?->get('cta_link') ?? '#',

                // Настройки дизайна
                'site_settings' => [
                    'primary_color' => $page?->get('primary_color') ?? '#3B82F6',
                    'button_hover_color' => $page?->get('button_hover_color') ?? '#2563EB',
                    'gradient_from' => $page?->get('gradient_from') ?? '#60A5FA',
                    'gradient_to' => $page?->get('gradient_to') ?? '#F472B6',
                ],

                // Совместимость со старыми названиями переменных
                'subscription_not_found_title' => $page?->get('cta_title') ?? 'Хочешь попробовать?',
                'subscription_not_found_subtitle' => $page?->get('cta_button_text') ?? 'Записаться на пробное занятие'
            ]);
        } else {
            // Данные для взрослых сайтов (Grelka, GFoodcafe)
            $viewData = array_merge($viewData, [
                // Hero секция
                'hero_title' => $page?->get('hero_title') ?? 'каждый тренер в нашей команде уникален',
                'hero_subtitle' => $page?->get('hero_subtitle') ?? 'НАЙДИ СВОЕГО',
                'hero_image' => $page?->get('hero_image') ?? 'img/trainer-hero.jpg',

                // Блок "Не знаешь как начать?"
                'cta_title' => $page?->get('cta_title') ?? 'не знаешь как начать?',
                'cta_subtitle' => $page?->get('cta_subtitle') ?? 'запишись на',
                'cta_subtitle_highlight' => $page?->get('cta_subtitle_highlight') ?? 'индивидуальную тренировку',
                'cta_image' => $page?->get('cta_image') ?? 'img/trainer-hero.jpg',
                'cta_link' => $page?->get('cta_link') ?? '#',

                // Блок "Академия фитнеса"
                'academy_title' => $page?->get('academy_title') ?? 'хочешь стать тренером?',
                'academy_subtitle' => $page?->get('academy_subtitle') ?? 'АКАДЕМИЯ ФИТНЕСА',
                'academy_subtitle_dash' => $page?->get('academy_subtitle_dash') ?? 'АКАДЕМИЯ ФИТНЕСА -',
                'academy_description' => $page?->get('academy_description') ?? 'Профессиональное обучение персональных тренеров, тренеров групповых занятий, квалифицированных инструкторов тренажерного зала и тренеров по плаванию',
                'academy_image' => $page?->get('academy_image') ?? 'img/trainer-hero.jpg',
                'academy_link' => $page?->get('academy_link') ?? '/academy',

                // Контактная форма
                'form_title' => $page?->get('form_title') ?? 'ТВОЙ ТРЕНЕР УЖЕ ЖДЕТ!',
                'form_image' => $page?->get('form_image') ?? 'img/pool-contact.png',
                'form_button_text' => $page?->get('form_button_text') ?? 'СТАТЬ БЛИЖЕ К СВОЕЙ ЦЕЛИ',
                'form_privacy_text' => $page?->get('form_privacy_text') ?? 'Нажимая "Отправить" я согласен на обработку персональных данных',
                'form_name_placeholder' => $page?->get('form_name_placeholder') ?? 'ИМЯ',
                'form_phone_placeholder' => $page?->get('form_phone_placeholder') ?? 'НОМЕР ТЕЛЕФОНА'
            ]);
        }

        return (new View)
            ->template(strtolower($currentSite) . '/trainers')
            ->layout(strtolower($currentSite) . '/layout')
            ->with($viewData);
    }

    // public function showTrainers()
    // {
    //     $clubId = '49964502-5659-11eb-e291-ac162d836873';
    //     $trainers = $this->trainerService->getTrainers($clubId);

    //     // Получаем тренеров из Statamic
    //     $statamicTrainers = Entry::query()
    //         ->where('collection', 'trainers')
    //         ->where('is_active', true)
    //         ->get();

    //     // Группируем тренеров по отделам
    //     $trainersByDepartment = [];

    //     // Обрабатываем тренеров из API
    //     foreach ($trainers as $trainer) {
    //         $formattedTrainer = $this->formatTrainerData($trainer, 'api');
    //         $departmentTitle = $formattedTrainer->department->title ?? null;

    //         if (empty($departmentTitle)) {
    //             $departmentTitle = $formattedTrainer->position->title ?? 'Не определена';
    //         }

    //         if (!empty($departmentTitle)) {
    //             if (!isset($trainersByDepartment[$departmentTitle])) {
    //                 $trainersByDepartment[$departmentTitle] = [];
    //             }
    //             $trainersByDepartment[$departmentTitle][] = $formattedTrainer;
    //         }
    //     }

    //     // Добавляем тренеров из Statamic
    //     foreach ($statamicTrainers as $trainer) {
    //         if (!$trainer->get('external_id')) {
    //             $formattedTrainer = $this->formatTrainerData($trainer, 'statamic');
    //             $departmentTitle = $formattedTrainer->department->title ?? $formattedTrainer->position->title ?? 'Не определена';

    //             if (!isset($trainersByDepartment[$departmentTitle])) {
    //                 $trainersByDepartment[$departmentTitle] = [];
    //             }

    //             $trainersByDepartment[$departmentTitle][] = $formattedTrainer;
    //         }
    //     }

    //     return (new View)
    //         ->template('trainers')
    //         ->layout('layout')
    //         ->with([
    //             'trainersByDepartment' => $trainersByDepartment,
    //         ]);
    // }
}
