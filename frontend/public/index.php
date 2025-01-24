<?php
    // Configuración o datos dinámicos, si los necesitas
    $title = "Shop Page - Ecommerce Tailwind";
    $companyName = "Marketly";
    $year = date("Y");
    $cars = "Agregar a carrito";
    $products = [
        ["name" => "Guyer Chair", "image" => "../assets/images/products/product1.jpg", "price" => 45.00, "old_price" => 55.90],
        ["name" => "Guyer Chair", "image" => "../assets/images/products/product2.jpg", "price" => 45.00, "old_price" => 55.90],
        ["name" => "Guyer Chair", "image" => "../assets/images/products/product3.jpg", "price" => 45.00, "old_price" => 55.90],
        ["name" => "Guyer Chair", "image" => "../assets/images/products/product4.jpg", "price" => 45.00, "old_price" => 55.90],
        ["name" => "Guyer Chair", "image" => "../assets/images/products/product5.jpg", "price" => 45.00, "old_price" => 55.90],
        ["name" => "Guyer Chair", "image" => "../assets/images/products/product6.jpg", "price" => 45.00, "old_price" => 55.90],
    ];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <link rel="shortcut icon" href="../assets/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
</head>

<body>
    <!-- Header -->
    <header class="py-4 shadow-sm bg-white">
        <div class="container flex items-center justify-center">
            <a href="index.php">
                <h2 class="text-2xl font-bold text-gray-800"><?= $companyName ?></h2>
            </a>
        </div>
    </header>
    <!-- ./Header -->

    <!-- Navbar -->
    <nav class="bg-gray-800">
        <div class="container flex">
            <div class="flex items-center justify-between flex-grow md:pl-12 py-5">
                <div class="flex items-center space-x-6 capitalize">
                    <a href="../index.php" class="text-gray-200 hover:text-white transition">Catálogo</a>
                    <a href="pages/cart.php" class="text-gray-200 hover:text-white transition">Carrito</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- ./Navbar -->

    <!-- Shop Wrapper -->
    <div class="container grid md:grid-cols-4 grid-cols-2 gap-6 pt-4 pb-16 items-start">
        
        <!-- ./Sidebar -->

        <!-- Products -->
        <div class="col-span-3">
            <div class="grid md:grid-cols-3 grid-cols-2 gap-6">
                <?php foreach ($products as $product): ?>
                    <div class="bg-white shadow rounded overflow-hidden group">
                        <div class="relative">
                            <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="w-full">
                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                                <a href="#" class="text-white text-lg w-9 h-8 rounded-full bg-primary flex items-center justify-center hover:bg-gray-800 transition" title="view product">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </a>
                                <a href="#" class="text-white text-lg w-9 h-8 rounded-full bg-primary flex items-center justify-center hover:bg-gray-800 transition" title="add to wishlist">
                                    <i class="fa-solid fa-heart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="pt-4 pb-3 px-4">
                            <a href="#">
                                <h4 class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-primary transition"><?= $product['name'] ?></h4>
                            </a>
                            <div class="flex items-baseline mb-1 space-x-2">
                                <p class="text-xl text-primary font-semibold">$<?= number_format($product['price'], 2) ?></p>
                                
                            </div>
                        </div>
                        <a href="#" class="block w-full py-1 text-center text-white bg-primary border border-primary rounded-b hover:bg-transparent hover:text-primary transition"><?= $cars?></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- ./Products -->
    </div>
    <!-- ./Shop Wrapper -->

    <!-- Footer -->
    <div class="bg-gray-800 py-4">
        <div class="container flex items-center justify-between">
            <p class="text-white">&copy; <?= $companyName ?> - All Right Reserved <?= $year ?></p>
            <div>
                <img src="../assets/images/methods.png" alt="methods" class="h-5">
            </div>
        </div>
    </div>
    <!-- ./Footer -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</body>

</html>
