<?php
session_start();
if (!isset($_SESSION["user_id"]) || ($_SESSION["user_role"] !== "admin" && $_SESSION["user_role"] !== "superAdmin")) {
    header("Location: loginAdmin.php");
    exit;
}

include __DIR__ . "/../navAdmin.php";
include __DIR__ . "/reservasController.php";
?>

<link rel="stylesheet" href="reservasStyle.css">

<div class="reservas-container">
    <!-- Formulario -->
    <div class="reservas-form-container">
        <?php include __DIR__ . "/reservasForm.php"; ?>
    </div>

    <!-- Tabla -->
    <div class="reservas-table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Comentario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $reserva) : ?>
                <tr>
                    <td><?php echo $reserva['id']; ?></td>
                    <td><?php echo htmlspecialchars($reserva['nombre_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($reserva['email_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($reserva['telefono_cliente']); ?></td>
                    <td><?php echo $reserva['fecha_reserva']; ?></td>
                    <td><?php echo $reserva['hora_reserva']; ?></td>
                    <td><?php echo ucfirst($reserva['estado']); ?></td>
                    <td><?php echo htmlspecialchars($reserva['comentario']); ?></td>
                    <td>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $reserva['id']; ?>">
                            <button type="submit" name="action" value="edit" class="reservas-button">Editar</button>
                        </form>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $reserva['id']; ?>">
                            <button type="submit" name="action" value="delete" class="reservas-button reservas-button-cancelar">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
