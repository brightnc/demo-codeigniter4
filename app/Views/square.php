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

    $counter = $data_layers;
    for ($i = 1; $i <= $data_layers; $i++) {

        for ($j = 1; $j <= $i; $j++) {
            echo "X";
        }
        for ($k = $counter; $k >= 1; $k--) {
            echo "<span style='color:red;'>O</span>";
        }
        $counter--;
        echo "<br>";
    }

    ?>
</body>

</html>