<?php
$data_layers = $layers;


echo $data_layers;
echo "<hr>";


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    // $counter = $data_layers;
    // for ($i = 1; $i <= $data_layers; $i++) {

    //     for ($j = 1; $j <= $i; $j++) {
    //         echo "X";
    //     }
    //     for ($k = $counter; $k >= 1; $k--) {
    //         echo "<span style='color:red;'>O</span>";
    //     }
    //     $counter--;
    //     echo "<br>";
    // }





    // $counter2 = $data_layers;
    // for ($i = 1; $i <= $data_layers; $i++) {

    //     for ($j = 1; $j <= $i; $j++) {
    //         echo "X";
    //     }
    //     for ($k = ($counter2 * 2 - 1); $k >= 1; $k--) {
    //         echo "<span style='color:red;'>O</span>";
    //     }
    //     for ($l = 1; $l <= $i; $l++) {
    //         echo "X";
    //     }

    //     $counter2--;
    //     echo "<br>";
    // }



    // for ($i = 1; $i <= $data_layers; $i++) {
    //     if ($i % 5 == 0) {
    //         for ($k = 1; $k <= $i; $k++) {
    //             echo "<span style='color:red;'>O</span>";
    //         }
    //         echo "<br>";
    //         continue;
    //     }
    //     for ($j = 1; $j <= $i; $j++) {
    //         if ($j % 5 == 0) {
    //             echo "<span style='color:red;'>O</span>";
    //             continue;
    //         }
    //         echo "X";
    //     }
    //     echo "<br>";
    // }



    for ($i = $data_layers; $i >= 1; $i--) {
        if ($i % 5 == 0) {
            for ($k = $i; $k >= 1; $k--) {
                echo "<span style='color:red;'>O</span>";
            }
            echo "<br>";
            continue;
        }

        for ($j = $i; $j >= 1; $j--) {

            if ($j % 5 == 0) {
                echo "<span style='color:red;'>O</span>";
                continue;
            }
            echo "X";
        }
        echo "<br>";
    }

    ?>
</body>

</html>