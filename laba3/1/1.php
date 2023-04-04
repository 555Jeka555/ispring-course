<?php

require_once "utils.php";

echo "Test compareFloats\n";
echo compareFloats(1.0000000000000004, 1.0000000000000003) . "\n";
echo compareFloats(2.0, 1.0) . "\n";
echo compareFloats(1.0, 1.0) . "\n";

echo "Test arrayEquals\n";
echo arrayEquals([1, 2, 3], [1, 2, 3]) . "\n";
echo arrayEquals([1, 2, 3], [1, 2, "a"]) . "\n";
echo arrayEquals([1, 2, 3], [1, 2, 4]) . "\n";
echo arrayEquals([1, 2, 3], [1, 3, 2]) . "\n";
echo arrayEquals([1, 2, 3], [1, 3, 2, 5]) . "\n";

foreach (arrayNumberFilter([1, true, "dfsdf", 20, 3.4]) as $item)
{
    echo $item . " ";
}