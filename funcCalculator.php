<?php

        function calc($a,$znak,$b)
        {



            switch ($znak) {
                case '-' :
                    $x = $a - $b;
                    return $x;
                case '+' :
                    $x = $a + $b;

                    return $x;
                case '*' :
                    $x = $a * $b;

                    return $x;
                case '/' :
                    if ($b == 0) {
                        echo 'на ноль делить нельзя';

                    }
                    else {
                        $x = $a / $b;
                        return $x;
                    }
            }
        }













