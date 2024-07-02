<?php
$data_movie = $movie_info;
$movie_id = $data_movie["movie_id"];
$movie_name = $data_movie["movie_name"];
$start_date = $data_movie["start_date"];
$end_date = $data_movie["end_date"];
$rate_age = $data_movie["rate_age"];
$duration_min = $data_movie["duration_min"];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function handleEditMovie(movie_id) {

            const movie_name = $('#edit_movie_name').val();
            const start_date = $('#edit_movie_start').val();
            const end_date = $('#edit_movie_end').val();
            const rate_age = $('#edit_movie_rate').val();
            const duration_min = $('#edit_movie_duration').val();

            const movieNameEncoded = encodeURIComponent(movie_name);
            $.ajax({
                type: "post",
                url: "edit_movie_process",
                data: "movie_name=" + movieNameEncoded + "&movie_id=" + movie_id + "&start_date=" + start_date +
                    "&end_date=" + end_date + "&duration_min=" + duration_min + "&rate_age=" + rate_age,
                success: function(msg) {
                    const status = confirm(msg + " : ต้องการกลับหน้าหลักหรือไม่")
                    if (status) {
                        window.location.href = "login_process";
                    }
                    return;
                }
            });
        }
    </script>
</head>

<body>
    <div>
        <h2>แก้ไขหนัง</h2>
        <label for="edit_movie_name">ชื่อหนัง :</label>
        <input type="text" id="edit_movie_name" value='<?php echo $movie_name ?>'>
        <label for="edit_movie_start">วันเข้าโรง :</label>
        <input type="date" id="edit_movie_start" value=<?= $start_date ?>>
        <label for="edit_movie_end">วันออกโรง :</label>
        <input type="date" id="edit_movie_end" value=<?= $end_date ?>>
        <label for="edit_movie_rate">เรทอายุ(ปี) :</label>
        <input type="number" min="0" id="edit_movie_rate" value=<?= $rate_age ?>>
        <label for="edit_movie_duration">ความยาวหนัง(นาที) :</label>
        <input type="number" min="0" id="edit_movie_duration" value=<?= $duration_min ?>>
        <button onclick="handleEditMovie('<?= $movie_id ?>')">ยืนยัน</button>
    </div>
</body>

</html>