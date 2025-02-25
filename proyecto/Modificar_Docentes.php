<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Docente</title>
    <link rel="stylesheet" href="css/BD.css">
    <link rel="stylesheet" href="css/Botones.css">
    <link rel="stylesheet" href="css/Formulario_Modificar.css">
</head>
</head>
<body>
    <h1>Modificar Docente</h1>
    <div class="form-container">
        <form action="" method="post">
            <div class="form-row">
                <label for="dni">DNI del Docente:</label>
                <input type="text" name="dni" required>
            </div>
            <button type="submit" name="action" value="search">Buscar docente</button>
        </form>
    </div>

    <?php
    $conexion = mysqli_connect("localhost", "root", "", "classrunkbd");
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_errno());
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && $_POST['action'] == 'search') {
            $dni = mysqli_real_escape_string($conexion, $_POST['dni']);

            if (!empty($dni)) {

                $consulta = "SELECT * FROM docentes WHERE DNI='$dni'";
                $resultado = mysqli_query($conexion, $consulta);

                if ($resultado && mysqli_num_rows($resultado) > 0) {
                    $docente = mysqli_fetch_assoc($resultado);
                    echo "<div class='form-container'>
                            <form action='' method='post'>
                                <input type='hidden' name='dni' value='$dni'>
                                <div class='form-row'>
                                    <label for='apellido'>Apellido:</label>
                                    <input type='text' name='apellido' value='" . htmlspecialchars($docente['Apellido']) . "' required>
                                </div>
                                <div class='form-row'>
                                    <label for='nombre'>Nombre:</label>
                                    <input type='text' name='nombre' value='" . htmlspecialchars($docente['Nombre']) . "' required>
                                </div>
                                <div class='form-row'>
                                    <label for='domicilio'>Domicilio:</label>
                                    <input type='text' name='domicilio' value='" . htmlspecialchars($docente['Domicilio']) . "' required>
                                </div>
                                <div class='form-row'>
                                    <label for='localidad'>Localidad:</label>
                                    <input type='text' name='localidad' value='" . htmlspecialchars($docente['Localidad']) . "' required>
                                </div>
                                <div class='form-row'>
                                    <label for='fecha_nacimiento'>Fecha de Nacimiento:</label>
                                    <input type='date' name='fecha_nacimiento' value='" . htmlspecialchars($docente['Fecha_de_Nacimiento']) . "' required>
                                </div>
                                <div class='form-row'>
                                    <label for='carrera'>Carrera:</label>
                                    <select name='carrera' required>
                                        <option value=''>Seleccione una opción</option>
                                        <option value='DS'" . ($docente['Carrera'] == 'DS' ? ' selected' : '') . ">DS</option>
                                        <option value='AF'" . ($docente['Carrera'] == 'AF' ? ' selected' : '') . ">AF</option>
                                        <option value='ITI'" . ($docente['Carrera'] == 'ITI' ? ' selected' : '') . ">ITI</option>
                                    </select>
                                </div>
                                <div class='form-row'>
                                    <label for='correo'>Correo Electrónico:</label>
                                    <input type='email' name='correo' value='" . htmlspecialchars($docente['Correo_Electronico']) . "' required>
                                </div>
                                <button type='submit' name='action' value='update'>Modificar Docente</button>
                            </form>
                          </div>";
                } else {
                    echo "<p>No se encontró un docente con ese DNI.</p>";
                }
            } else {
                echo "<p>Por favor, ingresa un DNI válido.</p>";
            }
        } elseif (isset($_POST['action']) && $_POST['action'] == 'update') {
            $dni = mysqli_real_escape_string($conexion, $_POST['dni']);
            $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
            $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
            $domicilio = mysqli_real_escape_string($conexion, $_POST['domicilio']);
            $localidad = mysqli_real_escape_string($conexion, $_POST['localidad']);
            $fecha_nacimiento = mysqli_real_escape_string($conexion, $_POST['fecha_nacimiento']);
            $carrera = mysqli_real_escape_string($conexion, $_POST['carrera']);
            $correo = mysqli_real_escape_string($conexion, $_POST['correo']);

            $consulta = "UPDATE docentes SET 
                            Apellido='$apellido', 
                            Nombre='$nombre', 
                            Domicilio='$domicilio', 
                            Localidad='$localidad', 
                            Fecha_de_Nacimiento='$fecha_nacimiento', 
                            Carrera='$carrera', 
                            Correo_Electronico='$correo' 
                         WHERE DNI='$dni'";
            
            if (mysqli_query($conexion, $consulta)) {
                if (mysqli_affected_rows($conexion) > 0) {
                    echo "<p>Datos del docente modificados correctamente.</p>";
                } else {
                    echo "<p>No se encontraron cambios para realizar.</p>";
                }
            } else {
                echo "<p>Error: " . mysqli_error($conexion) . "</p>";
            }
        }
    }

    mysqli_close($conexion);
    ?>

    <footer>
        <a href="Boton_BDDocentes.php"><button>Volver</button></a><br>
        <a href="salir.php">Cerrar sesión</a>
    </footer>
</body>
</html>