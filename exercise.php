<?php

function generateWorkSchedule($year, $month) {
    // Получаем количество дней в месяце
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    
    // Создаем массив для всех дней месяца
    $schedule = [];
    
    // Заполняем массив всеми днями месяца
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $schedule[] = [
            'date' => $day,
            'isWorking' => false
        ];
    }
    
// Начальная точка - первый рабочий день месяца
$isWorkingDay = true;
$offDaysCount = 0;

foreach ($schedule as &$day) {
    $date = new DateTime($year . '-' . $month . '-' . $day['date']);
    $dayOfWeek = (int)$date->format('N'); // 1-7 (пн-вс)


    // Если это суббота или воскресенье — всегда выходной
    if ($dayOfWeek >= 6) {
        $day['isWorking'] = false;
        $isWorkingDay = true;  // Сбрасываем цикл: после выходных первый день — рабочий
        $offDaysCount = 0;
        continue;
    }

    // Логика графика для рабочих дней
    if ($isWorkingDay) {
        $day['isWorking'] = true;
        $isWorkingDay = false;
        $offDaysCount = 0;
    } else {
        $day['isWorking'] = false;
        $offDaysCount++;

        if ($offDaysCount >= 2) {
            $isWorkingDay = true;
            $offDaysCount = 0;
        }
    }
}
    
return $schedule;
}

// Обработка входных параметров (CLI и веб)
$defaultYear = date('Y');
$defaultMonth = date('m');

if (php_sapi_name() === 'cli') {
    // Режим командной строки: разбираем аргументы
    $args = [];
    foreach ($argv as $arg) {
        if (strpos($arg, '=') !== false) {
            list($key, $value) = explode('=', $arg, 2);
            $args[$key] = $value;
        }
    }
    $year = isset($args['year']) ? (int)$args['year'] : $defaultYear;
    $month = isset($args['month']) ? (int)$args['month'] : $defaultMonth;
} else {
    // Веб‑режим: берём из $_GET
    $year = isset($_GET['year']) ? (int)$_GET['year'] : $defaultYear;
    $month = isset($_GET['month']) ? (int)$_GET['month'] : $defaultMonth;
}

// Основной вывод
$monthName = date('F', mktime(0, 0, 0, $month, 1, $year));
echo "<h2>$monthName $year</h2>";
echo "<ul>";

$schedule = generateWorkSchedule($year, $month);

foreach ($schedule as $day) {
    if ($day['isWorking']) {
        // Выделяем рабочий день красным цветом
        echo "\033[31m" . $day['date'] . "\033[0m ";
    } else {
        echo $day['date'] . " ";
    }
}

echo "</ul>";
