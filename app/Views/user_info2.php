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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function handleEdit(username, user_id) {
            event.preventDefault();
            console.log(username);
            document.getElementById(username).innerHTML = `<input type='text' id='input_username' value=${username}><button id=btn-save-${username} onclick=handleSave('${user_id}')>save</button><button id=btn-cancle-${username} onclick=handleCancle('${username}')>cancle</button>`;
        }

        function handleCancle(username) {
            document.getElementById(username).innerHTML = username;
        }

        function handleSave(user_id) {
            const new_username = document.getElementById("input_username").value
            $.ajax({
                type: "POST",
                url: "update_username",
                data: "id=" + user_id + "&username=" + new_username,
                success: function(msg) {
                    alert("Data Saved: " + msg);
                }
            });
            $(document).ajaxStop(function() {
                window.location.reload();
            });
        }

        function handleDel(user_id) {
            $.ajax({
                type: "POST",
                url: "delete_user",
                data: "id=" + user_id,
                success: function(msg) {
                    alert("Data Deleted: " + msg);
                }
            });
            $(document).ajaxStop(function() {
                window.location.reload();
            });
        }
    </script>
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
            <form action="update_user_cash" method="post" name="add_form">
                <label for="user_id" style="display: block;">user id</label>
                <input type="text" name="user_id">
                <label for="cash" style="display: block;">ยอดเงิน</label>
                <input type="text" name="cash">
                <label for="types">Choose a type:</label>
                <select name="types" id="types">
                    <option value="1">เพิ่มยอดเงิน</option>
                    <option value="2">ลดยอดเงิน</option>
                </select>
                <input type="submit" name="add_form">
            </form>

            <table>
                <tr>
                    <th>id</th>
                    <th>username</th>
                    <th>actions</th>
                </tr>

                <?php
                $data_users = $users;
                for ($i = 0; $i < count($data_users); $i++) {
                    if (isset($data_users[$i])) {
                        $user_id = $data_users[$i]->user_id;
                        $username = $data_users[$i]->username;
                        echo "<tr>";
                        echo "<td>$user_id</td>";
                        echo "<td id=$username>$username</td>";
                        echo "<td><button onclick=handleEdit('$username','$user_id')>edit</button> <button onclick=handleDel('$user_id')>delete</button></td>";
                        echo "</tr>";
                    } else {
                        echo "No Data Found";
                    }
                }
                ?>
            </table>

            <?php break; ?>
    <?php endswitch; ?>
    <h1>CASH : <?php echo $user_cash ?></h1>
    <h1>CREATED AT : <?php echo $created_at ?></h1>
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