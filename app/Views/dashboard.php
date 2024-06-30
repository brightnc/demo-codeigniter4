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
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
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

    myModal.addEventListener('shown.bs.modal', () => {
        myInput.focus()
    })
    </script>
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
        console.log("datepicker : " + datepicker + " time_input : " + time_input + " movie_id  : " + movie_id +
            " movie_duration : " + movie_duration);
        $.ajax({
            type: "POST",
            url: "add_showtime",
            data: "date=" + datepicker + "&time=" + time_input + "&movie_id=" + movie_id +
                "&movie_duration=" + movie_duration + "&price=" + price + "&promotion=" + promotion,
            success: function(msg) {
                alert("Data Saved: " + msg);
            }
        });
        $(document).ajaxStop(function() {
            window.location.reload();
        });
    }

    function handleAddMovie() {
        const movie_name = $('#add_movie_name').val();
        const movie_start = $('#add_movie_start').val();
        const movie_end = $('#add_movie_end').val();
        const movie_rate = $('#add_movie_rate').val();
        const movie_duration = $('#add_movie_duration').val();

        $.ajax({
            type: "POST",
            url: "add_movie",
            data: "movie_name=" + movie_name + "&movie_start=" + movie_start + "&movie_end=" + movie_end +
                "&movie_rate=" + movie_rate + "&movie_duration=" + movie_duration,
            success: function(msg) {
                alert("Data Saved: " + msg);
            }
        });
        $(document).ajaxStop(function() {
            window.location.reload();
        });
    }

    function handleClick(movie_id, movie_name, start_date, end_date, duration_min, rate_age) {

        console.log(movie_id);
        $.ajax({
            type: "post",
            url: "edit_movie",
            data: "movie_name=" + movie_name + "&movie_id=" + movie_id + "&start_date=" + start_date +
                "&end_date=" + end_date + "&duration_min=" + duration_min + "&rate_age=" + rate_age,
            success: function(msg) {
                console.log(msg);
            }
        });


    }

    function handleDel() {
        return
    }
    </script>
</head>

<body>
    <div class="mt-6 mx-5">
        <h1 class="text-3xl font-bold">ADMIN DASHBOARD : <span
                class="font-normal"><?php echo $data_user[0]->username; ?></span></h1>


        <h2 class="text-2xl mt-5 font-normal">เพิ่มหนัง</h2>
        <div class="flex">
            <div class="border-2 border-sky-500 rounded-md flex flex-col p-4 w-2/5">

                <div class="w-full">
                    <label for="add_movie_name" class="inline">ชื่อหนัง :</label>
                    <input type="text" id="add_movie_name"
                        class="mb-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 ">
                </div>

                <div>
                    <label for="add_movie_start">วันเข้าโรง :</label>
                    <input type="date" id="add_movie_start"
                        class="mb-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 ">
                </div>
                <div>
                    <label for="add_movie_end">วันออกโรง :</label>
                    <input type="date" id="add_movie_end"
                        class="mb-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 ">
                </div>
                <div>
                    <label for="add_movie_rate">เรทอายุ(ปี) :</label>
                    <input type="number" id="add_movie_rate"
                        class="mb-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 ">
                </div>


                <div>
                    <label for="add_movie_duration">ความยาวหนัง(นาที) :</label>
                    <input type="number" id="add_movie_duration"
                        class="mb-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5 ">
                </div>

                <button onclick="handleAddMovie()"
                    class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">เพิ่ม</button>
            </div>


            <div class="w-3/5">
                <table class="w-full border-collapse border border-slate-400 text-center">

                    <tr>
                        <th class="border border-slate-300">id</th>
                        <th class="border border-slate-300">รายชื่อหนัง</th>
                        <th class="border border-slate-300">หนังเข้าฉาย</th>
                        <th class="border border-slate-300">หนังออกโรง</th>
                        <th class="border border-slate-300">เวลาหนัง</th>
                        <th class="border border-slate-300">เรทอายุ</th>

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
                        echo "<td  class='border border-slate-300'>" . $movie_id . "</td>";
                        echo "<td  class='border border-slate-300'>" . $movie_name . "</td>";
                        echo "<td  class='border border-slate-300'>" . $start_date . "</td>";
                        echo "<td  class='border border-slate-300'>" . $end_date . "</td>";
                        echo "<td  class='border border-slate-300'>" . $duration_min . "</td>";
                        echo "<td  class='border border-slate-300'>" . $rate_age . "</td>";
                        echo "<td  class='border border-slate-300'>" . "<a class='font-bold text-orange-400 cursor-pointer' href=" . "'" . base_url('/ci/public/movie/edit_movie') . "?movie_name=" . rawurlencode($movie_name) . "&movie_id=" . $movie_id . "&start_date=" . $start_date .
                            "&end_date=" . $end_date . "&duration_min=" . $duration_min . "&rate_age=" . $rate_age . "'" . ">EDIT</a>" . "</td>";

                        echo "<td  class='border border-slate-300'>" . "<a class='font-bold text-red-800 cursor-pointer'  href=" . "'" . base_url('/ci/public/movie/del_movie') . "?movie_id=" . $movie_id . "'" . ">DEL</a>" . "</td>";
                        echo "</tr>";
                    }

                    ?>
                </table>

            </div>
        </div>



        <h2 class="text-2xl mt-5 font-normal">เพิ่มรอบฉาย</h2>
        <div class="flex gap-3">
            <div class="flex items-center w-1/5 justify-between">
                <label for="movies_select">เลือกหนัง : </label>
                <select name="movies_select" id="movies_select"
                    class="ml-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-3/4 p-2.5 ">>
                    <?php
                for ($i = 0; $i < count($data_select); $i++) {
                    $movie_name = $data_select[$i]["movie_name"];
                    $movie_id = $data_select[$i]["movie_id"];
                    $duration_min = $data_select[$i]["duration_min"];
                    echo "<option value='{$movie_id},{$duration_min}' id=select_{$movie_id}>{$movie_name}</option>";
                }
                ?>
                </select>
            </div>

            <div class="flex items-center  justify-between ">
                <label for="movies_select" class="pl-4">วันที่ฉาย :</label>
                <input type="text" id="datepicker"
                    class="ml-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-3/5 p-2.5 ">
            </div>
            <div class="flex items-center  justify-between">
                <label for="time_input" class="pl-4">เวลาเริ่ม</label>
                <input type="time" id="time_input" name="time_input"
                    class="ml-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-3/5 p-2.5 ">
            </div>

            <div class="flex items-center  justify-between">
                <label for="price" class="pl-4">ราคาตั๋ว</label>
                <input type="number" id="price" name="price"
                    class="ml-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-3/5 p-2.5 ">
            </div>
            <div class="flex items-center  justify-between">
                <label for="promotion" class="pl-4">ราคาโปรโมชั่น</label>
                <input type="number" id="promotion" name="promotion"
                    class="ml-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-3/5 p-2.5 ">
            </div>

            <button
                class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                onclick="handleAddShowTime()">เพิ่ม</button>
        </div>

        <h2 class="text-2xl mt-5 font-normal">รายละเอียดรอบหนัง</h1>

            <table class="w-full border-collapse border border-slate-400 text-center my-6">

                <tr>
                    <th class="border border-slate-300">id</th>
                    <th class="border border-slate-300">รายชื่อหนัง</th>
                    <th class="border border-slate-300">หนังเริ่มฉาย</th>
                    <th class="border border-slate-300">หนังจบ</th>
                    <th class="border border-slate-300">เวลาหนัง</th>
                    <th class="border border-slate-300">เรทอายุ</th>
                    <th class="border border-slate-300">ราคาตั๋ว</th>
                    <th class="border border-slate-300">ราคาโปรโมชั่น</th>
                    <th class="border border-slate-300">จองแล้ว</th>

                </tr>

                <?php
                $data_select = [];
                for ($i = 0; $i < count($data_admin_movie_detail); $i++) {
                    # code...
                    $movie_detail_id = $data_admin_movie_detail[$i]->movie_detail_id;
                    $movie_id = $data_admin_movie_detail[$i]->movie_id;
                    $movie_name = $data_admin_movie_detail[$i]->movie_name;
                    $movie_start = $data_admin_movie_detail[$i]->movie_start;
                    $movie_end = $data_admin_movie_detail[$i]->movie_end;
                    $duration_min = $data_admin_movie_detail[$i]->duration_min;
                    $rate_age = $data_admin_movie_detail[$i]->rate_age;
                    $ticket_prices = $data_admin_movie_detail[$i]->ticket_prices;
                    $ticket_discount = $data_admin_movie_detail[$i]->ticket_discount;
                    $reservation_count = $data_admin_movie_detail[$i]->reservation_count;

                    array_push($data_select, array("movie_id" => $movie_id, "movie_name" => $movie_name, "duration_min" => $duration_min));
                    echo "<tr>";
                    echo "<td class='border border-slate-300'>" . $movie_detail_id . "</td>";
                    echo "<td class='border border-slate-300'>" . $movie_name . "</td>";
                    echo "<td class='border border-slate-300'>" . $movie_start . "</td>";
                    echo "<td class='border border-slate-300'>" . $movie_end . "</td>";
                    echo "<td class='border border-slate-300'>" . $duration_min . "</td>";
                    echo "<td class='border border-slate-300'>" . $rate_age . "</td>";
                    echo "<td class='border border-slate-300'>" . $ticket_prices . "</td>";
                    echo "<td class='border border-slate-300'>" . $ticket_discount . "</td>";
                    echo "<td class='border border-slate-300'>" . $reservation_count . "</td>";
                    echo "<td class='border border-slate-300'>" . "<a class='font-bold text-orange-400 cursor-pointer' href=" . "'" . base_url('/ci/public/movie/edit_movie_detail') . "?movie_name=" . rawurlencode($movie_name) . "&movie_detail_id=" . $movie_detail_id . "&movie_start=" . rawurlencode($movie_start) .
                        "&movie_end=" . rawurlencode($movie_end) . "&duration_min=" . $duration_min . "&rate_age=" . $rate_age . "&ticket_prices=" . $ticket_prices . "&ticket_discount=" . $ticket_discount . "'" . ">EDIT</a>" . "</td>";
                    echo "<td class='border border-slate-300'>" . "<a class='font-bold text-red-800 cursor-pointer' href=" . "'" . base_url('/ci/public/movie/del_movie_detail') . "?movie_detail_id=" . $movie_detail_id . "'" . ">DEL</a>" . "</td>";
                }

                ?>
            </table>

            <a class=" text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                href='logout'>logout</a>
    </div>
</body>

</html>