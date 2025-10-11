<?php

declare(strict_types= 1);

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

/**
 * @var array<int, string>
 */
$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
];

/**
 * @var array<int, string>
 */
$items = [];

/**
 * @param array<int, string> $operations
 * @param array<int, string> &$items
 * @return int
 */
/**
 * @param array<int, string> $operations
 * @param array<int, string> &$items
 * @return int
 */
function displayMenuAndGetOperation(array $operations, array &$items): int {
    system('clear');
    
    $operationNumber = null;
    
    do {
        echo 'Выберите операцию для выполнения: ' . PHP_EOL;
        echo implode(PHP_EOL, $operations) . PHP_EOL . '> ';
        
        $input = trim(fgets(STDIN));
        
        if (!is_numeric($input)) {
            system('clear');
            echo '!!! Введены недопустимые символы. Введите только число.' . PHP_EOL;
            continue;
        }
        
        $operationNumber = (int)$input;

        if (!array_key_exists($operationNumber, $operations)) {
            system('clear');
            echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        }
    } while (!array_key_exists($operationNumber, $operations));
    
    return $operationNumber;
}

/**
 * @param array<int, string> &$items
 * @return void
 */
function handleAddOperation(array &$items): void {
    echo "Введите название товара для добавления в список: \n> ";
    $itemName = trim(fgets(STDIN));
    $items[] = $itemName;
}

/**
 * @param array<int, string> &$items
 * @return void
 */
function handleDeleteOperation(array &$items): void {
    echo 'Введите название товара для удаления из списка:' . PHP_EOL . '> ';
    $itemName = trim(fgets(STDIN));
    
    if (in_array($itemName, $items, true)) {
        while (($key = array_search($itemName, $items, true)) !== false) {
            unset($items[$key]);
        }
    }
}

/**
 * @param array<int, string> $items
 * @return void
 */
function handlePrintOperation(array $items): void {
    if (count($items)) {
        echo 'Ваш список покупок: ' . PHP_EOL;
        echo implode("\n", $items) . "\n";
        echo 'Всего ' . count($items) . ' позиций. ' . PHP_EOL;
    } else {
        echo 'Ваш список покупок пуст.' . PHP_EOL;
    }
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
}

do {
    $operationNumber = displayMenuAndGetOperation($operations, $items);
    
    echo 'Выбрана операция: ' . $operations[$operationNumber] . PHP_EOL;
    
    switch ($operationNumber) {
        case OPERATION_ADD:
            handleAddOperation($items);
            break;
            
        case OPERATION_DELETE:
            handleDeleteOperation($items);
            break;
            
        case OPERATION_PRINT:
            handlePrintOperation($items);
            break;
    }
    
    echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;
