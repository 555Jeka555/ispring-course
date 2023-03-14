<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>4</title>
</head>
<body>
    <?php
        // Закомментированный код писал для проверок на функции для очков
        $password = $_GET["password"];
        $relability = 0;
        if (preg_match("/[А-Яа-я]/", $password)) 
        {
            echo "Введены русский символы!!!";
            return;
        }

        $lenPassowrd = strlen($password);

        $relability += 4 * $lenPassowrd;
        //echo "Очки за длинну: " . 4 * $lenPassowrd . " ";

        $relability += 4 * count(array_filter(str_split($password), "is_numeric"));
        //echo "Очки за цифры: " . 4 * count(array_filter(str_split($password), "is_numeric")) . " ";

        $englandLetters = [
            "q","w", "e", "r", "t", "y", "u", "i", "o", "p", "a", "s", "d",
            "f", "g", "h", "j", "k", "l", "z", "x", "c", "v", "b", "n", "m"
        ];

        $countUpperChars = 0;
        foreach ($englandLetters as $char)
        {
            $countUpperChars +=  substr_count($password, strtoupper($char), 0);
        }

        if ($countUpperChars > 0)
        {
            $relability += ($lenPassowrd - $countUpperChars) * 2;  
            //echo "Очки за верхний регистр: " . ($lenPassowrd - $countUpperChars) * 2 . " ";
        }

        $countLowChars = 0;
        foreach ($englandLetters as $char)
        {
            $countLowChars += substr_count($password, $char, 0);
        }

        if ($countLowChars > 0)
        {
            $relability += ($lenPassowrd - $countLowChars) * 2;  
            //echo "Очки за нижний регистр: " . ($lenPassowrd - $countLowChars) * 2 . " ";
        }

        if (ctype_alpha($password))
        {
            $relability -= $lenPassowrd;
            //echo "Штрафные очки за только буквы: " . $lenPassowrd . " ";
        }

        if (is_numeric($password))
        {
            $relability -= $lenPassowrd;
            //echo "Штрафные очки за только цифры : " . $lenPassowrd . " ";
        }

        $arrayPasswordChars = str_split($password);
        //$fine = 0;
        foreach ($arrayPasswordChars as $char)
        {
            if (substr_count($password, $char, 0) > 1){
                //$fine += 1;
                $relability -= 1;
            }
        }
        //echo "Штрафные очки за повтор символов: " . $fine . " ";

        echo "Надёжность пароля: " . $relability;
    ?>
</body>
</html>