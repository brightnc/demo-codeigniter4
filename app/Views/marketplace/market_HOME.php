<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black text-white">
    <div class="w-3/4 mx-auto">
        <nav class="flex justify-between mt-3 mx-4">
            <div class="logo">MARKETPLACE</div>
            <input type="text" placeholder="search here..."
                class="border rounded-full py-1 px-2 border-black outline-1">
            <?php
            if (isset($token)) {
                echo "<div class='flex gap-3'>";
                echo '<a href="profile" class="bg-orange-600 text-white py-1 px-2 rounded-lg hover:bg-red-700 font-medium">profile</a>';
                echo '<a href="logout" class="bg-orange-600 text-white py-1 px-2 rounded-lg hover:bg-red-700 font-medium">logout</a>';
                echo "</div>";
            }else{
                echo '<a href="login" class="bg-orange-600 text-white py-1 px-2 rounded-lg hover:bg-red-700 font-medium">login</a>';
            }
            ?>

        </nav>

        <header>
            <h2>Trending</h2>
            <h3>Best Selling</h3>
            <div>
                <div class="flex gap-9">
                    <?php foreach ($best_sell["data"] as $item) : ?>
                    <div class=" border border-red-500 h-52 w-52 rounded-xl">
                        <div class="h-2/4">
                            <img src='<?= $item["img_url"] ?>' alt="<?= $item["item_name"] ?>"
                                class="object-fill h-full w-full rounded-t-xl">
                        </div>
                        <div class=" w-full h-2/4 px-1 flex flex-col justify-center border-t border-t-black">
                            <div class="flex items-center justify-between">
                                <p><?= $item["item_name"] ?></p>
                                <p>ราคา : <?= $item["item_price"] ?> บาท</p>
                            </div>
                            <p>ขายแล้ว <?= $item["total_quantity_sold"] ?> ชิ้น</p>
                            <a href='detail?item_id=<?= $item["item_id"] ?>'
                                class="bg-orange-600 rounded-full mt-2 cursor-pointer text-center">ดูรายละเอียด</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>
            <h3>Latest Auction</h3>
            <div>

            </div>
        </header>

        <main class="w-full mt-7 h-screen">
            <div class="leftMenu w-1/5 float-left h-full">
                <h2 class=" text-center">หมวดหมู่สินค้า</h2>
                <div class="bg-blue-500  h-full">

                </div>
            </div>
            <div class="rightMenu w-4/5  float-right h-full pl-6"">
                <h2 class=" text-center">รายการสินค้า</h2>
                <div class=" h-full w-full grid grid-cols-3 gap-4">
                    <?php foreach ($sell_list["data"] as $item) : ?>
                    <div class=" border border-red-500 h-80 w-full rounded-xl">
                        <div class="h-3/4">
                            <img src='<?= $item["img_url"] ?>' alt="<?= $item["item_name"] ?>"
                                class="object-fill h-full w-96 rounded-t-xl">
                        </div>
                        <div class=" w-full h-1/4 px-1 flex flex-col justify-center border-t border-t-black">
                            <div class="flex items-center justify-between">
                                <p><?= $item["item_name"] ?></p>
                                <p>ราคา : <?= $item["item_price"] ?> บาท</p>
                            </div>
                            <a href='detail?item_id=<?= $item["item_id"] ?>'
                                class="bg-orange-600 rounded-full mt-2 cursor-pointer text-center">ดูรายละเอียด</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>


</body>

</html>