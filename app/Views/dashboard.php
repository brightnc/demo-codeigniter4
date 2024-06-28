<?php
$data_admin_movie_detail = $movie_detail;
$data_admin_movies = $admin_movies;
$data_user = $user;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">
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
            margin-bottom: 10px;
        }
    </style>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        function handleAddShowTime() {
            const datepicker = $('#datepicker').val();
            const time_input = $('#time_input').val();
            const price = $('#price').val();
            const promotion = $('#promotion').val();
            const movie_detail = $('#movies_select').find(":selected").val();
            const movie_detailArr = movie_detail.split(",")
            const movie_id = movie_detailArr[0];
            const movie_duration = movie_detailArr[1];
            console.log("datepicker : " + datepicker + " time_input : " + time_input + " movie_id  : " + movie_id + " movie_duration : " + movie_duration);
            $.ajax({
                type: "POST",
                url: "add_showtime",
                data: "date=" + datepicker + "&time=" + time_input + "&movie_id=" + movie_id +
                    "&movie_duration=" + movie_duration + "&price=" + price + "&promotion=" + promotion,
                success: function(msg) {
                    alert("Data Saved: " + msg);
                }
            });
        }
    </script>
</head>

<body>
    <h1>Admin : <?php echo $data_user[0]->username; ?></h1>

    <table>

        <tr>
            <th>id</th>
            <th>รายชื่อหนัง</th>
            <th>หนังเข้าฉาย</th>
            <th>หนังออกโรง</th>
            <th>เวลาหนัง</th>
            <th>เรทอายุ</th>

        </tr>

        <?php
        $data_select = [];
        for ($i = 0; $i < count($data_admin_movies); $i++) {
            # code...
            $movie_id = $data_admin_movies[$i]->movie_id;
            $movie_name = $data_admin_movies[$i]->movie_name;
            $start_date = $data_admin_movies[$i]->start_date;
            $end_date = $data_admin_movies[$i]->end_date;
            $duration_min = $data_admin_movies[$i]->duration_min;
            $rate_age = $data_admin_movies[$i]->rate_age;
            array_push($data_select, array("movie_id" => $movie_id, "movie_name" => $movie_name, "duration_min" => $duration_min));
            echo "<tr>";
            echo "<td>" . $movie_id . "</td>";
            echo "<td>" . $movie_name . "</td>";
            echo "<td>" . $start_date . "</td>";
            echo "<td>" . $end_date . "</td>";
            echo "<td>" . $duration_min . "</td>";
            echo "<td>" . $rate_age . "</td>";
        }

        ?>
    </table>

    <h2>เพิ่มรอบฉาย</h2>
    <div>
        <label for="movies_select">เลือกหนัง :</label>
        <select name="movies_select" id="movies_select">
            <?php
            for ($i = 0; $i < count($data_select); $i++) {
                $movie_name = $data_select[$i]["movie_name"];
                $movie_id = $data_select[$i]["movie_id"];
                $duration_min = $data_select[$i]["duration_min"];
                echo "<option value='{$movie_id},{$duration_min}' id=select_{$movie_id}>{$movie_name}</option>";
            }
            ?>
        </select>
        <label for="movies_select">วันที่ฉาย :</label>
        <input type="text" id="datepicker">
        <label for="time_input">เวลาเริ่ม</label>
        <input type="time" id="time_input" name="time_input">
        <label for="price">ราคาตั๋ว</label>
        <input type="number" id="price" name="price">
        <label for="promotion">ราคาโปรโมชั่น</label>
        <input type="number" id="promotion" name="promotion">
        <button onclick="handleAddShowTime()">เพิ่ม</button>
    </div>

    <h2>Booking</h1>

        <table>

            <tr>
                <th>id</th>
                <th>รายชื่อหนัง</th>
                <th>หนังเริ่มฉาย</th>
                <th>หนังจบ</th>
                <th>เวลาหนัง</th>
                <th>เรทอายุ</th>
                <th>ราคาตั๋ว</th>
                <th>ราคาโปรโมชั่น</th>

            </tr>

            <?php
            $data_select = [];
            for ($i = 0; $i < count($data_admin_movie_detail); $i++) {
                # code...
                $movie_id = $data_admin_movie_detail[$i]->movie_id;
                $movie_name = $data_admin_movie_detail[$i]->movie_name;
                $movie_start = $data_admin_movie_detail[$i]->movie_start;
                $movie_end = $data_admin_movie_detail[$i]->movie_end;
                $duration_min = $data_admin_movie_detail[$i]->duration_min;
                $rate_age = $data_admin_movie_detail[$i]->rate_age;
                $ticket_prices = $data_admin_movie_detail[$i]->ticket_prices;
                $ticket_discount = $data_admin_movie_detail[$i]->ticket_discount;

                array_push($data_select, array("movie_id" => $movie_id, "movie_name" => $movie_name, "duration_min" => $duration_min));
                echo "<tr>";
                echo "<td>" . $movie_id . "</td>";
                echo "<td>" . $movie_name . "</td>";
                echo "<td>" . $movie_start . "</td>";
                echo "<td>" . $movie_end . "</td>";
                echo "<td>" . $duration_min . "</td>";
                echo "<td>" . $rate_age . "</td>";
                echo "<td>" . $ticket_prices . "</td>";
                echo "<td>" . $ticket_discount . "</td>";
            }

            ?>
        </table>

</body>

</html>