<?php
// Variables que pueden ser dinámicas en tu proyecto
$title = "Product - Ecommerce Tailwind";
$site_name = "Marketly";
$product = [
    "name" => "Italian L Shape Sofa",
    "availability" => "In Stock",
    "brand" => "Apex",
    "category" => "Sofa",
    "sku" => "BE45VGRT",
    "price" => 45.00,
    "description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos eius eum reprehenderit dolore vel mollitia optio consequatur hic asperiores inventore suscipit, velit consequuntur, voluptate doloremque iure necessitatibus adipisci magnam porro.",
    "reviews" => [
        [
            "name" => "John Smith",
            "date" => "2 days ago",
            "rating" => 5,
            "comment" => "Perfect for my living room! The quality is exceptional and the color matches perfectly with my decor. Delivery was prompt and assembly was straightforward. Highly recommend this sofa to anyone looking for both style and comfort."
        ],
        [
            "name" => "Sarah Johnson",
            "date" => "1 week ago",
            "rating" => 4,
            "comment" => "Great sofa overall, but slightly firmer than I expected. The L-shape design is perfect for my space and the fabric seems very durable."
        ]
        // Agregar más reseñas si es necesario
    ]
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>

    <link rel="shortcut icon" href="../assets/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
</head>

<body>
    <!-- header -->
    <header class="py-4 shadow-sm bg-white">
        <div class="container flex items-center justify-center">
            <a href="index.php">
                <h2 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($site_name) ?></h2>
            </a>
        </div>
    </header>
    <!-- ./header -->

    <!-- navbar -->
    <nav class="bg-gray-800">
        <div class="container flex">
            <div class="flex items-center justify-between flex-grow md:pl-12 py-5">
                <div class="flex items-center space-x-6 capitalize">
                    <a href="../index.php" class="text-gray-200 hover:text-white transition">Catálogo</a>
                    <a href="cart.php" class="text-gray-200 hover:text-white transition">Carrito</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- ./navbar -->

    <!-- product-detail -->
    <div class="container grid grid-cols-2 gap-6">
        <div>
            <img src="../assets/images/products/product1.jpg" alt="product" class="w-full">
        </div>

        <div>
            <h2 class="text-3xl font-medium uppercase mb-2"><?= htmlspecialchars($product['name']) ?></h2>
            <div class="flex items-center mb-4">
                <div class="flex gap-1 text-sm text-yellow-400">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <span><i class="fa-solid fa-star"></i></span>
                    <?php endfor; ?>
                </div>
                <div class="text-xs text-gray-500 ml-3">(150 Reviews)</div>
            </div>
            <div class="space-y-2">
                <p class="text-gray-800 font-semibold space-x-2">
                    <span>Availability: </span>
                    <span class="text-green-600"><?= htmlspecialchars($product['availability']) ?></span>
                </p>
                <p class="space-x-2">
                    <span class="text-gray-800 font-semibold">Brand: </span>
                    <span class="text-gray-600"><?= htmlspecialchars($product['brand']) ?></span>
                </p>
                <p class="space-x-2">
                    <span class="text-gray-800 font-semibold">Category: </span>
                    <span class="text-gray-600"><?= htmlspecialchars($product['category']) ?></span>
                </p>
                <p class="space-x-2">
                    <span class="text-gray-800 font-semibold">SKU: </span>
                    <span class="text-gray-600"><?= htmlspecialchars($product['sku']) ?></span>
                </p>
            </div>
            <div class="flex items-baseline mb-1 space-x-2 font-roboto mt-4">
                <p class="text-xl text-primary font-semibold">$<?= number_format($product['price'], 2) ?></p>
            </div>

            <p class="mt-4 text-gray-600"><?= htmlspecialchars($product['description']) ?></p>
        </div>
    </div>
    <!-- ./product-detail -->

    <!-- reviews -->
    <div class="container pb-16">
        <h3 class="border-b border-gray-200 font-roboto text-gray-800 pb-3 font-medium">
            Customer Reviews (<?= count($product['reviews']) ?>)
        </h3>
        
        <div class="mt-8 space-y-8">
            <?php foreach ($product['reviews'] as $review): ?>
                <div class="flex items-start border-b border-gray-200 pb-8">
                    <div class="flex-shrink-0">
                        <img src="/api/placeholder/40/40" class="rounded-full" alt="user avatar">
                    </div>
                    <div class="ml-4 flex-grow">
                        <div class="flex items-center mb-2">
                            <h5 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($review['name']) ?></h5>
                            <span class="ml-4 text-sm text-gray-500"><?= htmlspecialchars($review['date']) ?></span>
                        </div>
                        <div class="flex gap-1 text-sm text-yellow-400 mb-2">
                            <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                <span><i class="fa-solid fa-star"></i></span>
                            <?php endfor; ?>
                            <?php for ($i = $review['rating']; $i < 5; $i++): ?>
                                <span><i class="fa-regular fa-star"></i></span>
                            <?php endfor; ?>
                        </div>
                        <p class="text-gray-600"><?= htmlspecialchars($review['comment']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- ./reviews -->

    <!-- copyright -->
    <div class="bg-gray-800 py-4">
        <div class="container flex items-center justify-between">
            <p class="text-white">&copy; <?= htmlspecialchars($site_name) ?> - All Right Reserved</p>
            <div>
                <img src="../assets/images/methods.png" alt="methods" class="h-5">
            </div>
        </div>
    </div>
    <!-- ./copyright -->
</body>

</html>
