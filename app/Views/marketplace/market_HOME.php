<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

</head>

<body class="bg-black text-white">
    <div class="w-3/4 mx-auto">
        <nav class="flex justify-between mt-3 mx-4">
            <div class="logo">MARKETPLACE</div>
            <input type="text" placeholder="search here..." class="border rounded-full py-1 px-2 border-black outline-1">
            <?php
            if (isset($token)) {
                echo "<div class='flex gap-3'>";
                echo '<a href="auction" class="bg-orange-600 text-white py-1 px-2 rounded-lg hover:bg-red-700 font-medium">auction</a>';
                echo '<a href="profile" class="bg-orange-600 text-white py-1 px-2 rounded-lg hover:bg-red-700 font-medium">profile</a>';
                echo '<a href="logout" class="bg-orange-600 text-white py-1 px-2 rounded-lg hover:bg-red-700 font-medium">logout</a>';
                echo "</div>";
            } else {
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
                        <div class=" border border-red-500 h-52 w-52 rounded-xl ">
                            <div class="h-2/4">
                                <img src='<?= $item["img_url"] ?>' alt="<?= $item["item_name"] ?>" class="object-fill h-full w-full rounded-t-xl">
                            </div>
                            <div class=" w-full h-2/4 px-1 flex flex-col justify-center border-t border-t-black">
                                <div class="flex items-center justify-between">
                                    <p><?= $item["item_name"] ?></p>
                                    <p>ราคา : <?= $item["item_price"] ?> บาท</p>
                                </div>
                                <p>ขายแล้ว <?= $item["total_quantity_sold"] ?> ชิ้น</p>
                                <a href='detail?item_id=<?= $item["item_id"] ?>' class="bg-orange-600 rounded-full mt-2 cursor-pointer text-center">ดูรายละเอียด</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
            <h3>Latest Auction</h3>
            <div>

            </div>
        </header>

        <main class="w-4/5  mt-7 h-screen mx-auto ">
            <!-- <div class="leftMenu w-1/5 float-left h-full">
                <h2 class=" text-center">หมวดหมู่สินค้า</h2>
                <div class="bg-blue-500  h-full">

                </div>
            </div> -->
            <div class="flex justify-between">
                <h2 class=" text-center font-semibold text-2xl mb-5">รายการสินค้า</h2>
                <select name="category" id="category" class="mb-5 text-black" onchange="handleChange()">
                    <option value="" selected>ALL</option>
                    <?php

                    for ($i = 0; $i < count($categories); $i++) {
                        # code...
                        echo   "<optgroup label='{$categories[$i]['category_name']}'>";
                        for ($j = 0; $j < count($categories[$i]["subcategories"]); $j++) {
                            echo "<option value='{$categories[$i]['subcategories'][$j]['subcategory_id']}'>" . $categories[$i]['subcategories'][$j]['subcategory_name'] . "</option>";
                        }
                        echo "</optgroup>";
                    }
                    ?>

                </select>
            </div>

            <div class="h-full">
                <div class=" h-full w-full grid grid-cols-3 gap-4">
                    <?php foreach ($sell_list["data"] as $item) : ?>
                        <div class=" border border-red-500 h-80 w-full rounded-xl">
                            <div class="h-3/4">
                                <img src='<?= $item["img_url"] ?>' alt="<?= $item["item_name"] ?>" class="object-fill h-full w-96 rounded-t-xl">
                            </div>
                            <div class=" w-full h-1/4 px-1 flex flex-col justify-center border-t border-t-black">
                                <div class="flex items-center justify-between">
                                    <p><?= $item["item_name"] ?></p>
                                    <p>ราคา : <?= $item["item_price"] ?> บาท</p>
                                </div>
                                <a href='detail?item_id=<?= $item["item_id"] ?>' class="bg-orange-600 rounded-full mt-2 cursor-pointer text-center">ดูรายละเอียด</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>
    <script>
        function handleChange() {
            let subCategory_id = document.getElementById("category").value
            console.log(subCategory_id);
            // $.ajax({
            //     type: "GET",
            //     url: "index",
            //     data: {
            //         subCategoryId: subCategory_id
            //     },
            //     success: function(response) {
            //         console.log(response);
            //     },
            //     error: function(response) {
            //         console.error(response);
            //         alert("Fail");
            //     },
            // });
        }
    </script>

</body>

</html>