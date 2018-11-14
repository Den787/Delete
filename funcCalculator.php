<?php






        function calc($a,$znak,$b)
        {
            switch ($znak) {
                case 66 :
                    $x = $a - $b;
                    print($x);
                    return $x;
                case '+' :
                    $x = $a + $b;
                    print($x);
                    return $x;
                case '*' :
                    $x = $a * $b;
                    print($x);
                    return $x;
                case '/' :
                    $x = $a / $b;
                    print($x);
                    return $x;
            }
        }













