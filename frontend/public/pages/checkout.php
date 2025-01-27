<?php
$title = "Detalles del Producto";
$site_name = "Marketly";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
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

    <!-- wrapper -->
    <div class="container grid grid-cols-12 items-start pb-16 pt-4 gap-6">

        <div class="col-span-8 border border-gray-200 p-4 rounded">
            <h3 class="text-lg font-medium capitalize mb-4">Checkout</h3>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first-name" class="text-gray-600">First Name <span
                                class="text-primary">*</span></label>
                        <input type="text" name="first-name" id="first-name" class="input-box">
                    </div>
                    <div>
                        <label for="last-name" class="text-gray-600">Last Name <span
                                class="text-primary">*</span></label>
                        <input type="text" name="last-name" id="last-name" class="input-box">
                    </div>
                </div>
                <div>
                    <label for="company" class="text-gray-600">Company</label>
                    <input type="text" name="company" id="company" class="input-box">
                </div>
                <div>
                    <label for="region" class="text-gray-600">Country/Region</label>
                    <input type="text" name="region" id="region" class="input-box">
                </div>
                <div>
                    <label for="address" class="text-gray-600">Street address</label>
                    <input type="text" name="address" id="address" class="input-box">
                </div>
                <div>
                    <label for="city" class="text-gray-600">City</label>
                    <input type="text" name="city" id="city" class="input-box">
                </div>
                <div>
                    <label for="phone" class="text-gray-600">Phone number</label>
                    <input type="text" name="phone" id="phone" class="input-box">
                </div>
                <div>
                    <label for="email" class="text-gray-600">Email address</label>
                    <input type="email" name="email" id="email" class="input-box">
                </div>
                <div>
                    <label for="company" class="text-gray-600">Company</label>
                    <input type="text" name="company" id="company" class="input-box">
                </div>
            </div>

        </div>

        <div class="col-span-4 border border-gray-200 p-4 rounded">
            <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">order summary</h4>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <div>
                        <h5 class="text-gray-800 font-medium">Italian shape sofa</h5>
                        <p class="text-sm text-gray-600">Size: M</p>
                    </div>
                    <p class="text-gray-600">
                        x3
                    </p>
                    <p class="text-gray-800 font-medium">$320</p>
                </div>
                <div class="flex justify-between">
                    <div>
                        <h5 class="text-gray-800 font-medium">Italian shape sofa</h5>
                        <p class="text-sm text-gray-600">Size: M</p>
                    </div>
                    <p class="text-gray-600">
                        x3
                    </p>
                    <p class="text-gray-800 font-medium">$320</p>
                </div>
                <div class="flex justify-between">
                    <div>
                        <h5 class="text-gray-800 font-medium">Italian shape sofa</h5>
                        <p class="text-sm text-gray-600">Size: M</p>
                    </div>
                    <p class="text-gray-600">
                        x3
                    </p>
                    <p class="text-gray-800 font-medium">$320</p>
                </div>
                <div class="flex justify-between">
                    <div>
                        <h5 class="text-gray-800 font-medium">Italian shape sofa</h5>
                        <p class="text-sm text-gray-600">Size: M</p>
                    </div>
                    <p class="text-gray-600">
                        x3
                    </p>
                    <p class="text-gray-800 font-medium">$320</p>
                </div>
            </div>

            <div class="flex justify-between border-b border-gray-200 mt-1 text-gray-800 font-medium py-3 uppercas">
                <p>subtotal</p>
                <p>$1280</p>
            </div>

            <div class="flex justify-between border-b border-gray-200 mt-1 text-gray-800 font-medium py-3 uppercas">
                <p>shipping</p>
                <p>Free</p>
            </div>

            <div class="flex justify-between text-gray-800 font-medium py-3 uppercas">
                <p class="font-semibold">Total</p>
                <p>$1280</p>
            </div>

            <div class="flex items-center mb-4 mt-2">
                <input type="checkbox" name="aggrement" id="aggrement"
                    class="text-primary focus:ring-0 rounded-sm cursor-pointer w-3 h-3">
                <label for="aggrement" class="text-gray-600 ml-3 cursor-pointer text-sm">I agree to the <a href="#"
                        class="text-primary">terms & conditions</a></label>
            </div>

            <a href="#"
                class="block w-full py-3 px-4 text-center text-white bg-primary border border-primary rounded-md hover:bg-transparent hover:text-primary transition font-medium">Place
                order</a>
        </div>

    </div>
    <!-- ./wrapper -->

     <!-- Footer -->
     <div class="bg-gray-800 py-4">
        <div class="container flex items-center justify-between">
            <p class="text-white">&copy; Marketly - All Right Reserved</p>
            <div>
                <img src="../assets/images/methods.png" alt="methods" class="h-5">
            </div>
        </div>
    </div>
</body>
</html>