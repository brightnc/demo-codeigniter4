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



<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CallPlay</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="<?php echo base_url("/ci/public/event_love_heart/css/style.css"); ?>">
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

            <div class="pic-top"><img src="<?php echo base_url("/ci/public/event_love_heart/images/pic-top.jpg"); ?>" />
            </div>

            <div class="content">

                <h class="a2">
                    เติมคูปองครั้งแรกรับยศ LOVE HEART<br />

                </h>
                <br />
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
                            <th>เวลาที่อัพเดทล่าสุด</th>

                        </tr>

                        <?php

                        $rank = 0;
                        for ($i = 0; $i < 30; $i++) {
                            # code...
                            $user_id = $data_arr[$i]["user_id"];
                            $user_name = $data_arr[$i]["user_name"];
                            $user_logo = $data_arr[$i]["user_logo"];
                            $updateTime = $data_arr[$i]["updatetime"];
                            $date_thai = DateThai($updateTime);

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

                            echo "<td  class=' text-black'>" . $date_thai . "</td>";

                            echo "</tr>";
                        }


                        ?>
                    </table>
                </div>

                <h class="a1">ระยะเวลากิจกรรม
                </h>
                <br />
                3 ก.ค. 67 เวลา 10.00 น. – 12 ก.ค. 67 เวลา 23.59 น.<br />
                <br />

                <h class="a2">รางวัลโปรโมชั่น
                </h>
                <br />

                <br />
                <img src="<?php echo base_url("/ci/public/event_love_heart/images/01.png"); ?>" />
                <br />
                <img src="<?php echo base_url("/ci/public/event_love_heart/images/02.png"); ?>" />
                <br />
                ยศพิเศษ Love Heart 15 วัน<br />
                เมื่อเติมคูปองขั้นต่ำ 5,000 คูปองขึ้นไป<br />
                <br />

                <h class="a1">เงื่อนไขกิจกรรม
                </h>
                <br />
                - ต้องเป็นไอดีที่ไม่เคยเติมเงินมาก่อน<br />
                - เติมเงินครั้งแรกในช่วงกิจกรรม 5,000 คูปอง ขึ้นไป (ไม่นับสะสม)<br />
                - จำกัด 1 ไอดีมีสิทธิ์ 1 ครั้ง<br />
                - ยศพิเศษกดรับได้หลังกิจกรรมจบ จนถึงวันที่ 15 ก.ค. 67 (23.59น.)<br />
                <br />

            </div><!-- /content -->

            <div class="note">
                <font size="+2">หมายเหตุ</font><br />
                - ต้องเติมเงินขั้นต่ำ 5,000 คูปอง ขึ้นไป<br />
                - ทีมงานขอสงวนสิทธิ์การเติมเงินผ่านช่องทาง Goldman<br />
                และแลกเปลี่ยน THC เป็นคูปองจะไม่สามารถเข้าร่วมโปรโมชั่นนี้ได้<br />
                หากไม่กดรับภายในเวลาดังกล่าวจะถือว่าสละสิทธิ์โดยทันที<br />
                - เวลาอ้างอิงตามเวลาของ Server เป็นหลัก<br />
                - การตัดสินของทีมงานถือเป็นที่สิ้นสุด<br />
                - ขอสงวนสิทธิ์ในการเปลี่ยนแปลงหากเกิดปัญหา<br />
                โดยไม่ต้องแจ้งให้ทราบล่วงหน้า<br />
                - กิจกรรมใดที่จัดอยู่ในช่วงเวลาปิดเซิร์ฟเวอร์หรือเหตุใดๆที่<br />
                ทำให้ไม่สามารถออนไลน์ได้จะยึดเวลาจบกิจกรรมตามเดิม<br />
                <br />

            </div><!-- /note -->

            <div class="foot">WinNine Pacific Pty Ltd Level 20, Zenith Center, 821 Pacific Hwy, Chatswood NSW 2067
                Australia</div>

        </div><!-- /section1 -->

    </div><!-- /wrapper -->

</body>

</html>