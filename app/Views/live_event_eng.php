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

$start =  DateEng($top_1["startdate"]);
$end =  DateEng($top_1["enddate"]);

function DateEng($strDate)
{
    $strYear = date("Y", strtotime($strDate)) ;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $time = date("A", strtotime($strDate));
    $dateObj   = DateTime::createFromFormat('!m', $strMonth);

    $monthName = $dateObj->format('F');

    return "$strDay $monthName  $strYear  ( $strHour:$strMinute $time)";
}

?>



<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>TakeMe</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="<?php echo base_url("/ci/public/eng/css/style1.css"); ?>">
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

            <div class="pic-top"><img src="<?php echo base_url("/ci/public/eng/images/pic-top.jpg"); ?>" /></div>

            <div class="content">

                <h class="a2">
                    EARLY BEAUTY
                </h><br /><br />
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
                    <button onclick="handleClick()" class="bt-rank">See more ranking lists</button>

                </div>

                <div class="box-table visible" id="table_data">
                    <table>
                        <tr>
                            <th>No.</th>
                            <th>User Detail</th>
                            <th>Reward</th>

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
                           
                    <p>rewarded</p>
                    <p>points : $point_f</p>

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

                <h class="a1">EVENT DURATION</h>
                <br />
                <?= $start ?> - <?= $end ?> GMT+7
                <br /><br />

                <h class="a1">EVENT DETAILS FOR VJ
                </h><br />
                ➤ VJ who cumulate most of live period will be rewarded.<br />
                ➤ VJs must be online during activity hours 06:00 am - 01:00 pm GMT+7<br />
                At least 1 hour per day Total minimum 5 days. <br />
                ➤ Required to cumulate <font color="#FFFF00">2,000</font> pieces of Good Morning gift.<br />
                ➤ In case of VJ have equal live period,<br />
                VJ who receive more coupons will be on higher rank.<br />
                ➤ If found for violate for 3 times,<br />
                will be disqualified from the reward.<br />
                ➤ Lock session will not count for cumulate time.<br />
                <br />

                <img src="<?php echo base_url("/ci/public/eng/images/01.png"); ?>" />
                <br />
                Good Morning 20 coupons<br />
                will receive 2 Coupons/piece<br />
                <br />

                <h class="a2">EVENT REWARDS FOR VJ
                </h><br />
                1st - 5th Place, receives 20,000 Coupons<br />

                <br />

                <h class="a2">TOTAL REWARDS OF<br />
                    100,000 COUPONS
                </h><br />



            </div><!-- /content -->

            <div class="note">
                <font size="+2">Remark</font><br />
                ➤ Enquiry and problem please contact<br />
                LINE: @takemeclub / Fb: @TakeMeFanClub<br />
                ➤ Checking and prize giving bsy the staff takes place within 5-7 days<br />
                ➤ In case of server maintenance or another reasons because players cannot<br />
                be online during event holding, event still ends as it was.<br />
                ➤ Ranking and time mainly based on server<br />
                ➤ We reserve the right to change<br />
                the event details without prior notice.<br />
                ➤ The staff’s decision is final.<br />
                <br />
                <b>Sponsor by WinNine Pacific : <a href="https://winnine.com.au/main.php"
                        target="_blank">winnine.com.au</a></b><br />


            </div><!-- /note -->

            <div class="foot">WinNine Pacific Pty Ltd Level 20, Zenith Center, 821 Pacific Hwy, Chatswood NSW 2067
                Australia</div>

        </div><!-- /section1 -->

    </div><!-- /wrapper -->

</body>

</html>