<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function handleClick(item_id) {
            event.preventDefault()

        }
    </script>

</head>

<body class="bg-black text-white">
    <div class="w-3/4 mx-auto">
        <nav class="flex justify-between mt-3 mx-4">
            <div class="logo">MARKETPLACE</div>
            <input type="text" placeholder="search here..." class="border rounded-full py-1 px-2 border-black outline-1">
            <button class="bg-orange-600 text-white py-1 px-2 rounded-lg hover:bg-red-700 font-medium">login</button>
        </nav>

        <header>
            <h2>Trending</h2>
            <h3>Best Selling</h3>
            <div>

            </div>
            <h3>Latest Auction</h3>
            <div></div>
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
                    <?php foreach ($sell_list as $item) : ?>
                        <div class=" border border-red-500 h-80 w-full rounded-xl">
                            <div class="h-3/4">
                                <img src='<?= $item->img_url ?>' alt="<?= $item->item_name ?>" class="object-fill h-full w-96 rounded-t-xl">
                            </div>
                            <div class=" w-full h-1/4 px-1 flex flex-col justify-center border-t border-t-black">
                                <div class="flex items-center justify-between">
                                    <p><?= $item->item_name ?></p>
                                    <p>ราคา : <?= $item->item_price ?> บาท</p>
                                </div>
                                <a href='Marketplace/detail?item_id=<?= $item->item_id ?>' class="bg-orange-600 rounded-full mt-2 cursor-pointer text-center">ดูรายละเอียด</a>
                            </div>


                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>


</body>

</html>