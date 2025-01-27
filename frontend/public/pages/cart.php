<?php

$site_name = "Marketly";

session_start();

// Inicializar carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Manejar acciones del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'increase':
                $_SESSION['cart'][$product_id]['quantity']++;
                break;
            case 'decrease':
                if ($_SESSION['cart'][$product_id]['quantity'] > 1) {
                    $_SESSION['cart'][$product_id]['quantity']--;
                } else {
                    unset($_SESSION['cart'][$product_id]);
                }
                break;
            case 'remove':
                unset($_SESSION['cart'][$product_id]);
                break;
        }
    }
}

// Calcular el total general
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>

    <link rel="shortcut icon" href="../assets/images/marketly.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Header -->
    <header class="py-4 shadow-sm" style="background-color: #111827;">
        <div class="container flex items-center justify-center">
            <a href="../index.php" class="flex items-center gap-4">
                <img src="../assets/images/marketly.png" alt="logo" class="h-12 mr-4">
                <h2 class="text-3xl font-semibold text-white"><?= $site_name ?></h2>
            </a>
        </div>
    </header>

    <!-- Navbar -->
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
    <!-- ./Navbar -->

    <!-- Cart Wrapper -->
    <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16 mt-8">
        <!-- Cart -->
        <div class="col-span-9">
            <div class="space-y-4">
                <?php if (!empty($_SESSION['cart'])): ?>
                    <?php foreach ($_SESSION['cart'] as $product_id => $product): ?>
                        <div class="flex items-center justify-between border gap-6 p-4 border-gray-200 rounded">
                            <div class="w-28">
                                <?php
                                $image = isset($product['image']) && $product['image'] ? htmlspecialchars($product['image']) : '/ruta/a/placeholder.jpg';
                                ?>
                                <img src="<?= $image ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full">
                            </div>


                            <div class="w-1/3">
                                <h2 class="text-gray-800 text-xl font-medium uppercase"><?= htmlspecialchars($product['name']) ?></h2>
                                <p class="text-gray-500 text-sm">Availability: <span class="text-green-600">In Stock</span></p>
                            </div>
                            <div>
                                <form method="POST" action="">
                                    <div class="flex border border-gray-300 text-gray-600 divide-x divide-gray-300 w-max">
                                        <button type="submit" name="action" value="decrease" class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none">-</button>
                                        <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                        <input class="h-8 w-14 text-base text-center" type="text" value="<?= $product['quantity'] ?>" readonly />
                                        <button type="submit" name="action" value="increase" class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none">+</button>
                                    </div>
                                </form>
                            </div>
                            <div class="text-primary text-lg font-semibold">$<?= number_format($product['price'] * $product['quantity'], 2) ?></div>
                            <div class="text-gray-600 cursor-pointer hover:text-primary">
                                <form method="POST" action="">
                                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                    <button type="submit" name="action" value="remove" class="text-gray-600 hover:text-primary">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php $total += $product['price'] * $product['quantity']; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-800 text-center">Tu carrito está vacío.</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- ./Cart -->

        <!-- Order Summary -->
        <div class="col-span-3">
            <div class="border border-gray-200 p-4 rounded">
                <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">Order Summary</h4>
                <div class="space-y-2">
                    <?php foreach ($_SESSION['cart'] as $product): ?>
                        <div class="flex justify-between">
                            <div>
                                <h5 class="text-gray-800 font-medium"><?= htmlspecialchars($product['name']) ?></h5>
                            </div>
                            <p class="text-gray-600">x<?= $product['quantity'] ?></p>
                            <p class="text-gray-800 font-medium">$<?= number_format($product['price'] * $product['quantity'], 2) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="flex justify-between border-b border-gray-200 text-gray-800 font-medium py-3 uppercase">
                    <p>Subtotal</p>
                    <p>$<?= number_format($total, 2) ?></p>
                </div>

                <div class="flex justify-between border-b border-gray-200 text-gray-800 font-medium py-3 uppercase">
                    <p>Shipping</p>
                    <p>Free</p>
                </div>

                <div class="flex justify-between text-gray-800 font-medium py-3 uppercase">
                    <p class="font-semibold">Total</p>
                    <p>$<?= number_format($total, 2) ?></p>
                </div>

                <a href="checkout.php" class="block w-full py-3 px-4 text-center text-white bg-primary border border-primary rounded-md hover:bg-transparent hover:text-primary transition font-medium">
                    Proceder a Pagar
                </a>
            </div>
        </div>
        <!-- ./Order Summary -->
    </div>
    <!-- ./Cart Wrapper -->

    <!-- Copyright -->
    <div class="bg-gray-800 py-4">
        <div class="container flex items-center justify-between">
            <p class="text-white">&copy; Marketly - All Right Reserved</p>
            <div>
                <img src="../assets/images/methods.png" alt="methods" class="h-5">
            </div>
        </div>
    </div>
    <!-- ./Copyright -->
</body>

</html>