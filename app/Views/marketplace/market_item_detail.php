<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>detail</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black text-white">
    <div class="w-3/4 mx-auto">
        <div class="w-4/5 mx-auto border border-orange-700 mt-11 rounded-xl py-3 px-4">
            <?php foreach ($item_detail as $v) : ?>
                <div class="flex justify-center w-full">
                    <img src="<?= $v->img_url ?>" alt="<?= $v->item_name ?>" class="w-52 h-52">
                </div>
                <p>Product name : <?= $v->item_name ?></p>
                <p>Seller name : <?= $v->seller_name ?></p>
                <p>Description : <?= $v->item_description ?></p>
                <p>Instock : <?= $v->item_quantity ?></p>
                <?php if ($v->promotion_id == 0) : ?>
                    <p>Price : <?= $v->item_price ?> ฿</p>
                <?php else : ?>
                    <p><?= $v->type_name ?></p>
                    <p>ส่วนลด : <?= $v->discount_price ?> ฿</p>
                    <?php $new_price = $v->item_price - $v->discount_price; ?>
                    <p>Price : <span class='line-through decoration-2'> <?= $v->item_price ?></span> <?= $new_price ?> ฿</p>
                <?php endif; ?>




            <?php endforeach; ?>
        </div>

    </div>

</body>

</html>