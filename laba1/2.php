<?php
if ($argc <= 1)
{
    echo "Arguments: 0";
    return;
}

$value = preg_split("/=/", $argv[1])[0];
$sMax = $value;
$sMin = $value;

for ($i = 2; $i < $argc; $i++)
{
    $lenMax = strlen($sMax);
    $lenMin = strlen($sMin);

    $value = preg_split("/=/", $argv[$i])[0];
    $lenvalue = strlen($value);

    if (strncmp($sMax, $value, min($lenMax, $lenvalue)) === -1)
    {
        $sMax = $value;
    } 

    if (strncmp($sMin, $value, min($lenMin, $lenvalue)) === 1)
    {
        $sMin = $value;
    }
}

echo "Min: ", $sMin, " max: ", $sMax;