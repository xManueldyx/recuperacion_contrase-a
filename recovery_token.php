<?php
include("conexion.php");

// Inicializar variables
$token_verified = false;
$error_message = "";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Recuperar el token ingresado por el usuario
    $entered_token = $_POST['token'];

    // Recuperar el correo electrónico del usuario a partir del token ingresado
    $conn = connect();
    $stmt = $conn->prepare("SELECT email FROM users WHERE token = ?");
    $stmt->bind_param("s", $entered_token);
    $stmt->execute();
    $stmt->store_result();

    // Verificar si se encontró un usuario con el token ingresado
    if ($stmt->num_rows > 0) {
        $token_verified = true;
        // Obtener el correo electrónico del usuario
        $stmt->bind_result($email);
        $stmt->fetch();

        // Redirigir al usuario a la página de cambio de contraseña
        header("Location: change_pass.php?email=" . urlencode($email));
        exit();
    } else {
        // Si el token no es válido, mostrar un mensaje de error
        $error_message = "El token ingresado no es válido. Por favor, intenta nuevamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Token</title>
</head>

<body>
    <h1>Verificar Token</h1>
    <?php if (!$token_verified) { ?>
        <form action="" method="post">
            <div>
                <label for="token">Token generado:</label>
                <input type="text" id="token" name="token" required>
            </div>
            <div>
                <button type="submit" name="submit">Verificar Token</button>
            </div>
        </form>
        <?php if (!empty($error_message)) {
            echo "<p>$error_message</p>";
        } ?>
    <?php } ?>
</body>

</html>
