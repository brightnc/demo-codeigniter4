<?php
if (!isset($user_encrypted_id)) {
    $user_encrypted_id = "";
}

$checksum = md5($user_id . "secret");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
</head>

<body class="bg-black text-white">
    <div class="w-3/4 mx-auto">
        <div class="w-full border border-orange-700 mt-11 rounded-xl py-3 px-4">
            <div class="flex justify-center w-full">
                <img src="<?= $auction_detail[0]->img_url ?>" alt="<?= $auction_detail[0]->item_name ?>" class="w-52 h-52">
            </div>
            <div class="mx-auto w-2/4">
                <div class="flex justify-between">
                    <p>ชื่อสินค้า : <?= $auction_detail[0]->item_name  ?></p>
                    <p>ผู้ขาย : <?= $auction_detail[0]->username ?></p>
                </div>
                <div class="flex justify-between">
                    <p>ราคาประมูลเริ่มต้น: <?= $auction_detail[0]->start_price ?> บาท</p>
                    <p>เพิ่มขึ้นขั้นต่ำ : <?= $auction_detail[0]->bid_minimum ?> บาท</p>
                </div>



                <?php if ($user_encrypted_id) : ?>
                    <label for="auction">ราคา</label>
                    <input type="text" id="auction_bid" name="auction_bid" class="text-black">
                    <button type="button" onclick="handleClick('<?= $auction_id ?>')" class="bg-orange-600 rounded-full py-1 px-4 mt-2 cursor-pointer text-center">ประมูล</button>
                <?php else : ?>
                    <a class="bg-orange-600 rounded-full py-1 px-4 mt-2 cursor-pointer text-center " href="login">ประมูล</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="w-80 mx-auto border border-orange-700 mt-11 rounded-xl py-3 px-4 divide-y divide-orange-700">
            <?php foreach ($auction_history as $v) : ?>
                <div class="flex gap-20">
                    <p>ชื่อ <?= $v->username ?></p>
                    <p>ราคา <?= $v->bid_price ?> บาท</p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        function handleClick(auction_id) {
            Swal.fire({
                title: "ต้องการดำเนินการประมูล?",
                text: "กรุณากดยืนยันเพื่อทำการประมูล!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
            }).then((result) => {
                if (result.isConfirmed) {
                    const auction_bid = document.getElementById("auction_bid").value
                    console.log("auction_bid : " + auction_bid);

                    $.ajax({
                        type: "POST",
                        url: "auction_process",
                        data: {
                            auction_id: auction_id,
                            user_id: '<?= $user_id ?>',
                            bid_price: auction_bid,
                            checksum: '<?= $checksum ?>',
                        },
                        success: function(response) {
                            console.log(response);

                            Swal.fire({
                                title: "ประมูล!",
                                text: "ประมูลสินค้าเรียบร้อย",
                                icon: "success"
                            }).then(() => {
                                window.location.href = "profile";
                            });


                        },
                        error: function(response) {
                            console.error(response);
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                            });
                        },
                    });

                }
            });


        }
    </script>

</body>

</html>