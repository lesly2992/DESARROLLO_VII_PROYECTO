<?php
session_start();
require_once __DIR__ . "/../../src/Database.php"; // Incluye tu archivo de conexión correctamente
include __DIR__ . "/../navAdmin.php";

if (!isset($_SESSION["user_id"]) || ($_SESSION["user_role"] !== "admin" && $_SESSION["user_role"] !== "superAdmin")) {
    header("Location: loginAdmin.php");
    exit;
}

// Roles disponibles
$roles = ['usuario', 'admin', 'superAdmin'];

// Módulos disponibles
$modulos = ['gestorPackage.php', 'gestorReservation.php', 'Usuarios.php', 'permisos.php'];

// Guardar permisos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_permisos'])) {
    $rol = $_POST['rol'];
    $permisos = $_POST['permisos'];

    try {
        // Inicia una transacción
        $PDO->beginTransaction();

        // Elimina permisos existentes del rol
        $stmt = $PDO->prepare("DELETE FROM permisos WHERE rol = :rol");
        $stmt->execute(['rol' => $rol]);

        // Inserta nuevos permisos
        $stmt = $PDO->prepare("
            INSERT INTO permisos (rol, modulo, ver, seleccionar, editar, eliminar, guardar)
            VALUES (:rol, :modulo, :ver, :seleccionar, :editar, :eliminar, :guardar)
        ");

        foreach ($modulos as $modulo) {
            $ver = isset($permisos[$modulo]['ver']) ? 1 : 0;
            $seleccionar = isset($permisos[$modulo]['seleccionar']) ? 1 : 0;
            $editar = isset($permisos[$modulo]['editar']) ? 1 : 0;
            $eliminar = isset($permisos[$modulo]['eliminar']) ? 1 : 0;
            $guardar = isset($permisos[$modulo]['guardar']) ? 1 : 0;

            $stmt->execute([
                'rol' => $rol,
                'modulo' => $modulo,
                'ver' => $ver,
                'seleccionar' => $seleccionar,
                'editar' => $editar,
                'eliminar' => $eliminar,
                'guardar' => $guardar
            ]);
        }

        // Confirma la transacción
        $PDO->commit();

        $_SESSION['mensaje'] = "Permisos guardados correctamente.";
    } catch (PDOException $e) {
        $PDO->rollBack(); // Revertir transacción en caso de error
        die('Error al guardar permisos: ' . $e->getMessage());
    }
}

// Obtener permisos actuales para un rol
$permisos_rol = [];
if (isset($_GET['rol'])) {
    $rol = $_GET['rol'];

    $stmt = $PDO->prepare("SELECT * FROM permisos WHERE rol = :rol");
    $stmt->execute(['rol' => $rol]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $permisos_rol[$row['modulo']] = $row;
    }
}
?>

    <style>
        /* Estilos específicos */
        .permisos-container {
            max-width: 800px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        .permisos-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .permisos-container th, .permisos-container td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .permisos-container th {
            background-color: #f4f4f4;
        }
        .btn-guardar {
            padding: 10px 15px;
            margin: 10px 0;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .mensaje {
            color: green;
            text-align: center;
        }
    </style>

    <div class="permisos-container">
        <h2>Gestión de Permisos</h2>

        <!-- Mostrar mensajes -->
        <?php if (isset($_SESSION['mensaje'])): ?>
            <p class="mensaje"><?= $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></p>
        <?php endif; ?>

        <!-- Selector de rol -->
        <form method="GET" action="permisos.php">
            <label for="rol">Seleccionar Rol:</label>
            <select name="rol" id="rol" onchange="this.form.submit()">
                <option value="">-- Seleccione un Rol --</option>
                <?php foreach ($roles as $r): ?>
                    <option value="<?= $r; ?>" <?= (isset($_GET['rol']) && $_GET['rol'] == $r) ? 'selected' : ''; ?>>
                        <?= ucfirst($r); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <!-- Formulario de permisos -->
        <?php if (isset($_GET['rol'])): ?>
            <form method="POST" action="permisos.php">
                <input type="hidden" name="rol" value="<?= $rol; ?>">
                <table>
                    <thead>
                        <tr>
                            <th>Módulo</th>
                            <th>Ver</th>
                            <th>Seleccionar</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                            <th>Guardar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($modulos as $modulo): ?>
                            <tr>
                                <td><?= $modulo; ?></td>
                                <td><input type="checkbox" name="permisos[<?= $modulo; ?>][ver]" <?= isset($permisos_rol[$modulo]) && $permisos_rol[$modulo]['ver'] ? 'checked' : ''; ?>></td>
                                <td><input type="checkbox" name="permisos[<?= $modulo; ?>][seleccionar]" <?= isset($permisos_rol[$modulo]) && $permisos_rol[$modulo]['seleccionar'] ? 'checked' : ''; ?>></td>
                                <td><input type="checkbox" name="permisos[<?= $modulo; ?>][editar]" <?= isset($permisos_rol[$modulo]) && $permisos_rol[$modulo]['editar'] ? 'checked' : ''; ?>></td>
                                <td><input type="checkbox" name="permisos[<?= $modulo; ?>][eliminar]" <?= isset($permisos_rol[$modulo]) && $permisos_rol[$modulo]['eliminar'] ? 'checked' : ''; ?>></td>
                                <td><input type="checkbox" name="permisos[<?= $modulo; ?>][guardar]" <?= isset($permisos_rol[$modulo]) && $permisos_rol[$modulo]['guardar'] ? 'checked' : ''; ?>></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" name="guardar_permisos" class="btn-guardar">Guardar Permisos</button>
            </form>
        <?php endif; ?>
    </div>

