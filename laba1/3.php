<?php
if ($argc <= 1)
{
    echo "Arguments: 0";
    return;
}

$str = $argv[1];
$str = trim($str);
$arrayStr = preg_split('/\s+/', $str);

for ($i = 0; $i < count($arrayStr) - 1; $i++)
{
    echo $arrayStr[$i] . " ";
}
echo $arrayStr[count($arrayStr) - 1];