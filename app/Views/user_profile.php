<?php
$data_info = $info;
$data_user = $user;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <h1>User : <?php echo $data_user[0]->username; ?></h1>

    <table>

        <tr>
            <th>รายชื่อหนัง</th>
            <th>เวลาหนังเริ่ม</th>
            <th>เวลาหนังจบ</th>
            <th>เวลาหนัง</th>
            <th>เรทอายุ</th>
            <th>ราคาตั๋ว</th>
        </tr>

        <?php

        for ($i = 0; $i < count($data_info); $i++) {
            # code...

            echo "<tr>";
            echo "<td>" . $data_info[$i]->movie_name . "</td>";
            echo "<td>" . $data_info[$i]->movie_start . "</td>";
            echo "<td>" . $data_info[$i]->movie_end . "</td>";
            echo "<td>" . $data_info[$i]->duration_min . "</td>";
            echo "<td>" . $data_info[$i]->rate_age . "</td>";
            echo "<td>" . $data_info[$i]->total_price . "</td>";
            echo "</tr>";
        }

        ?>
    </table>

    <form action="reservation" method="post">
        <input type="submit" value="จองตั๋ว">
    </form>
    <a href='logout'>logout</a>
</body>

</html>