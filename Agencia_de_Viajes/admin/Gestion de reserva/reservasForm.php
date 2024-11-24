<form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $reservaSeleccionada['id'] ?? ''; ?>">
    <div>
        <label for="nombre_cliente">Nombre del Cliente:</label>
        <input type="text" id="nombre_cliente" name="nombre_cliente" value="<?php echo $reservaSeleccionada['nombre_cliente'] ?? ''; ?>" required>
    </div>
    <div>
        <label for="email_cliente">Email:</label>
        <input type="email" id="email_cliente" name="email_cliente" value="<?php echo $reservaSeleccionada['email_cliente'] ?? ''; ?>" required>
    </div>
    <div>
        <label for="telefono_cliente">Teléfono:</label>
        <input type="text" id="telefono_cliente" name="telefono_cliente" value="<?php echo $reservaSeleccionada['telefono_cliente'] ?? ''; ?>" required>
    </div>
    <div>
        <label for="fecha_reserva">Fecha de la Reserva:</label>
        <input type="date" id="fecha_reserva" name="fecha_reserva" value="<?php echo $reservaSeleccionada['fecha_reserva'] ?? ''; ?>" required>
    </div>
    <div>
        <label for="hora_reserva">Hora de la Reserva:</label>
        <input type="time" id="hora_reserva" name="hora_reserva" value="<?php echo $reservaSeleccionada['hora_reserva'] ?? ''; ?>" required>
    </div>
    <div>
        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="pendiente" <?php echo (isset($reservaSeleccionada['estado']) && $reservaSeleccionada['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
            <option value="confirmada" <?php echo (isset($reservaSeleccionada['estado']) && $reservaSeleccionada['estado'] == 'confirmada') ? 'selected' : ''; ?>>Confirmada</option>
            <option value="cancelada" <?php echo (isset($reservaSeleccionada['estado']) && $reservaSeleccionada['estado'] == 'cancelada') ? 'selected' : ''; ?>>Cancelada</option>
        </select>
    </div>
    <div>
        <label for="comentario">Comentario:</label>
        <textarea id="comentario" name="comentario"><?php echo $reservaSeleccionada['comentario'] ?? ''; ?></textarea>
    </div>
    <div>
        <button type="submit" name="action" value="save">Guardar</button>
        <button type="submit" name="action" value="cancel">Cancelar</button>
    </div>
</form>
