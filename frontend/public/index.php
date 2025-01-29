<?php
session_start();

// Inicializa el carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Maneja la acción de agregar al carrito
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    // Verifica si el producto ya está en el carrito
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'price' => $product_price,
            'image' => $product_image,
            'quantity' => 1
        ];
    }
}

// Datos de los productos
$title = "Catálogo de Productos";
$companyName = "Marketly";
$year = date("Y");

$products = [];
$json_url = 'http://localhost:3000/productos';
$json_data = @file_get_contents($json_url);

if ($json_data !== false) {
    $products = json_decode($json_data, true);
} else {
    $products = [];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="shortcut icon" href="../assets/images/marketly.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
</head>

<body>
    <!-- Header -->
    <header class="py-4 shadow-sm" style="background-color: #111827;">
        <div class="container flex items-center justify-center">
            <a href="index.php" class="flex items-center">
                <img src="../assets/images/marketly.png" alt="logo" class="h-12 mr-4">
                <h2 class="text-3xl font-semibold text-white"><?= $companyName ?></h2>
            </a>
        </div>
    </header>

    <!-- Navbar -->
    <nav class="bg-gray-800">
        <div class="container flex">
            <div class="flex items-center justify-between flex-grow md:pl-12 py-5">
                <div class="flex items-center space-x-6 capitalize">
                    <a href="index.php" class="text-gray-200 hover:text-white transition">Catálogo</a>
                    <a href="pages/cart.php" class="text-gray-200 hover:text-white transition">Carrito</a>
                    
                </div>
            </div>
        </div>
    </nav>

    <!-- Shop Wrapper -->
    <div class="container mx-auto px-4 py-8 grid md:grid-cols-4 grid-cols-2 gap-6 pt-4 pb-16 items-start justify-center">
        <!-- Products -->
        <div class="col-span-4 md:col-span-3 px-4 py-6">
            <div class="grid md:grid-cols-3 grid-cols-2 gap-4 justify-items-center">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="bg-white shadow rounded overflow-hidden group max-w-xs h-full">
                            <div class="relative h-48">
                                <img src="<?= $product['imagen'] ?>" alt="<?= $product['nombre'] ?>"
                                    class="w-full h-full object-cover">
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                                    <a href="pages/product.php?id=<?= $product['id'] ?>"
                                        class="text-white text-lg w-9 h-8 rounded-full bg-primary flex items-center justify-center hover:bg-gray-800 transition"
                                        title="view product">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- Product Details -->
                            <div class="pt-4 pb-3 px-4 h-32">
                                <a href="pages/product.php?id=<?= $product['id'] ?>">
                                    <h4 class="uppercase font-medium text-lg mb-2 text-gray-800 hover:text-primary transition">
                                        <?= $product['nombre'] ?>
                                    </h4>
                                </a>
                                <div class="flex items-baseline mb-1 space-x-2">
                                    <p class="text-lg text-primary font-semibold">$<?= number_format($product['precio'], 2) ?></p>
                                </div>
                            </div>

                            <!-- Add to Cart -->
                            <form method="post" action="">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="product_name" value="<?= $product['nombre'] ?>">
                                <input type="hidden" name="product_price" value="<?= $product['precio'] ?>">
                                <input type="hidden" name="product_image" value="<?= $product['imagen'] ?>">
                                <button type="submit" name="add_to_cart"
                                    class="block w-full py-1 text-center text-white bg-primary border border-primary rounded-b hover:bg-transparent hover:text-primary transition"
                                    style="background-color: rgb(253, 61, 87); color: white; border: 1px solid rgb(253, 61, 87); padding: 8px; border-radius: 5px; transition: all 0.3s ease-in-out;"
                                    onmouseover="this.style.backgroundColor='white'; this.style.color='rgb(253, 61, 87)';"
                                    onmouseout="this.style.backgroundColor='rgb(253, 61, 87)'; this.style.color='white';">
                                    Agregar a carrito
                                </button>
                            </form>


                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="col-span-full text-center text-gray-600">No se encontraron productos.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="bg-gray-800 py-4">
        <div class="container flex items-center justify-between">
            <p class="text-white">&copy; <?= $companyName ?> - All Right Reserved <?= $year ?></p>
            <div>
                <img src="../assets/images/methods.png" alt="methods" class="h-5">
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</body>

</html>