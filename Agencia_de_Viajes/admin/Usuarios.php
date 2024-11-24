<?php
session_start();
if (!isset($_SESSION["user_id"]) || ($_SESSION["user_role"] !== "admin" && $_SESSION["user_role"] !== "superAdmin")) {
    header("Location: loginAdmin.php");
    exit;
}


include("navAdmin.php"); // Barra de navegación
require __DIR__ . "/../src/Database.php"; // Conexión a la base de datos

$errorMessage = "";
$successMessage = "";

// Procesar las acciones
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["action"])) {
        try {

            if (isset($_POST['action']) && $_POST['action'] == 'cancelar') {
                // Redirigir a la misma página para "limpiar" el formulario
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }

            // Acción: Agregar o Actualizar Usuario
            if ($_POST["action"] === "guardar") {
                $id = $_POST["id"] ?? null;
                $username = $_POST["username"];
                $email = $_POST["email"];
                $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Encriptar contraseña
                $rol = $_POST["rol"];

                if ($id) {
                    // Actualizar usuario existente
                    $stmt = $PDO->prepare("UPDATE usuarios SET username = ?, email = ?, password = ?, rol = ? WHERE id = ?");
                    $stmt->execute([$username, $email, $password, $rol, $id]);
                    $successMessage = "Usuario actualizado correctamente.";
                } else {
                    // Insertar nuevo usuario
                    $stmt = $PDO->prepare("INSERT INTO usuarios (username, email, password, rol) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$username, $email, $password, $rol]);
                    $successMessage = "Usuario agregado correctamente.";
                }
            }

            // Acción: Eliminar Usuario
            if ($_POST["action"] === "eliminar") {
                $id = $_POST["id"];
                $stmt = $PDO->prepare("DELETE FROM usuarios WHERE id = ?");
                $stmt->execute([$id]);
                $successMessage = "Usuario eliminado correctamente.";
            }
        } catch (PDOException $e) {
            $errorMessage = "Error en la base de datos: " . $e->getMessage();
        }
    }
}

// Obtener los usuarios actuales
try {
    $stmt = $PDO->query("SELECT id, username, email, rol, register_date FROM usuarios");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errorMessage = "Error al obtener los usuarios: " . $e->getMessage();
}
?>

<!-- Estilos -->
<style>
    .clientes-container {
        margin: 20px auto;
        margin-left: 220px; /* Espacio para el menú */
        margin-right: 20px;
        padding: 15px;
        max-width: 90%;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .clientes-form {
        margin-bottom: 20px;
    }

    .clientes-form input, .clientes-form select {
        margin-bottom: 10px;
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .clientes-table {
        width: 100%;
        border-collapse: collapse;
    }

    .clientes-table th, .clientes-table td {
        border: 1px solid #ddd;
        padding: 15px 15px 20px;
        text-align: left;
    }

    .clientes-table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    .clientes-actions button {
        margin-right: 5px;
        padding: 5px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    .btn-guardar {
        background-color: #4caf50;
        color: white;
    }

    .btn-editar {
        background-color: #2196f3;
        color: white;
    }

    .btn-eliminar {
        background-color: #f44336;
        color: white;
    }
    .btn-cancelar{
        background-color: grey;
        color: white;
    }
</style>

<div class="clientes-container">
    <h2>Gestión de Usuarios</h2>

    <!-- Mensajes de Éxito/Error -->
    <?php if (!empty($errorMessage)) : ?>
        <div style="color: red;"><?php echo $errorMessage; ?></div>
    <?php endif; ?>
    <?php if (!empty($successMessage)) : ?>
        <div style="color: green;"><?php echo $successMessage; ?></div>
    <?php endif; ?>

    <!-- Formulario para Agregar/Editar Usuarios -->
    <form class="clientes-form" method="POST">
        <input type="hidden" name="id" id="form-id">
        <input type="text" name="username" id="form-username" placeholder="Nombre de Usuario" required>
        <input type="email" name="email" id="form-email" placeholder="Email" required>
        <input type="password" name="password" id="form-password" placeholder="Contraseña">
        <select name="rol" id="form-rol" required>
            <option value="usuario">Usuario</option>
            <option value="admin">Admin</option>
            <option value="superAdmin">Super Admin</option>
        </select>
        <button type="submit" name="action" value="guardar" class="btn-guardar">Guardar</button>
        <button type="submit" name="action" value="cancelar"class="btn-cancelar">Cancelar</button>
    </form>

    <!-- Tabla de Usuarios -->
    <table class="clientes-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Fecha de Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)) : ?>
                <?php foreach ($usuarios as $usuario) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td><?php echo ucfirst(htmlspecialchars($usuario['rol'])); ?></td>
                        <td><?php echo htmlspecialchars($usuario['register_date']); ?></td>
                        <td class="clientes-actions">
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                <button type="button" class="btn-editar" onclick="editarUsuario(<?php echo htmlspecialchars(json_encode($usuario)); ?>)">Editar</button>
                                <button type="submit" name="action" value="eliminar" class="btn-eliminar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function editarUsuario(usuario) {
        document.getElementById('form-id').value = usuario.id;
        document.getElementById('form-username').value = usuario.username;
        document.getElementById('form-email').value = usuario.email;
        document.getElementById('form-password').value = ""; // Deja el campo vacío
        document.getElementById('form-rol').value = usuario.rol;
    }
</script>
