<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black text-white">
    <div>
        <div class="flex justify-between mt-3 mx-4">
            <div>
                <h1>Hello <?= $user_info["username"] ?></h1>
                <p>wallet : <?= $user_info["cash"] ?></p>
            </div>
            <div class='flex justify-center items-center gap-3'>
                <a href="index" class="bg-orange-600 text-white py-1 px-2 rounded-lg hover:bg-red-700 font-medium">Home</a>
                <a href="logout" class="bg-orange-600 text-white py-1 px-2 rounded-lg hover:bg-red-700 font-medium">Logout</a>
            </div>
        </div>


        <h2>Orders History</h2>

        <?php
        for ($i = 0; $i < count($user_orders); $i++) {
            echo "<div class='flex gap-3'>";
            echo "<p> Order id : " . $user_orders[$i]["order_id"] . "</p>";
            echo "<p> img : " . $user_orders[$i]["img_url"] . "</p>";
            echo "<p> ชื่อสินค้า : " . $user_orders[$i]["item_name"] . "</p>";
            echo "<p> จำนวน : " . $user_orders[$i]["quantity"] . " ชิ้น</p>";
            echo "<p> ราคา : " . $user_orders[$i]["final_price"] . " ฿</p>";
            echo "<p> สถานะ : " . $user_orders[$i]["status"] . "</p>";
            echo "</div>";
        }
        ?>


    </div>
</body>

</html>