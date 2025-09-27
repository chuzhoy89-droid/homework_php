<?php

$input = fgets(STDIN);

$numbers = explode(' ', trim($input));

if (count($numbers) !== 2) {
    fwrite(STDERR, "Введите, пожалуйста, два числа через пробел\n");
    exit(1);
}

if (!is_numeric($numbers[0]) || !is_numeric($numbers[1]) || 
    (int)$numbers[0] != $numbers[0] || (int)$numbers[1] != $numbers[1]) {
    fwrite(STDERR, "Введите, пожалуйста, число\n");
    exit(1);
}

$num1 = (int)$numbers[0];
$num2 = (int)$numbers[1];

if ($num2 === 0) {
    fwrite(STDERR, "Делить на 0 нельзя\n");
    exit(1);
}

$result = $num1 / $num2;
fwrite(STDOUT, $result . "\n");
