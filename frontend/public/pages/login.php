<?php
$title = "Ingreso";
$site_name = "Marketly";
$email = $password = "";
$login_error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // URL de la API que devuelve los usuarios en formato JSON
    $json_url = "http://localhost:3000/usuarios"; // Cambia la URL si es necesario
    $json_data = @file_get_contents($json_url); // Usar @ para suprimir warnings si no se puede obtener los datos

    // Verificar si los datos de la API fueron obtenidos correctamente
    if ($json_data === false) {
        die('Error al obtener los usuarios');
    }

    // Decodificar el JSON a un array asociativo
    $usuarios = json_decode($json_data, true);

    // Buscar el usuario con el correo ingresado
    $usuarioEncontrado = null;
    foreach ($usuarios as $usuario) {
        if ($usuario['email'] === $email) {
            $usuarioEncontrado = $usuario;
            break;
        }
    }

    // Verificar si el usuario fue encontrado y la contraseña es correcta
    if ($usuarioEncontrado && $usuarioEncontrado['password'] === $password) {
        // Redirigir al usuario a la página de inicio si las credenciales son correctas
        header('Location: ../index.php');
        exit();
    } else {
        // Si las credenciales son incorrectas
        echo "Correo o contraseña incorrectos.";
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

    <!-- login -->
    <div class="contain py-16">
        <div class="max-w-lg mx-auto shadow px-6 py-7 rounded overflow-hidden">
            <h2 class="text-2xl uppercase font-medium mb-1">Ingresar</h2>
            <p class="text-gray-600 mb-6 text-sm">
                Bienvenido de nuevo
            </p>
            <form action="" method="post" autocomplete="off">
                <div class="space-y-2">
                    <div>
                        <label for="email" class="text-gray-600 mb-2 block">Correo</label>
                        <input type="email" name="email" id="email" value="<?= htmlspecialchars($email) ?>"
                            class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400"
                            placeholder="tuemail@dominio.com">
                    </div>
                    <div>
                        <label for="password" class="text-gray-600 mb-2 block">Contraseña</label>
                        <input type="password" name="password" id="password" value="<?= htmlspecialchars($password) ?>"
                            class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400"
                            placeholder="*******">
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                            class="text-primary focus:ring-0 rounded-sm cursor-pointer">
                        <label for="remember" class="text-gray-600 ml-3 cursor-pointer">Recuerdame</label>
                    </div>
                    <a href="#" class="text-primary">Olvidé mi contraseña</a>
                </div>
                <div class="mt-4">
                    <button type="submit"
                        class="block w-full py-2 text-center text-white bg-primary border border-primary rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium">Ingresar</button>
                </div>
            </form>

            <!-- Mostrar mensaje de error si es necesario -->
            <?php if ($login_error): ?>
                <p class="mt-4 text-center text-red-500"><?= $login_error ?></p>
            <?php endif; ?>

            <p class="mt-4 text-center text-gray-600">¿No tienes una cuenta? <a href="register.php"
                    class="text-primary">Registrarse ahora
                </a></p>
        </div>
    </div>
    <!-- ./login -->
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
