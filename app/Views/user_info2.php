<?php
$data = $user_data;
$data_detail = $user_detail;
$data_user_game = $user_game;
$data_game = $game_info;
$data_acc_info = $acc_info;

for ($i = 0; $i < count($data); $i++) {
    if (isset($data[$i])) {
        $user_id = $data[$i]->user_id;
        $username = $data[$i]->username;
        $created_at = $data[$i]->created_at;;
    } else {
        echo "No Data Found";
    }
}

for ($i = 0; $i < count($data_acc_info); $i++) {
    if (isset($data_acc_info[$i])) {
        $name = $data_acc_info[$i]->name;
        $acc_type = $data_acc_info[$i]->acc_type;
    } else {
        echo "No Data Found";
    }
}

for ($i = 0; $i < count($data_detail); $i++) {
    if (isset($data_detail[$i])) {

        $user_cash = $data_detail[$i]->cash;
    } else {
        echo "No Data Found";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>ID : <?php echo $user_id ?></h1>
    <h1>USERNAME : <?php echo $username ?></h1>
    <h1>NAME : <?php echo $name ?></h1>
    <?php switch ($acc_type):
        case 0: ?>
            <h1>Role : User</h1>
            <?php break; ?>
        <?php
        case 1: ?>
            <h1>Role : Admin</h1>
            <input type="text">
            <?php break; ?>
    <?php endswitch; ?>
    <h1>CASH : <?php echo $username ?></h1>
    <h1>CREATED AT : <?php echo $user_cash ?></h1>
    <?php

    for ($i = 0; $i < count($data_game); $i++) {
        if (isset($data_game[$i])) {

            $game_id = $data_game[$i]->game_id;
            $game_name = $data_game[$i]->game_name;
            $game_rate = $data_game[$i]->rate_cal;
            $sum = 0;
            for ($j = 0; $j < count($data_user_game); $j++) {
                if ($game_id == $data_user_game[$j]->game_id) {
                    $sum += $data_user_game[$j]->cash;
                }
            }
            $total = $sum * $game_rate;
            echo "Game : $game_name Cash : $total ($sum) Rate : $game_rate <br>";
        } else {
            echo "No Data Found";
        }
    }
    ?>
    <a href='logout'>logout</a>
</body>

</html>