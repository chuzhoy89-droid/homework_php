<?php

echo "Введите фамилию: ";
$surname = trim(fgets(STDIN));

echo "Введите имя: ";
$first_name = trim(fgets(STDIN));

echo "Введите отчество: ";
$patronymic = trim(fgets(STDIN));

$fullname = $surname . ' ' . $first_name . ' ' . $patronymic;

$fullname = mb_convert_case($fullname, MB_CASE_TITLE, "UTF-8");

$initial1 = mb_substr($first_name, 0, 1, 'UTF-8');
$initial2 = mb_substr($patronymic, 0, 1, 'UTF-8');

$surname = mb_convert_case($surname, MB_CASE_TITLE, "UTF-8");
$initial1 = mb_convert_case($initial1, MB_CASE_TITLE, "UTF-8");
$initial2 = mb_convert_case($initial2, MB_CASE_TITLE, "UTF-8");

$surnameAndInitials = $surname . ' ' . $initial1  . '.' . $initial2  . '.';

$fio = mb_substr($surname,0,1   , 'UTF-8') . mb_substr($first_name,0,1   , 'UTF-8') . mb_substr($patronymic,0,1   , 'UTF-8');

$fio = mb_convert_case($fio,MB_CASE_UPPER, "UTF-8");

echo "Полное имя: $fullname\n";
echo "Фамилия и инициалы: $surnameAndInitials\n";
echo "Аббревиатура: $fio\n";