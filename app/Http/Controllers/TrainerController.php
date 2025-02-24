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
                'field_meta_description' => $trainer->get('field_meta_description'),
                'field_meta_keywords' => $trainer->get('field_meta_keywords'),
            ];
        }
    }


    public function showTrainerBySlug(string $slug)
    {
        $currentSite = strtolower(Site::current()->handle());

        // Ищем тренера по slug
        $statamicTrainer = Entry::query()
            ->where('collection', 'trainers')
            ->where('is_active', true)
            ->where('slug', $slug)
            ->first();

        if ($statamicTrainer) {
            $trainer = $this->formatTrainerData($statamicTrainer, 'statamic');
        }

        if (!isset($trainer)) {
            abort(404, 'Тренер не найден');
        }

        return (new View)
            ->template($currentSite . '/trainer_single')
            ->layout($currentSite . '/layout')
            ->with([
                'trainer' => $trainer,
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

        return (new View)
            ->template($currentSite . '/trainer_single')
            ->layout($currentSite . '/layout')
            ->with([
                'trainer' => $trainer
            ]);
    }
    public function showTrainers()
    {
        $currentSite = strtolower(Site::current()->handle());

        $page = Entry::query()
        ->where('collection', 'pages')
        ->where('slug', 'trainers')
        ->first();

        $statamicTrainers = Entry::query()
            ->where('collection', 'trainers')
            ->where('is_active', true)
            ->get();

        $trainersByDepartment = [];
        foreach ($statamicTrainers as $trainer) {
            $formattedTrainer = $this->formatTrainerData($trainer, 'statamic');
            $departmentTitle = $formattedTrainer->department->title ?? $formattedTrainer->position->title ?? 'Не определена';

            if (!isset($trainersByDepartment[$departmentTitle])) {
                $trainersByDepartment[$departmentTitle] = [];
            }

            $trainersByDepartment[$departmentTitle][] = $formattedTrainer;
        }

        return (new View)
            ->template($currentSite . '/trainers')
            ->layout($currentSite . '/layout')
            ->with([
                'trainersByDepartment' => $trainersByDepartment,
                'title' => $page->get('hero_title'),
                'field_meta_description' => $page->get('field_meta_description'),
                'field_meta_keywords' => $page->get('field_meta_keywords'),
                'subscription_not_found_title' => $page->get('subscription_not_found_title'),
                'subscription_not_found_subtitle' => $page->get('subscription_not_found_subtitle')
            ]);
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
