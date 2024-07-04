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

$data_detail = $data["group"];

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
function DateEng($strDate)
{
    $strYear = date("Y", strtotime($strDate));
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $time = date("A", strtotime($strDate));
    $dateObj   = DateTime::createFromFormat('!m', $strMonth);

    $monthName = $dateObj->format('F');

    return "$strDay $monthName  $strYear  ( $strHour:$strMinute $time)";
}

$start_event =  DateEng($data_detail["start_date"]);
$end_event =  DateEng($data_detail["end_date"]);
$event_name = $data_detail["en-lang"];

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CallPlay</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="<?php echo base_url("/event_love_heart/css/style.css"); ?>">
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

            <div class="pic-top"><img src="<?php echo base_url("/event_love_heart/images/pic-top-eng.jpg"); ?>" />
            </div>

            <div class="content">

                <h class="a2">
                    SPECIAL FOR FIRST TOPUP GET LOVE HEART GRADE<br />
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

                        $rank = 0;
                        for ($i = 0; $i < count($data_arr); $i++) {
                            # code...
                            $user_id = $data_arr[$i]["user_id"];
                            $user_name = $data_arr[$i]["user_name"];
                            $user_logo = $data_arr[$i]["user_logo"];
                            $count_gift = $data_arr[$i]["count_gift"];

                            $rank++;

                            if ($rank % 2 == 0) {
                                echo "<tr class='tr1'>";
                            } else {
                                echo "<tr class='tr2'>";
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

                            if ($count_gift >= 100) {
                                echo "<td >";
                                echo "<div >
                               
                        <p>Rewarded</p>
                        <p>Points: $count_gift</p>
    
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

                <h class="a1">Event Duration
                </h>
                <br />
                <br />
                <?= $start_event ?> – <?= $end_event ?> GMT+7
                <br />
                <br />
                <h2><?= $event_name  ?></h2>
                <h class="a2">PROMOTION REWARD
                </h>
                <br />

                <br />
                <img src="<?php echo base_url("/event_love_heart/images/01.png"); ?>" />
                <br />
                <img src="<?php echo base_url("/event_love_heart/images/02.png"); ?>" />
                <br />
                Top Up with more than 5,000 Coupons,<br />
                Get SPECIAL RANK “Love Heart” for 15 Days FOR FREE!<br />
                <br />

                <h class="a1">EVENT CONDITONS
                </h>
                <br />
                - ID require to not top up before<br />
                participate in this promotion.<br />
                - Top up first time for at least 5,000 coupons<br />
                during promotion period.<br />
                (Accumulate amount will not count.)<br />
                - Limit for 1 ID 1 chance.<br />
                - Grade can be received after the event ends until <br />
                July 15th, 2024 (11.59 PM)GMT+7<br />
                <br />


            </div><!-- /content -->

            <div class="note">
                <font size="+2">Remarks</font><br />
                - Required to top up more than 5,000 coupons.<br />
                - We reserved the right for not allow user who topped up<br />
                via Gold man and exchange the THC to be coupon<br />
                for participate in this promotion.<br />
                Otherwise, the reward will be disqualified.<br />
                - The time is mainly based on the server time.<br />
                - The staff's decision is final decision.<br />
                - The app reserves the right to change<br />
                terms and conditions without prior notice.<br />
                - In case of server maintenance or another reason<br />
                causing players cannot be online during event<br />
                holding, event still ends as it was.<br />
                <br />

            </div><!-- /note -->

            <div class="foot">WinNine Pacific Pty Ltd Level 20, Zenith Center, 821 Pacific Hwy, Chatswood NSW 2067
                Australia</div>

        </div><!-- /section1 -->

    </div><!-- /wrapper -->

</body>

</html>