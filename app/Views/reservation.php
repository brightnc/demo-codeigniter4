<?php
$data_movies_list = $movies;
$data_user_id = $user_id;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function handleSave(movie_detail_id, user_id, final_prices,rate_age) {
            event.preventDefault();
            console.log("movie_detail_id >>>", movie_detail_id);
            console.log("user_id >>>", user_id);
            console.log("final_prices >>>", final_prices);

            if (confirm("ยืนยันการจอง") == true) {
                $.ajax({
                    type: "POST",
                    url: "reservation_process",
                    data: "user_id=" + user_id + "&movie_detail_id=" + movie_detail_id + "&final_prices=" + final_prices+"&rate_age="+rate_age,
                    success: function(msg) {
                        const status = confirm(msg + " : ต้องการกลับหน้าหลักหรือไม่")
                        if (status) {
                            window.location.href = "login_process";
                        }
                        return;
                    }
                });
            }

            return;


        }
    </script>
</head>

<body>
    <h1>Reservation</h1>
    <table>

        <tr>
            <th>รายชื่อหนัง</th>
            <th>เวลาหนังเริ่ม</th>
            <th>เวลาหนังจบ</th>
            <th>เวลาหนัง</th>
            <th>เรทอายุ</th>
            <th>ราคาตั๋ว</th>
            <th>จอง</th>
        </tr>

        <?php

        for ($i = 0; $i < count($data_movies_list); $i++) {
            # code...

            echo "<tr>";
            echo "<td>" . $data_movies_list[$i]->movie_name . "</td>";
            echo "<td>" . $data_movies_list[$i]->movie_start . "</td>";
            echo "<td>" . $data_movies_list[$i]->movie_end . "</td>";
            echo "<td>" . $data_movies_list[$i]->duration_min . "</td>";
            echo "<td>" . $data_movies_list[$i]->rate_age . "</td>";

            $final_prices = 0;
            if ($data_movies_list[$i]->ticket_discount > 0) {
                $final_prices = $data_movies_list[$i]->ticket_discount;
            } else {
                $final_prices = $data_movies_list[$i]->ticket_prices;
            }
            echo "<td>" . $final_prices . "</td>";
            echo "<td><button id=btn-reservation-{$data_movies_list[$i]->movie_detail_id} onclick=handleSave('{$data_movies_list[$i]->movie_detail_id}','{$data_user_id}','{$final_prices}','{$data_movies_list[$i]->rate_age}')>จอง</button></td>";

            echo "</tr>";
        }

        ?>
    </table>
</body>

</html>