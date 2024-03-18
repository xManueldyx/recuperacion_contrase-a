<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de inicio de sesión</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="col-md-6">
            <h2>Recuperar contraseña</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Recuperar contraseña</button>
            </form>
        </div>
    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>

<?php
include("conexion.php");
// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Recuperar el correo electrónico del formulario
    $email = $_POST['email'];

    // Realizar una consulta a la base de datos para verificar si el correo electrónico existe
    $conn = connect();
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;

    // Si el correo electrónico existe en la base de datos, redirigir a recovery_success.php
    if ($num_rows > 0) {
        header("Location: success.php?email=" . urlencode($email) . "&token=" . urlencode($token));
        exit();
    } else {
        // Si el correo electrónico no existe en la base de datos, mostrar un mensaje de error
        echo "<p class='text-danger'>El correo electrónico proporcionado no está registrado.</p>";
    }
}
