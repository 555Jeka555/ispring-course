<?php
const EPSILON = 0.00000000000000001;
function compareFloats(float $value1, float $value2): int
{ 
    $del = $value2 - $value1; 
    if (abs($del) < EPSILON){
        return 0;
    }
    return $del > 0 ? 1 : -1;
    
}

function arrayEquals(array $left, array $rights): bool
{
    return $left === $rights;
}

function arrayNumberFilter(array $data): array
{
    $resultArray = [];
    foreach ($data as $item)
    {
        if (is_numeric($item))
        {
            array_push($resultArray, $item);
        }
    }

    return $resultArray;
}