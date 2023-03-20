<?php

$dir = opendir("./dicts");
$amountFiles = 0;
while($file = readdir($dir))
{
    if($file == '.' || $file == '..' || is_dir("./dicts" . $file))
    {
        continue;
    }
    $amountFiles++;
}

$dataDict = [];
for ($i = 0; $i < $amountFiles; $i++)
{
    $file = fopen("./dicts/dict" . ($i + 1) . ".txt", "r");
    while (!feof($file)) 
    {
        $line = fgets($file);
        $parsed = explode(":", $line);
        $key = $parsed[0];
        $dataDict[$key] = $line;
    }
    fclose($file);
}

$fh = fopen("Results.txt", "w");
ksort($dataDict);
foreach ($dataDict as $item)
{
    //echo $item;
    fwrite($fh, $item); 
}
fclose($fh);