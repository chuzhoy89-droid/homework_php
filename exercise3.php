<?php
$variable = 3.14;

// if (is_bool($variable)) {
//     echo 'bool';
// } else if (is_string($variable)) {
//     echo 'string';
// } else if (is_float($variable)) {
//     echo 'float';
// } else if (is_int($variable)) {
//     echo 'int';
// } else if (is_null($variable)) {
//     echo 'null';
// } else {
//     echo 'other';
// }

switch (true) {
    case is_bool($variable):
        $type = 'bool';
        break;
    case is_string($variable):
        $type = 'string';
        break;
    case is_float($variable):
        $type = 'float';
        break;
    case is_int($variable):
        $type = 'int';
        break;
    case is_null($variable):
        $type = 'null';
        break;
    default:
        $type = 'other';
        break;
}
echo "type is $type";