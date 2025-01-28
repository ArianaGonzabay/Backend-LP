<?php
$title = "Detalles del Producto";
$site_name = "Marketly";
$product_id = isset($_GET['id']) ? intval($_GET['id']) : null;

$product = null;
$json_url = "http://localhost:3000/productos/{$product_id}";
$json_data = @file_get_contents($json_url);

if ($json_data !== false) {
    $product = json_decode($json_data, true);
} else {
    $product = null;
}

$reviews = $product && isset($product['reviews']) ? $product['reviews'] : [];
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

    <!-- product-detail -->
    <?php if ($product): ?>
    <div class="container grid grid-cols-2 gap-6 my-8 mt-8">
    <div class="flex justify-center items-center">
        <img src="<?= htmlspecialchars($product['imagen']) ?>" alt="<?= htmlspecialchars($product['nombre']) ?>" class="w-1/2" style="width: 300px; height: 300px;">
    </div>

        <div>
            <h2 class="text-3xl font-medium uppercase mb-2"><?= htmlspecialchars($product['nombre']) ?></h2>
            <div class="flex items-center mb-4">
                <div class="flex gap-1 text-sm text-yellow-400">
                    <?php 
                    $rating = isset($product['rating']) ? $product['rating'] : 0;
                    for ($i = 0; $i < 5; $i++): ?>
                        <span><i class="fa-<?= $i < $rating ? 'solid' : 'regular' ?> fa-star"></i></span>
                    <?php endfor; ?>
                </div>
                <div class="text-xs text-gray-500 ml-3">(<?= count($reviews) ?> Reviews)</div>
            </div>
            <div class="space-y-2">
                <p class="text-gray-800 font-semibold space-x-2">
                    <span>Disponibilidad: </span>
                    <span class="text-green-600"><?= isset($product['stock']) && $product['stock'] > 0 ? 'En Stock' : 'Agotado' ?></span>
                </p>
                <p class="space-x-2">
                    <span class="text-gray-800 font-semibold">Categoría: </span>
                    <span class="text-gray-600"><?= htmlspecialchars($product['categoria'] ?? 'No especificado') ?></span>
                </p>
                <p class="space-x-2">
                    <span class="text-gray-800 font-semibold">ID: </span>
                    <span class="text-gray-600"><?= htmlspecialchars($product['id']) ?></span>
                </p>
            </div>
            <div class="flex items-baseline mb-1 space-x-2 font-roboto mt-4">
                <p class="text-xl text-primary font-semibold">$<?= number_format($product['precio'], 2) ?></p>
            </div>

            <p class="mt-4 text-gray-600"><?= htmlspecialchars($product['descripcion']) ?></p>

            <div class="mt-6">
                <a href="#" class="block w-full py-2 text-center text-white bg-primary rounded hover:bg-transparent hover:text-primary transition">
                    Agregar al carrito
                </a>
            </div>
        </div>
    </div>

    <!-- reviews -->
    <div class="container pb-16">
        <h3 class="border-b border-gray-200 font-roboto text-gray-800 pb-3 font-medium">
            Reseñas de Clientes (<?= count($reviews) ?>)
        </h3>
        
        <div class="mt-8 space-y-8">
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="flex items-start border-b border-gray-200 pb-8">
                        <div class="flex-shrink-0">
                            <img src="/api/placeholder/40/40" class="rounded-full" alt="user avatar">
                        </div>
                        <div class="ml-4 flex-grow">
                            <div class="flex items-center mb-2">
                                <h5 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($review['nombre'] ?? 'Usuario Anónimo') ?></h5>
                                <span class="ml-4 text-sm text-gray-500"><?= htmlspecialchars($review['fecha'] ?? 'Fecha no disponible') ?></span>
                            </div>
                            <div class="flex gap-1 text-sm text-yellow-400 mb-2">
                                <?php 
                                $review_rating = $review['rating'] ?? 0;
                                for ($i = 0; $i < $review_rating; $i++): ?>
                                    <span><i class="fa-solid fa-star"></i></span>
                                <?php endfor; ?>
                                <?php for ($i = $review_rating; $i < 5; $i++): ?>
                                    <span><i class="fa-regular fa-star"></i></span>
                                <?php endfor; ?>
                            </div>
                            <p class="text-gray-600"><?= htmlspecialchars($review['comentario'] ?? 'Sin comentarios') ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-600">No hay reseñas disponibles para este producto</p>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="container my-8">
        <p class="text-center text-gray-600">Producto no encontrado</p>
    </div>
    <?php endif; ?>

    <!-- Footer -->
    <div class="bg-gray-800 py-4">
        <div class="container flex items-center justify-between">
            <p class="text-white">&copy; <?= htmlspecialchars($site_name) ?> - Todos los derechos reservados</p>
        </div>
    </div>
</body>
</html>