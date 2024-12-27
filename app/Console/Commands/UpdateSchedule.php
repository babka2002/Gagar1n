<?php

namespace App\Console\Commands;

use App\Services\ScheduleService;
use Illuminate\Console\Command;

class UpdateSchedule extends Command
{
    protected $signature = 'schedule:update';
    protected $description = 'Update the schedule data';

    private ScheduleService $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        parent::__construct();
        $this->scheduleService = $scheduleService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startDate = now()->startOfYear()->toDateString(); // Начало года
        $endDate = now()->endOfYear()->toDateString(); // Конец года

        $params = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'service_id' => '',
            'employee_id' => '',
            'club_id' => '49964502-5659-11eb-e291-ac162d836873',
        ];

        $this->scheduleService->getSchedule($params);
        $this->info('Schedule data updated successfully.');
    }
}
