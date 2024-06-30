<?php
$data_info = $info;
$data_user = $user;
$data_user_age = $user_age;

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
    <div class="mt-6 mx-5 ">
        <h1 class="text-3xl font-bold mb-5">User : <?php echo $data_user[0]->username; ?></h1>
        <h1 class="text-3xl font-bold mb-5">Age : <?php echo $data_user_age; ?></h1>
        <a class=" text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
            href='logout'>logout</a>
        <div class="w-3/4">
            <table class="w-full my-6 border-collapse border border-slate-400 text-center">

                <tr>
                    <th class="border border-slate-300">รายชื่อหนัง</th>
                    <th class="border border-slate-300">เวลาหนังเริ่ม</th>
                    <th class="border border-slate-300">เวลาหนังจบ</th>
                    <th class="border border-slate-300">เวลาหนัง</th>
                    <th class="border border-slate-300">เรทอายุ</th>
                    <th class="border border-slate-300">ราคาตั๋ว</th>
                </tr>

                <?php

        for ($i = 0; $i < count($data_info); $i++) {
            # code...

            echo "<tr>";
            echo "<td class='border border-slate-300'>" . $data_info[$i]->movie_name . "</td>";
            echo "<td class='border border-slate-300'>" . $data_info[$i]->movie_start . "</td>";
            echo "<td class='border border-slate-300'>" . $data_info[$i]->movie_end . "</td>";
            echo "<td class='border border-slate-300'>" . $data_info[$i]->duration_min . "</td>";
            echo "<td class='border border-slate-300'>" . $data_info[$i]->rate_age . "</td>";
            echo "<td class='border border-slate-300'>" . $data_info[$i]->total_price . "</td>";
            echo "</tr>";
        }

        ?>
            </table>

            <form action="reservation" method="post">
                <input
                    class="cursor-pointer  text-white  bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    type="submit" value="จองตั๋ว">
            </form>

        </div>
    </div>
</body>

</html>