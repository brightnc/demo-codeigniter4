<?php
$data = $user_data;
$data_detail = $user_detail;
$data_user_game = $user_game;
$data_game = $game_info;
$data_acc_info = $acc_info;
$data_user_event_type_1 = $user_event_type_1;
$data_user_event_type_0 = $user_event_type_0;
$data_userid_encrypted = $userid_encrypted;
$data_userid_decrypted = $userid_decrypted;

print_r($data_userid_encrypted);
echo "<hr>";
print_r($data_userid_decrypted);
echo "<hr>";

$data_reward_status = $reward_status;




for ($i = 0; $i < count($data); $i++) {
    if (isset($data[$i])) {
        $user_id = $data[$i]->user_id;
        $username = $data[$i]->username;
        $created_at = $data[$i]->created_at;
        $status_approve = $data[$i]->status_approve;
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

        function handleReward(user_id, status_approve, total, arr, reward_status) {
            if (status_approve != 1) {
                alert("บัญชีนี้ยังไม่ยืนยัน !");
                return;
            }

            if (reward_status == 1) {
                alert("คุณรับรางวัลนี้แล้ว !");
                return;
            }
            const obj = JSON.parse(arr)
            console.log(user_id, status_approve, total, obj);

            for (i = 0; i < obj.length; i++) {
                console.log(obj[i].game_name);
                console.log(obj[i].total);
                switch (obj[i].game_name) {
                    case "ROA":
                        if (obj[i].total < 15000) {
                            alert("ยอดของเกม: " + obj[i].game_name + " ไม่ถึงยอดขั้นต่ำ 15000")
                            return;
                        }
                        break;
                    case "ROB":
                        if (obj[i].total < 10000) {
                            alert("ยอดของเกม: " + obj[i].game_name + " ไม่ถึงยอดขั้นต่ำ 10000")
                            return;
                        }
                        break;
                    case "ROC":
                        if (obj[i].total < 50000) {
                            alert("ยอดของเกม: " + obj[i].game_name + " ไม่ถึงยอดขั้นต่ำ 50000")
                            return;
                        }
                        break;
                }
            }

            if (total < 100000) {
                alert("ยอดรวมทั้งหมดไม่ถึงยอดขั้นต่ำ 100,000 คุณมียอดทั้งหมด " + total)
                return;
            }

            $.ajax({
                type: "POST",
                url: "reward",
                data: "id=" + user_id,
                success: function(msg) {
                    alert(msg);
                }
            });
            $(document).ajaxStop(function() {
                window.location.reload();
            });

        }
    </script>
    <style>
        table,
        th,
        td {
            border: 1px solid;
            text-align: center;
        }

        td {
            padding: 8px;
        }

        table {
            border-collapse: collapse;
        }
    </style>
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

    <table>
        <tr>
            <th>No</th>
            <th>Event_id</th>
            <th>Username</th>
            <th>Cash</th>
            <th>Time</th>
            <th>Reward</th>
            <th>type_user</th>
        </tr>
        <?php
        for ($i = 0; $i < count($data_user_event_type_1); $i++) {
            if (isset($data_user_event_type_1[$i])) {
                $no = $data_user_event_type_1[$i]->no;
                $event_id = $data_user_event_type_1[$i]->event_id;
                $username = $data_user_event_type_1[$i]->username;
                $total = $data_user_event_type_1[$i]->value_sum;
                $timestamp = $data_user_event_type_1[$i]->date_time;
                $type_user = $data_user_event_type_1[$i]->type_user;
                echo "<tr>";
                echo "<td>$no</td>";
                echo "<td>$event_id </td>";
                echo "<td >$username</td>";
                echo "<td >$total</td>";
                echo "<td >$timestamp</td>";

                switch ($no) {
                    case 1:
                        if ($total < 10000) {
                            echo "<td >ยอดเงินไม่ตรงเงื่อนไข</td>";
                            break;
                        }
                        echo "<td >รับเงินสด 1500</td>";
                        break;
                    case 2:
                        if ($total < 10000) {
                            echo "<td >ยอดเงินไม่ตรงเงื่อนไข</td>";
                            break;
                        }
                        echo "<td >รับเงินสด 1000</td>";
                        break;
                    case 3:
                        if ($total < 10000) {
                            echo "<td >ยอดเงินไม่ตรงเงื่อนไข</td>";
                            break;
                        }
                        echo "<td >รับเงินสด 500</td>";
                        break;
                    case 4:
                        if ($total < 10000) {
                            echo "<td >ยอดเงินไม่ตรงเงื่อนไข</td>";
                            break;
                        }
                        echo "<td >รับเงินสด 100</td>";
                        break;

                    case 5:
                        if ($total < 10000) {
                            echo "<td >ยอดเงินไม่ตรงเงื่อนไข</td>";
                            break;
                        }
                        echo "<td >รับเงินสด 100</td>";
                        break;

                    case 6:
                        if ($total < 10000) {
                            echo "<td >ยอดเงินไม่ตรงเงื่อนไข</td>";
                            break;
                        }
                        echo "<td >รับเงินสด 100</td>";
                        break;

                    default:
                        # code...
                        echo "<td ></td>";
                        break;
                }
                echo "<td >$type_user</td>";

                echo "</tr>";
            } else {
                echo "No Data Found";
            }
        }
        ?>
    </table>

    <h2>ไม่มีสิทธิ์</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Event_id</th>
            <th>Username</th>
            <th>Cash</th>
            <th>Time</th>
            <th>Reward</th>
            <th>type_user</th>
        </tr>
        <?php
        for ($i = 0; $i < count($data_user_event_type_0); $i++) {
            if (isset($data_user_event_type_0[$i])) {
                $no = $data_user_event_type_0[$i]->no;
                $event_id = $data_user_event_type_0[$i]->event_id;
                $username = $data_user_event_type_0[$i]->username;
                $total = $data_user_event_type_0[$i]->value_sum;
                $timestamp = $data_user_event_type_0[$i]->date_time;
                $type_user = $data_user_event_type_0[$i]->type_user;
                echo "<tr>";
                echo "<td>$no</td>";
                echo "<td>$event_id </td>";
                echo "<td >$username</td>";
                echo "<td >$total</td>";
                echo "<td >$timestamp</td>";

                switch ($no) {
                    case 1:
                        if ($total < 10000) {
                            echo "<td >ยอดเงินไม่ตรงเงื่อนไข</td>";
                            break;
                        }
                        echo "<td >รับเงินสด 1500</td>";
                        break;
                    case 2:
                        if ($total < 10000) {
                            echo "<td >ยอดเงินไม่ตรงเงื่อนไข</td>";
                            break;
                        }
                        echo "<td >รับเงินสด 1000</td>";
                        break;
                    case 3:
                        if ($total < 10000) {
                            echo "<td >ยอดเงินไม่ตรงเงื่อนไข</td>";
                            break;
                        }
                        echo "<td >รับเงินสด 500</td>";
                        break;
                    case 4:
                        if ($total < 10000) {
                            echo "<td >ยอดเงินไม่ตรงเงื่อนไข</td>";
                            break;
                        }
                        echo "<td >รับเงินสด 100</td>";
                        break;

                    case 5:
                        if ($total < 10000) {
                            echo "<td >ยอดเงินไม่ตรงเงื่อนไข</td>";
                            break;
                        }
                        echo "<td >รับเงินสด 100</td>";
                        break;

                    case 6:
                        if ($total < 10000) {
                            echo "<td >ยอดเงินไม่ตรงเงื่อนไข</td>";
                            break;
                        }
                        echo "<td >รับเงินสด 100</td>";
                        break;

                    default:
                        # code...
                        echo "<td ></td>";
                        break;
                }
                echo "<td >$type_user</td>";

                echo "</tr>";
            } else {
                echo "No Data Found";
            }
        }
        ?>
    </table>
    <?php
    $arr = [];
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
            $arr[$i]["game_name"] = $game_name;
            $arr[$i]["total"] = $total;
            echo "Game : $game_name Cash : $total ($sum) Rate : $game_rate <br>";
        } else {
            echo "No Data Found";
        }
    }
    $result = 0;
    for ($i = 0; $i < count($arr); $i++) {
        echo $arr[$i]["total"];
        $result += $arr[$i]["total"];
        // $arr[$i] = implode(",", $arr[$i]);
    }
    $arr_str = json_encode($arr);
    print_r($arr_str);
    echo "<br>";
    echo "<br>";
    $rewardStatus = $data_reward_status[0]->value_reward;
    echo "<button id=btn-reward onclick=handleReward('$user_id','$status_approve','$result','$arr_str','$rewardStatus')>รับรางวัล</button>";
    ?>
    <br>

    <a href='logout'>logout</a>
</body>

</html>