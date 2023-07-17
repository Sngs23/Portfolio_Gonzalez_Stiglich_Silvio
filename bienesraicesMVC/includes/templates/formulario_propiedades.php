<fieldset>
            <legend>Informacion General</legend>
            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Propiedad" value="<?php echo s($propiedad->titulo); ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>">

            <label for=imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">
            <?php if($propiedad->imagen):?>
                <img src="/imagenes/<?php echo $propiedad->imagen;?>" class = "imagen-small">
            <?php endif; ?>
            <label for="descripcion">Descripcion:</label>
            <textarea id="descripcion" name="propiedad[descripcion]" value="<?php echo s($propiedad->descripcion); ?>" ></textarea>

        </fieldset>
        <fieldset>
            <legend>Informacion Propiedad:</legend>
            <label for="habitaciones">habitaciones:</label>
            <input type="number" id="habitaciones" name="propiedad[habitaciones]" value="<?php echo s($propiedad->habitaciones); ?>" placeholder="Cantidad de Habitaciones" min=1 max=20>

            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="propiedad[wc]" value="<?php echo s($propiedad->wc); ?>" placeholder="Cantidad de Baños" min=1 max=20>

            <label for="estacionamientos">Estacionamientos:</label>
            <input type="number" id="estacionamiento" name="propiedad[estacionamiento]" value="<?php echo s($propiedad->estacionamiento); ?>" placeholder="Cantidad de Estacionamientos" min=1 max=20>


        </fieldset>
        <fieldset>
            <legend>Vendedor:</legend>
            <label for="vendedor">Vendedor</label>
            <select name="propiedad[vendedorId]" id="vendedor">
            <option selected value ="" >--Seleccione Vendedor--</option>
            <?php foreach($vendedores as $vendedor ){?>
                <option <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected' : ''; ?> 
                value="<?php echo s($vendedor->id);?>" > <?php echo s($vendedor->nombre); ?></option>
            <?php } ?>
        </fieldset>