<?php
$title = "Detalles del Producto";
$site_name = "Marketly";

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_data = [];
$json_url = 'http://localhost:3000/usuarios/' . $_SESSION['user_id'];

try {
    $json_data = file_get_contents($json_url);

    if ($json_data !== false) {
        $user_data = json_decode($json_data, true);
        error_log("Datos del usuario obtenidos: " . print_r($user_data, true));
    }
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
}

// Calcular el total general
$total = 0;
if (!empty($_SESSION['cart'])):
    foreach ($_SESSION['cart'] as $product_id => $product):
        $total += $product['price'] * $product['quantity'];
    endforeach;
endif;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $telefono = $_POST['phone'] ?? '';
    $direccion = $_POST['address'] ?? '';
    $ciudad = $_POST['city'] ?? '';
    $pais = $_POST['region'] ?? '';
    $card_name = $_POST['card-name'] ?? '';
    $card_number = $_POST['card-number'] ?? '';
    $expiry_date = $_POST['expiry-date'] ?? '';
    $cvv = $_POST['cvv'] ?? '';

    if (empty($telefono) || empty($direccion) || empty($ciudad) || empty($pais)) {
        $error = "Todos los campos son obligatorios";
        error_log("Error de validación: " . $error);
    } else {
        $productos = [];

        if (!empty($_SESSION['cart'])):
            foreach ($_SESSION['cart'] as $product_id => $product) {

                $productos[] = [
                    'producto_id' => $product_id,
                    'cantidad' => $product['quantity']
                ];
            }
        endif;

        // arreglo para POST
        $data = [
            'usuario_id' => intval($_SESSION['user_id']),
            'total' => number_format($total, 2, '.', ''),
            'metodo_pago' => 'Tarjeta de Crédito',
            'direccion_envio' => "$direccion, $ciudad, $pais",
            'telefono' => $telefono,
            'card_name' => $card_name,
            'card_number' => $card_number,
            'expiry_date' => $expiry_date,
            'cvv' => $cvv,
            'tipo_tarjeta' => $_POST['card-type'],
            'productos' => $productos // Agregar los productos del carrito
        ];

        // Enviar los datos
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/json',
                'content' => json_encode($data)
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents('http://localhost:3000/pedidos', false, $context);

        //vaciar el carrito
        $_SESSION['cart'] = [];
        $total = 0;
        echo "<script>alert('¡Tu compra ha sido generada con éxito!'); window.location.href = '../index.php';</script>";
    }
}
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

    <!-- wrapper -->
    <div class="container grid grid-cols-12 items-start pb-16 pt-4 gap-6">
        <div class="col-span-8 border border-gray-200 p-4 rounded">
            <h3 class="text-lg font-medium capitalize mb-4">Datos</h3>

            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form method="POST" id="checkout-form" class="space-y-4">
                <div class="space-y-4">
                    <!-- Datos Personales -->
                    <div>
                        <label for="nombre" class="text-gray-600">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="input-box bg-gray-100"
                            value="<?php echo isset($user_data['nombre']) ? htmlspecialchars($user_data['nombre']) : ''; ?>"
                            readonly>
                    </div>
                    <div>
                        <label for="apellido" class="text-gray-600">Apellido</label>
                        <input type="text" name="apellido" id="apellido" class="input-box bg-gray-100"
                            value="<?php echo isset($user_data['apellido']) ? htmlspecialchars($user_data['apellido']) : ''; ?>"
                            readonly>
                    </div>
                    <div>
                        <label for="email" class="text-gray-600">Email</label>
                        <input type="email" name="email" id="email" class="input-box bg-gray-100"
                            value="<?php echo isset($user_data['email']) ? htmlspecialchars($user_data['email']) : ''; ?>"
                            readonly>
                    </div>
                    <div>
                        <label for="phone" class="text-gray-600">Teléfono <span class="text-primary">*</span></label>
                        <input type="text" name="phone" id="phone" class="input-box" required>
                    </div>

                    <!-- Dirección -->
                    <div>
                        <label for="region" class="text-gray-600">País <span class="text-primary">*</span></label>
                        <input type="text" name="region" id="region" class="input-box" required>
                    </div>
                    <div>
                        <label for="address" class="text-gray-600">Dirección <span class="text-primary">*</span></label>
                        <input type="text" name="address" id="address" class="input-box" required>
                    </div>
                    <div>
                        <label for="city" class="text-gray-600">Ciudad <span class="text-primary">*</span></label>
                        <input type="text" name="city" id="city" class="input-box" required>
                    </div>

                    <!-- Datos de Tarjeta -->
                    <div>
                        <label for="card-type" class="text-gray-600">Tipo de Tarjeta <span
                                class="text-primary">*</span></label>
                        <select name="card-type" id="card-type" class="input-box" required>
                            <option value="credito">Crédito</option>
                            <option value="debito">Débito</option>
                        </select>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium capitalize mb-4">Datos de la Tarjeta</h3>
                        <div>
                            <label for="card-name" class="text-gray-600">Nombre del Titular <span
                                    class="text-primary">*</span></label>
                            <input type="text" name="card-name" id="card-name" class="input-box" required>
                        </div>
                        <div>
                            <label for="card-number" class="text-gray-600">Número de Tarjeta <span
                                    class="text-primary">*</span></label>
                            <input type="text" name="card-number" id="card-number" class="input-box" maxlength="16"
                                required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="expiry-date" class="text-gray-600">Fecha de Expiración <span
                                        class="text-primary">*</span></label>
                                <input type="text" name="expiry-date" id="expiry-date" class="input-box"
                                    placeholder="MM/AA" required>
                            </div>
                            <div>
                                <label for="cvv" class="text-gray-600">CVV <span class="text-primary">*</span></label>
                                <input type="text" name="cvv" id="cvv" class="input-box" maxlength="4" required>
                            </div>
                        </div>
                    </div>
                </div>
            

        </div>
        <!-- Factura-->
        <div class="col-span-4">
            <div class="border border-gray-200 p-4 rounded sticky top-4">
                <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">Factura</h4>
                <div class="space-y-2">
                    <?php foreach ($_SESSION['cart'] as $product): ?>
                        <div class="flex justify-between">
                            <div>
                                <h5 class="text-gray-800 font-medium"><?= htmlspecialchars($product['name']) ?></h5>
                            </div>
                            <p class="text-gray-600">x<?= $product['quantity'] ?></p>
                            <p class="text-gray-800 font-medium">
                                $<?= number_format($product['price'] * $product['quantity'], 2) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="flex justify-between border-b border-gray-200 text-gray-800 font-medium py-3 uppercase">
                    <p>Subtotal</p>
                    <p>$<?= number_format($total, 2) ?></p>
                </div>

                <div class="flex justify-between text-gray-800 font-medium py-3 uppercase">
                    <p class="font-semibold">Total</p>
                    <p>$<?= number_format($total, 2) ?></p>
                </div>
                <button type="submit"
                    class="block w-full py-3 px-4 text-center text-white bg-primary border border-primary rounded-md hover:bg-transparent hover:text-primary transition font-medium">
                    Proceder a Pagar
                </button>
            </div>
        </div>
    </div>
    </form>
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