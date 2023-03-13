<?php 
if ($argc <= 1)
{
    echo "Arguments: 0";
    return;
}
$arr = array_slice($argv, 1);
foreach ($arr as $v)
{
    if (!is_numeric($v))
    {
        echo "Incorrect type, pleace, enter numbers";
        return;
    } 
}
echo "Min:", min($arr), ", max:", max($arr);