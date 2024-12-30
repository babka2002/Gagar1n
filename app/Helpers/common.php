<?php

if (!function_exists('getDayAbbreviation')) {
    function getDayAbbreviation($dayName) {
        $dayAbbreviations = [
            'понедельник' => 'Пн',
            'вторник' => 'Вт',
            'среда' => 'Ср',
            'четверг' => 'Чт',
            'пятница' => 'Пт',
            'суббота' => 'Сб',
            'воскресенье' => 'Вс',
        ];

        return $dayAbbreviations[$dayName] ?? '';
    }
}
