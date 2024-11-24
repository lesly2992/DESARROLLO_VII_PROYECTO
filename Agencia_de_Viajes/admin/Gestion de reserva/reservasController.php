<?php

require_once __DIR__ . "/../../src/Database.php";


$reservas = [];
$reservaSeleccionada = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $id = $_POST['id'] ?? null;
        $nombre_cliente = $_POST['nombre_cliente'];
        $email_cliente = $_POST['email_cliente'];
        $telefono_cliente = $_POST['telefono_cliente'];
        $fecha_reserva = $_POST['fecha_reserva'];
        $hora_reserva = $_POST['hora_reserva'];
        $estado = $_POST['estado'];
        $comentario = $_POST['comentario'];

        if ($id) {
            $stmt = $PDO->prepare("UPDATE reservas SET nombre_cliente = ?, email_cliente = ?, telefono_cliente = ?, fecha_reserva = ?, hora_reserva = ?, estado = ?, comentario = ? WHERE id = ?");
            $stmt->execute([$nombre_cliente, $email_cliente, $telefono_cliente, $fecha_reserva, $hora_reserva, $estado, $comentario, $id]);
        } else {
            $stmt = $PDO->prepare("INSERT INTO reservas (nombre_cliente, email_cliente, telefono_cliente, fecha_reserva, hora_reserva, estado, comentario) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre_cliente, $email_cliente, $telefono_cliente, $fecha_reserva, $hora_reserva, $estado, $comentario]);
        }
    } elseif ($action === 'delete') {
        $id = $_POST['id'];
        $stmt = $PDO->prepare("DELETE FROM reservas WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($action === 'edit') {
        $id = $_POST['id'];
        $stmt = $PDO->prepare("SELECT * FROM reservas WHERE id = ?");
        $stmt->execute([$id]);
        $reservaSeleccionada = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

$stmt = $PDO->query("SELECT * FROM reservas");
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
