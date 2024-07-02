<?php

$data_movie = $movie_info;
$movie_detail_id = $data_movie["movie_detail_id"];
$movie_name = $data_movie["movie_name"];
$movie_start = $data_movie["movie_start"];
$movie_end = $data_movie["movie_end"];
$rate_age = $data_movie["rate_age"];
$duration_min = $data_movie["duration_min"];
$ticket_prices = $data_movie["ticket_prices"];
$ticket_discount = $data_movie["ticket_discount"];

$startDateTimeArr = explode(" ", $movie_start);
$movie_start_date = $startDateTimeArr[0];
$movie_start_time = $startDateTimeArr[1];

$endDateTimeArr = explode(" ", $movie_end);
$movie_end_time = $endDateTimeArr[1];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#edit_movie_start_date").change(() => {
                alert('this actually works');
            })

            function handleEditMovie(movie_detail_id) {
                const movie_start_date = $('#edit_movie_start_date').val();
                const movie_start_time = $('#edit_movie_start_time').val();
                const movie_end_time = $('#edit_movie_end_time').val();
                const ticket_prices = $('#ticket_prices').val();
                const ticket_discount = $('#ticket_discount').val();

                const movie_start_format = `${movie_start_date} ${movie_start_time}`;
                const movie_end_format = `${movie_start_date} ${movie_end_time}`;

                $.ajax({
                    type: "post",
                    url: "edit_movie_detail_process",
                    data: "movie_detail_id=" + movie_detail_id + "&movie_start=" + movie_start_format +
                        "&movie_end=" + movie_end_format + "&ticket_prices=" + ticket_prices + "&ticket_discount=" + ticket_discount,
                    success: function(msg) {
                        const status = confirm(msg + " : ต้องการกลับหน้าหลักหรือไม่")
                        if (status) {
                            window.location.href = "login_process";
                        }
                        return;
                    }
                });
            }
        });
    </script>
</head>

<body>
    <div>
        <h2>แก้ไขรายละเอียดรอบหนัง</h2>

        <label for="edit_movie_name">ชื่อหนัง :</label>
        <input disabled type="text" id="edit_movie_name" value='<?php echo $movie_name ?>'>

        <label for="edit_movie_start_date">รอบวันที่ :</label>
        <input type="date" id="edit_movie_start_date" value=<?= $movie_start_date ?>>

        <label for="edit_movie_start_time">เวลาหนังเริ่มฉาย :</label>
        <input type="time" id="edit_movie_start_time" value=<?= $movie_start_time ?>>

        <label for="edit_movie_end_time">เวลาหนังจบ :</label>
        <input type="time" disabled id="edit_movie_end_time" value=<?= $movie_end_time ?>>

        <label for="ticket_prices">ราคาตั๋ว :</label>
        <input type="number" min="0" id="ticket_prices" value=<?= $ticket_prices ?>>

        <label for="ticket_discount">ราคาโปรโมชั่น :</label>
        <input type="number" min="0" id="ticket_discount" value=<?= $ticket_discount ?>>

        <button onclick="handleEditMovie('<?= $movie_detail_id ?>')">ยืนยัน</button>
    </div>
</body>

</html>