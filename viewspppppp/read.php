<table borer="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td> <?= $usuario['id'] ?> </td>
                <td> <?= $usuario['nombre'] ?> </td>
                <td> <?= $usuario['email'] ?> </td>

                <td>
                    <a href="index.php?action=update&id=<?= $usuario['id'] ?> ">Editar</a>
                    <a href="index.php?action=delete&id=<?= $usuario['id'] ?> ">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
</table>

<a href="index.php?action=create">Agregar Nuevo Usuario</a>