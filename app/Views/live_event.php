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
    // $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");


    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear  ( $strHour:$strMinute น.)";
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>TakeMe</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="<?php echo base_url("/css/style.css"); ?>">
    <script>
        function handleClick() {
            event.preventDefault()
            const t = document.getElementById("table_data");
            t.classList.toggle("visible");
        }
    </script>

</head>

<body>

    <div class="wrapper">

        <div class="section1">

            <div class="pic-top"><img src="<?php echo base_url("/images/pic-top.jpg"); ?>" /></div>

            <div class="content">

                <h class="a2">
                    ไลฟ์เช้ารับปอง
                </h>
                <br /><br />

                <div class="box-rank">
                    <div class="sub-rank">
                        <div class="rank1">
                            <img src="<?= $top_1["user_logo"] ?>" alt="top-2">
                            <span>1</span>
                        </div>
                        <p><?= $top_1["user_name"] ?></p>
                        <p>UID : <?= $top_1["user_id"] ?></p>
                    </div>
                    <div class="sub-rank2">
                        <div>
                            <div class="rank2">
                                <img src="<?= $top_2["user_logo"] ?>" alt="top-2">
                                <span>2</span>
                            </div>
                            <p><?= $top_2["user_name"] ?></p>
                            <p>UID : <?= $top_2["user_id"] ?></p>
                        </div>


                        <div>
                            <div class="rank3">
                                <img src="<?= $top_3["user_logo"] ?>" alt="top-3">
                                <span>3</span>
                            </div>
                            <p><?= $top_3["user_name"] ?></p>
                            <p>UID : <?= $top_3["user_id"] ?></p>
                        </div>
                    </div>
                </div>
                <div>
                    <button onclick="handleClick()" class="bt-rank">ดูรายการอันดับเพิ่มเติม</button>

                </div>

                <div class="box-table visible" id="table_data">
                    <table>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ข้อมูล user</th>
                            <th>รางวัล</th>

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

                            $rank++;

                            switch ($rank) {
                                case 1:
                                    echo "<tr class='rankbg1'>";
                                    break;
                                case 2:
                                    echo "<tr class='rankbg2'>";
                                    break;
                                case 3:
                                    echo "<tr class='rankbg3'>";
                                    break;
                                case 4:
                                    echo "<tr class='rankbg4'>";
                                    break;
                                case 5:
                                    echo "<tr class='rankbg5'>";
                                    break;
                            }


                            echo "<td>" . $rank . "</td>";
                            echo "<td >";
                            echo "<div>
                                <div >
                                <img src='$user_logo' alt='rank-$rank' class='table-image'>
                            </div>
                        <p>$user_name</p>
                        <p>UID : $user_id</p>

                            </div>";
                            echo "</td>";
                            $point_f =  number_format($count_gift);
                            if ($count_gift >= 100) {
                                echo "<td >";
                                echo "<div >
                           
                    <p>ได้รับรางวัล</p>
                    <p>คะแนน: $point_f</p>

                        </div>";
                                echo "</td>";
                            } else {
                                echo "<td >" . "" . "</td>";
                            }


                            echo "</tr>";
                        }


                        ?>
                    </table>
                </div>


                <h class="a1">ระยะเวลากิจกรรม</h>
                <br />
                วันที่ <?= $start ?> – <?= $end ?>
                <br /><br />

                <h class="a1">รายละเอียดกิจกรรม VJ
                </h><br />
                ➤ ในช่วงเวลากิจกรรมวีเจที่เวลาไลฟ์มากที่สุดจะได้รับรางวัล<br />
                ➤ วีเจจะต้องออนไลน์ในช่วงเวลากิจกรรม 06.00 - 13.00 น.<br />
                อย่างน้อยวันละ 1 ชม. ขั้นต่ำรวม 5 วัน<br />
                ➤ ต้องมีของขวัญ Good Morning <font color="#FFFF00">2,000</font> ชิ้น<br />
                ➤ วีเจทำผิดกฏถูกปิดห้องไลฟ์ครบ 3 ครั้งจะไม่ได้รับรางวัล<br />
                ➤ ไลฟ์ล็อคห้องจะไม่นับเวลาไลฟ์กิจกรรม<br />
                <br />

                <img src="<?php echo base_url("/images/01.png"); ?>" />
                <br />
                Good Morning 20 คูปอง<br />
                ได้รับ 2 คูปอง ต่อชิ้น<br />
                <br />

                <h class="a1">รางวัลกิจกรรม VJ
                </h><br />
                อันดับ 1-5 - รับรางวัล 20,000 คูปอง<br />
                <br />

                <h class="a2">รวมรางวัล 100,000 คูปอง
                </h><br />
                <br />

            </div><!-- /content -->

            <div class="note">
                <font size="+2">หมายเหตุ</font><br />
                ➤ สอบถามข้อมูลและแจ้งปัญหาติดต่อ <br />
                LINE: @takemeclub / Fb: @TakeMeFanClub<br />
                ➤ ทีมงานจะตรวจสอบรางวัลให้ภายใน 5-7 วันทำการหลังจบกิจกรรม<br />
                ➤ กิจกรรมใดที่จัดอยู่ในช่วงเวลาปิดเซิร์ฟเวอร์<br />
                หรือเหตุใดๆที่ทำให้ไม่สามารถออนไลน์ได้จะยึดเวลาจบกิจกรรมตามเดิม<br />
                ➤ อันดับและเวลาอ้างอิงตาม Server เป็นหลัก<br />
                ➤ ขอสงวนสิทธิ์การเปลี่ยนแปลงรายละเอียด<br />
                โดยไม่ต้องแจ้งให้ทราบล่วงหน้า<br />
                ➤ คำตัดสินของทีมงานถือว่าเป็นที่สิ้นสุด<br />
                <br />
                <b>Sponsor by WinNine Pacific : <a href="https://winnine.com.au/main.php" target="_blank">winnine.com.au</a></b><br />

            </div><!-- /note -->

            <div class="foot">WinNine Pacific Pty Ltd Level 20, Zenith Center, 821 Pacific Hwy, Chatswood NSW 2067
                Australia</div>

        </div><!-- /section1 -->

    </div><!-- /wrapper -->

</body>

</html>