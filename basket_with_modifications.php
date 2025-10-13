<?php

declare(strict_types=1);

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;
const OPERATION_EDIT = 4;
const OPERATION_SET_QUANTITY = 5;

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
    OPERATION_EDIT => OPERATION_EDIT . '. Изменить название товара.',
    OPERATION_SET_QUANTITY => OPERATION_SET_QUANTITY . '. Установить количество товара.',
];

$items = [];

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

function handleAddOperation(array &$items): void {
    echo "Введите название товара для добавления в список: \n> ";
    $itemName = trim(fgets(STDIN));
    echo "Введите количество товара: \n> ";
    $quantity = (int)trim(fgets(STDIN));
    $items[] = ['name' => $itemName, 'quantity' => $quantity];
}

function handleEditOperation(array &$items): void {
    handlePrintOperation($items);
    echo "Введите номер товара для изменения: \n> ";
    $index = (int)trim(fgets(STDIN));
    
    $realIndex = $index - 1;
    
    if (isset($items[$realIndex])) {
        echo "Введите новое название товара: \n> ";
        $newName = trim(fgets(STDIN));
        $items[$realIndex]['name'] = $newName;
    } else {
        echo "Товар с таким номером не найден!\n";
    }
}

function handleSetQuantityOperation(array &$items): void {
    handlePrintOperation($items);
    echo "Введите номер товара для изменения количества: \n> ";
    $index = (int)trim(fgets(STDIN));
    
    $realIndex = $index - 1;
    
    if (isset($items[$realIndex])) {
        echo "Введите новое количество товара: \n> ";
        $newQuantity = (int)trim(fgets(STDIN));
        $items[$realIndex]['quantity'] = $newQuantity;
    } else {
        echo "Товар с таким номером не найден!\n";
    }
}

function handleDeleteOperation(array &$items): void {
    handlePrintOperation($items);
    echo 'Введите номер товара для удаления из списка:'. PHP_EOL. '> ';
    $index = (int)trim(fgets(STDIN));
    
    $realIndex = $index - 1;
    
    if (isset($items[$realIndex])) {
        unset($items[$realIndex]);
        echo 'Товар успешно удален!'. PHP_EOL;
    } else {
        echo 'Товар с таким номером не найден!'. PHP_EOL;
    }
}

function handlePrintOperation(array $items): void {
    if (count($items)) {
        echo 'Ваш список покупок: ' . PHP_EOL;
        foreach ($items as $key => $item) {
            echo ($key + 1) . '. ' . $item['name'] . ' (количество: ' . $item['quantity'] . ')' . PHP_EOL;
        }
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

        case OPERATION_EDIT:
            handleEditOperation($items);
            break;

        case OPERATION_SET_QUANTITY:
            handleSetQuantityOperation($items);
            break;
    }
    
    echo "\n ----- \n";
} while ($operationNumber > 0);


echo 'Программа завершена' . PHP_EOL;
