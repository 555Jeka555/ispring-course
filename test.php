<?php 
    if ($argc == 1){
        echo "Arguments: 0";
        return;
    }
    $arr = array_slice($argv, 1);
    echo $arr[0], " ", $arr[1], "\n";
    echo "Min:", (string)min($arr), ", max:", (string)max($arr)
;