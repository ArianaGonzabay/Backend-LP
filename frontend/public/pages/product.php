<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

// Obtener el ID del usuario autenticado
$user_id = $_SESSION['user_id'];


// Inicializa el carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Maneja la acción de agregar al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
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
    // Redirige para evitar reenvío de formularios
    header("Location: cart.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['calificacion'])) {
    // Procesar el formulario de reseñas
    $product_id = $_POST['product_id'];
    $user_id = $_POST['user_id'];
    $rating = $_POST['calificacion'];
    $comment = $_POST['comentario'];

    // Realizar la petición POST al servidor API
    $url = 'http://localhost:3000/resenas';
    $data = [
        'producto_id' => $product_id,
        'usuario_id' => $user_id,
        'calificacion' => $rating,
        'comentario' => $comment
    ];

    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === false) {
        die('Error al enviar la reseña');
    }

    // Redirigir a la misma página para evitar reenvío del formulario
    header("Location: product.php?id={$product_id}");
    exit;

}

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

$reviews = $product && isset($product['reseñas']) ? $product['reseñas'] : [];
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
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
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
                <img src="<?= htmlspecialchars($product['imagen']) ?>" alt="<?= htmlspecialchars($product['nombre']) ?>"
                    class="w-1/2" style="width: 300px; height: 300px;">
            </div>

            <div>
                <h2 class="text-3xl font-medium uppercase mb-2"><?= htmlspecialchars($product['nombre']) ?></h2>
                <div class="flex items-center mb-4">
                    <div class="flex gap-1 text-sm text-yellow-400">
                        <?php
                        // Calcular el promedio de las calificaciones
                        $total_rating = 0;
                        $num_reviews = count($reviews);

                        if ($num_reviews > 0) {
                            foreach ($reviews as $review) {
                                $total_rating += $review['calificacion'] ?? 0;
                            }
                            $rating = $total_rating / $num_reviews;
                        } else {
                            $rating = 0;
                        }

                        // Mostrar las estrellas
                        for ($i = 0; $i < 5; $i++): ?>
                            <span><i class="fa-<?= $i < $rating ? 'solid' : 'regular' ?> fa-star"></i></span>
                        <?php endfor; ?>
                    </div>
                    <div class="text-xs text-gray-500 ml-3">(<?= count($reviews) ?> Reviews)</div>
                </div>
                <div class="space-y-2">
                    <p class="text-gray-800 font-semibold space-x-2">
                        <span>Disponibilidad: </span>
                        <span
                            class="text-green-600"><?= isset($product['stock']) && $product['stock'] > 0 ? 'En Stock' : 'Agotado' ?></span>
                    </p>
                    <p class="space-x-2">
                        <span class="text-gray-800 font-semibold">Categoría: </span>
                        <span
                            class="text-gray-600"><?= htmlspecialchars($product['categoria'] ?? 'No especificado') ?></span>
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
                    <form method="post" action="">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                        <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['nombre']) ?>">
                        <input type="hidden" name="product_price" value="<?= htmlspecialchars($product['precio']) ?>">
                        <input type="hidden" name="product_image" value="<?= htmlspecialchars($product['imagen']) ?>">
                        <button type="submit" name="add_to_cart"
                            class="block w-full py-1 text-center text-white bg-primary border border-primary rounded-b hover:bg-transparent hover:text-primary transition"
                            style="background-color: rgb(253, 61, 87); color: white; border: 1px solid rgb(253, 61, 87); padding: 8px; border-radius: 5px; transition: all 0.3s ease-in-out;"
                            onmouseover="this.style.backgroundColor='white'; this.style.color='rgb(253, 61, 87)';"
                            onmouseout="this.style.backgroundColor='rgb(253, 61, 87)'; this.style.color='white';">
                            Agregar a carrito
                        </button>
                    </form>
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
                                <img src="https://static.vecteezy.com/system/resources/previews/036/280/651/non_2x/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-illustration-vector.jpg"
                                    class="rounded-full" alt="user avatar" style="width: 50px; height: 50px;">
                            </div>
                            <div class="ml-4 flex-grow">
                                <div class="flex items-center mb-2">
                                    <h5 class="text-lg font-semibold text-gray-800">
                                        <?= htmlspecialchars("Usuario ID: " . ($review['usuario_id'] ?? 'Usuario Anónimo')) ?>
                                    </h5>
                                    <span class="ml-4 text-sm text-gray-500">
                                        <?php
                                        $fecha = new DateTime($review['fecha'] ?? 'now', new DateTimeZone('UTC'));
                                        $fecha->setTimezone(new DateTimeZone('America/Guayaquil'));
                                        echo htmlspecialchars($fecha->format('d/m/Y H:i'));
                                        ?>
                                    </span>
                                </div>
                                <div class="flex gap-1 text-sm text-yellow-400 mb-2">
                                    <?php
                                    $review_rating = $review['calificacion'] ?? 0;
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

        <!-- Add Review Form -->
        <div class="contenedor">
            <h3 class="text-xl font-semibold mb-4">Agregar una Reseña</h3>
            <form action="product.php" method="POST" class="space-y-4">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <!-- ID del producto -->
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <!-- Campo para el comentario -->
                <div>
                    <label for="comentario" class="block text-gray-700">Comentario</label>
                    <textarea id="comentario" name="comentario" rows="4"
                        class="border border-gray-300 rounded w-full py-2 px-4" required></textarea>
                </div>

                <!-- Campo para la calificación -->
                <div>
                    <label for="calificacion" class="block text-gray-700">Puntuación</label>
                    <select id="calificacion" name="calificacion" class="border border-gray-300 rounded w-full py-2 px-4"
                        required>
                        <option value="">Seleccione una puntuación</option>
                        <option value="1">1 - Muy Malo</option>
                        <option value="2">2 - Malo</option>
                        <option value="3">3 - Regular</option>
                        <option value="4">4 - Bueno</option>
                        <option value="5">5 - Excelente</option>
                    </select>
                </div>

                <!-- Botón para enviar -->
                <div>
                    <button type="submit"
                        class="bg-primary text-white py-2 px-4 rounded hover:bg-transparent hover:text-primary transition">
                        Enviar Reseña
                    </button>
                </div>
            </form>
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