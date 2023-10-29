<!DOCTYPE html>
<html>
<head>
    <title>CRUD en una sola página</title>
</head>
<body>
    <?php
    // Conexión a la base de datos
    $servername = "localhost";
    $username = "tu_usuario";
    $password = "tu_contraseña";
    $dbname = "tu_base_de_datos";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Comprobar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Procesar la creación de un usuario
    if (isset($_POST['crear'])) {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];

        $sql = "INSERT INTO usuarios (nombre, email) VALUES ('$nombre', '$email')";
        if ($conn->query($sql) === TRUE) {
            echo "Usuario creado con éxito.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Procesar la actualización de un usuario
    if (isset($_POST['actualizar'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];

        $sql = "UPDATE usuarios SET nombre='$nombre', email='$email' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Usuario actualizado con éxito.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Procesar la eliminación de un usuario
    if (isset($_GET['eliminar'])) {
        $id = $_GET['eliminar'];

        $sql = "DELETE FROM usuarios WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Usuario eliminado con éxito.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>

    <h2>Crear Usuario</h2>
    <form method="post">
        Nombre: <input type="text" name="nombre" required><br>
        Email: <input type="email" name="email" required><br>
        <input type="submit" name="crear" value="Crear">
    </form>

    <h2>Lista de Usuarios</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM usuarios");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["nombre"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>
                            <a href='?editar=" . $row["id"] . "'>Editar</a>
                            <a href='?eliminar=" . $row["id"] . "'>Eliminar</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "No hay usuarios en la base de datos.";
        }
        ?>
    </table>

    <?php
    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>
</body>
</html>
