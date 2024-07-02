<?php
$data_movie_list = $movie_list;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <table class="w-full border-collapse border border-slate-400 text-center mt-6">

        <tr>
            <th class="border border-slate-300">รายชื่อหนัง</th>
            <th class="border border-slate-300">หนังเข้าฉาย</th>
            <th class="border border-slate-300">หนังออกโรง</th>
            <th class="border border-slate-300">เวลาหนัง</th>
            <th class="border border-slate-300">เรทอายุ</th>

        </tr>

        <?php
        for ($i = 0; $i < count($data_movie_list); $i++) {
            # code...
            $movie_id = $data_movie_list[$i]->movie_id;
            $movie_name = $data_movie_list[$i]->movie_name;
            $start_date = $data_movie_list[$i]->start_date;
            $end_date = $data_movie_list[$i]->end_date;
            $duration_min = $data_movie_list[$i]->duration_min;
            $rate_age = $data_movie_list[$i]->rate_age;
            echo "<tr>";
            echo "<td  class='border border-slate-300'>" . $movie_name . "</td>";
            echo "<td  class='border border-slate-300'>" . $start_date . "</td>";
            echo "<td  class='border border-slate-300'>" . $end_date . "</td>";
            echo "<td  class='border border-slate-300'>" . $duration_min . "</td>";
            echo "<td  class='border border-slate-300'>" . $rate_age . "</td>";
            echo "<td  class='border border-slate-300'>" . "<a class='font-bold text-red-800 cursor-pointer'  href=" . "'" . base_url('/movie_showtime') . "?movie_id=" . $movie_id . "'" . ">ดูรอบ</a>" . "</td>";
            echo "</tr>";
        }

        ?>
    </table>
</body>

</html>