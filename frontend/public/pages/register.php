<?php
$site_name = "Marketly";
$title = "Registro de Usuario";
// Validación y obtención de los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validación básica de los campos
    if (empty($nombre) || empty($apellido) || empty($email) || empty($password)) {
        echo "Todos los campos son obligatorios.";
    } else {

        // datos del usuario
        $data = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'password' => $password
        ];

        $json_data = json_encode($data);

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => $json_data
            ]
        ];

        $context = stream_context_create($options);
        $url = 'http://localhost:3000/usuarios';
        // solicitud POST
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            echo "Error al crear el usuario.";
        } else {
            $response = json_decode($result, true);
            if (isset($response['message']) && $response['message'] == 'Usuario creado exitosamente') {
                header("Location: login.php");
                exit;
            } else {
                echo "Hubo un problema al crear el usuario.";
            }
        }
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

    <!-- Registro -->
    <div class="contain py-16">
        <div class="max-w-lg mx-auto shadow px-6 py-7 rounded overflow-hidden">
            <h2 class="text-2xl uppercase font-medium mb-1">Registro de Usuario</h2>
            <p class="text-gray-600 mb-6 text-sm">¡Crea tu cuenta para comenzar a comprar!</p>
            <form action="register.php" method="POST" autocomplete="off">
                <div class="space-y-2">
                    <div>
                        <label for="nombre" class="text-gray-600 mb-2 block">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400" required>
                    </div>
                    <div>
                        <label for="apellido" class="text-gray-600 mb-2 block">Apellido</label>
                        <input type="text" name="apellido" id="apellido" class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400" required>
                    </div>
                    <div>
                        <label for="email" class="text-gray-600 mb-2 block">Correo Electrónico</label>
                        <input type="email" name="email" id="email" class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400" required>
                    </div>
                    <div>
                        <label for="password" class="text-gray-600 mb-2 block">Contraseña</label>
                        <input type="password" name="password" id="password" class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400" required>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="block w-full py-2 text-center text-white bg-primary border border-primary rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium">Crear Cuenta</button>
                </div>
            </form>

            <p class="mt-4 text-center text-gray-600">¿Ya tienes cuenta? <a href="login.php" class="text-primary">Inicia sesión</a></p>
        </div>
    </div>
    <!-- ./Registro -->

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
