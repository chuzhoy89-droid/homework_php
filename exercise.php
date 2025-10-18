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
    $isWorking = true;
    $offDays = 0;
    
    foreach ($schedule as &$day) {
        // Получаем день недели
        $date = new DateTime("$year-$month-". $day['date']);
        $dayOfWeek = (int)$date->format('N');
        
        // Если это выходной день, пропускаем его
        if ($dayOfWeek == 6 || $dayOfWeek == 7) {
            continue;
        }
        
        // Устанавливаем статус дня
        if ($isWorking) {
            $day['isWorking'] = true;
            $isWorking = false;
        } else {
            $offDays++;
            if ($offDays >= 2) {
                $isWorking = true;
                $offDays = 0;
            }
        }
    }
    
    return $schedule;
}

// Обработка входных параметров
$defaultYear = date('Y');
$defaultMonth = date('m');

$year = isset($_GET['year']) ? (int)$_GET['year'] : $defaultYear;
$month = isset($_GET['month']) ? (int)$_GET['month'] : $defaultMonth;

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
