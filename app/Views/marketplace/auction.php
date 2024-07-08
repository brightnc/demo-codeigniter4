<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>

<body class="bg-black text-white">
    <div class="w-3/4 mx-auto mt-10">
        <h1>Auction List</h1>
        <div class="grid grid-cols-4 ">
            <?php foreach ($auction_list  as $v) : ?>
                <div class=" border border-red-500 h-80 w-60 rounded-xl ">
                    <div class="h-2/4">
                        <img src='<?= $v->img_url ?>' alt="<?= $v->item_name ?>" class="object-fill h-full w-full rounded-t-xl">
                    </div>
                    <div class=" w-full h-2/4 px-1 flex flex-col justify-center gap-6 border-t border-t-black">
                        <div class="flex flex-col items-center justify-between">
                            <p>ชื่อสินค้า : <?= $v->item_name ?></p>
                            <p>เริ่มต้น : <?= $v->bid_minimum ?> บาท</p>
                        </div>
                        <a href='auction_detail?auction_id=<?= $v->auction_id ?>' class="bg-orange-600 rounded-full mt-2 cursor-pointer text-center">ดูรายละเอียด</a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>



</body>

</html>