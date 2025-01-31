<?php

namespace App\Services;

interface ScheduleServiceInterface
{
    public function getSchedule(array $params): array;
}
