<fieldset>
    <legend>Nombre</legend>
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre Vendedor" value="<?php echo s($vendedor->nombre); ?>">
    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido Vendedor" value="<?php echo s($vendedor->apellido); ?>">

</fieldset>

<fieldset>
    <legend>Información Extra</legend>
    <label for="apellido">Telefono:</label>
    <input type="number" id="telefono" name="vendedor[telefono]" placeholder="telefono Vendedor" value="<?php echo s($vendedor->telefono); ?>">
</fieldset>