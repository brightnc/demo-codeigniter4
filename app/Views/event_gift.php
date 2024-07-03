<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        let state = false

        function handleClick() {
            event.preventDefault()
            const t = document.getElementById("table_data");
            t.classList.toggle("hidden");
        }
    </script>
</head>

<body>
    <div class="w-full bg-pink-950 min-h-screen ">
        <div class="main-container bg-transparent max-w-xl mx-auto flex flex-col">
            <div class="h-[600px]">
                <img src="<?php echo base_url("/assets/head-img.jpg"); ?>" alt="head-img" class="object-fill h-full w-full">
            </div>

            <?php


            if (isset($data["code"])) {
                if ($data["code"] !== "101") {
                    $msg =  $data['message'];
                    echo "<p class='text-center text-white'>$msg</p>";
                    exit;
                }
            }
            if (!isset($data["more_data"])) {
                echo "<p class='text-center text-white'>No data</p>";
                exit;
            }


            $data_arr = $data["more_data"];
            function array_search2d($needle, $haystack)
            {
                for ($i = 0, $l = count($haystack); $i < $l; ++$i) {
                    if (in_array($needle, $haystack[$i])) return $i;
                }
                return false;
            }

            $searchTerm = "100030652";

            if (false !== ($pos = array_search2d($searchTerm, $data_arr))) {
                array_splice($data_arr, $pos, 1);
            }

            $top_1 = $data_arr[0];
            $top_2 = $data_arr[1];
            $top_3 = $data_arr[2];

            $start =  DateThai($top_1["startdate"]);
            $end =  DateThai($top_1["enddate"]);

            function DateThai($strDate)
            {
                $strYear = date("Y", strtotime($strDate)) + 543;
                $strMonth = date("n", strtotime($strDate));
                $strDay = date("j", strtotime($strDate));
                $strHour = date("H", strtotime($strDate));
                $strMinute = date("i", strtotime($strDate));
                $strSeconds = date("s", strtotime($strDate));
                $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");


                $strMonthThai = $strMonthCut[$strMonth];
                return "$strDay $strMonthThai $strYear  $strHour:$strMinute:$strSeconds";
            }

            ?>

            <div class="h-auto bg-pink-300 pb-10">
                <div class="top-3 ">
                    <div class="flex flex-col items-center mt-5 ">
                        <h3 class="font-bold italic">Rank 1</h3>
                        <div class="h-40 w-40 relative">
                            <img src="<?= $top_1["user_logo"] ?>" alt="top-1" class="object-fill h-full w-full rounded-full border-8 border-[#FFD700]">
                            <span class="absolute bottom-0 right-[67px] bg-[#FFD700] rounded-full px-2">1</span>
                        </div>
                        <p><?= $top_1["user_name"] ?></p>
                        <p>UID : <?= $top_1["user_id"] ?></p>
                    </div>

                    <div class="top2-3 flex justify-center mx-7 gap-9 max-sm:flex-col">
                        <div class="flex flex-col items-center mt-5">
                            <h3 class="font-bold italic">Rank 2</h3>
                            <div class="h-40 w-40 relative ">
                                <img src="<?= $top_2["user_logo"] ?>" alt="top-2" class="object-fill h-full w-full rounded-full border-8 border-[#A9A9A9]">
                                <span class="absolute bottom-0 right-[67px] bg-[#A9A9A9] rounded-full px-2">2</span>
                            </div>
                            <p><?= $top_2["user_name"] ?></p>
                            <p>UID : <?= $top_2["user_id"] ?></p>
                        </div>
                        <div class="flex flex-col items-center mt-5">
                            <h3 class="font-bold italic">Rank 3</h3>
                            <div class="h-40 w-40 relative">
                                <img src="<?= $top_3["user_logo"] ?>" alt="top-3" class="object-fill h-full w-full rounded-full border-8 border-[#CD7F32]">
                                <span class="absolute bottom-0 right-[67px] bg-[#CD7F32] rounded-full px-2">3</span>
                            </div>
                            <p><?= $top_3["user_name"] ?></p>
                            <p>UID : <?= $top_3["user_id"] ?></p>
                        </div>
                    </div>

                    <div class="text-center mt-9">
                        <button onclick="handleClick()" class="rounded-full py-5 px-4 w-auto bg-black text-white">ดูรายการอันดับเพิ่มเติม</button>
                        <p class="mt-7">เริ่ม <?= $start ?> - <?= $end ?> </p>
                    </div>

                </div>
            </div>

            <div class="h-auto bg-pink-300 hidden pb-4" id="table_data">
                <p class="text-center py-3 bg-transparent text-black font-bold">ข้อมูลอัพเดทวันที่ <?= DateThai(date("Y-m-d H:i:s")) ?> </th>
                <table class="w-4/5 table-fixed  text-center mx-auto">
                    <tr>
                        <th class=" text-base py-3 bg-slate-500 text-white">ลำดับ</th>
                        <th class=" text-base py-3 bg-slate-500 text-white">ข้อมูล user</th>
                        <th class=" text-base py-3 bg-slate-500 text-white">รางวัล</th>

                    </tr>

                    <?php

                    $counter = count($data_arr);
                    $rank = 0;
                    for ($i = 0; $i < $counter; $i++) {
                        # code...
                        $user_id = $data_arr[$i]["user_id"];
                        $user_name = $data_arr[$i]["user_name"];
                        $user_logo = $data_arr[$i]["user_logo"];
                        $count_gift = $data_arr[$i]["count_gift"];


                        // if ($user_id == "100030652") {
                        //     $counter++;
                        //     continue;
                        // }
                        $rank++;

                        if ($rank % 2 !== 0) {
                            echo "<tr class='bg-yellow-100'>";
                        } else {
                            echo "<tr class='bg-slate-300'>";
                        }


                        echo "<td  class=' text-black'>" . $rank . "</td>";
                        echo "<td  class=''>";
                        echo "<div class='flex flex-col items-center text-black py-3'>
                                <div class='h-[80px] w-[80px]'>
                                <img src='$user_logo' alt='rank-$rank' class='object-fill h-full w-full rounded-full'>
                            </div>
                        <p>$user_name</p>
                        <p>UID : $user_id</p>

                            </div>";
                        echo "</td>";
                        if ($count_gift >= 100) {
                            echo "<td  class=' text-black'>";
                            echo "<div class='flex flex-col items-center text-black py-3'>
                           
                    <p>ได้รับรางวัล</p>
                    <p>คะแนน: $count_gift</p>

                        </div>";
                            echo "</td>";
                        } else {
                            echo "<td  class=' text-black'>" . "" . "</td>";
                        }


                        echo "</tr>";
                    }


                    ?>
                </table>
            </div>

            <footer class="text-center w-full bg-black text-white py-3">
                <p>© 2024 Company . All rights reserved.</p>
            </footer>


        </div>
    </div>
</body>

</html>