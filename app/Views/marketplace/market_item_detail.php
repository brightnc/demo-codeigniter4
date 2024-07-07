<?php
if(!isset($token)){
    $token = "";
}
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
        <div class="w-4/5 mx-auto border border-orange-700 mt-11 rounded-xl py-3 px-4">
            <?php foreach ($item_detail["data"] as $v) : ?>
            <div class="flex justify-center w-full">
                <img src="<?= $v["img_url"] ?>" alt="<?= $v["item_name"] ?>" class="w-52 h-52">
            </div>
            <p>Product name : <?= $v["item_name"] ?></p>
            <p>Seller name : <?= $v["seller_name"] ?></p>
            <p>Description : <?= $v["item_description"] ?></p>
            <p>Instock : <?= $v["item_quantity"] ?></p>
            <?php if ($v["promotion_id"] == 0) : ?>
            <p>Price : <?= $v["item_price"] ?> ฿</p>
            <?php else : ?>
            <p><?= $v["type_name"] ?></p>
            <p>ส่วนลด : <?= $v["discount_price"] ?> ฿</p>
            <?php $new_price = $v["item_price"] - $v["discount_price"]; ?>
            <p>Price : <span class='line-through decoration-2'> <?= $v["item_price"] ?></span> <?= $new_price ?> ฿</p>
            <?php endif; ?>
            <label for="qty">จำนวน</label>
            <input type="number" class="text-black w-8 text-center" id="qty" name="qty" min=1
                max=<?= $v["item_quantity"] ?> value=1>
            <?php if ($token) : ?>
            <button type="button" onclick="handleClick('<?= $v['item_id'] ?>', '<?= $v['promotion_id'] ?>')"
                class="bg-orange-600 rounded-full py-1 px-4 mt-2 cursor-pointer text-center">ซื้อ</button>
            <?php else : ?>
            <a class="bg-orange-600 rounded-full py-1 px-4 mt-2 cursor-pointer text-center " href="login">ซื้อ</a>
            <?php endif; ?>

            <?php endforeach; ?>
        </div>

    </div>
    <script>
    function handleClick(item_id, promotion_id) {
        const qty = document.getElementById("qty").value
        console.log("qty : " + qty);
        console.log("item_id : " + item_id);
        console.log("promotion_id : " + promotion_id);
        $.ajax({
            type: "POST",
            url: "http://localhost:3000/api/orders",
            headers: {
                'Authorization': 'Bearer ' + '<?=$token?>'
            },
            contentType: 'application/json',
            data: JSON.stringify({
                item_id: item_id,
                promotion_id: promotion_id,
                qty: qty
            }),
            success: function(response) {
                console.log(response);

                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Login Success",
                    showConfirmButton: false,
                    timer: 1500,
                });

            },
            error: function(response) {
                console.error(response);
                if (response.responseJSON.message == "Token expired") {
                    window.location.href = "logout"
                    return;
                }
                alert("Fail log in: " + response);
            },
        });
    }
    </script>

</body>

</html>