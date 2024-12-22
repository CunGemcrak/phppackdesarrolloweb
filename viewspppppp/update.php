<form method="post">
Nombre: <input type="text" name="nombre" value="<?= $usuario['nombre'] ?>" required>
    Email: <input type="email" name="email" value="<?= $usuario['email'] ?>" required>
    <button type="submit">Actualizar Usuario</button> 
</form>