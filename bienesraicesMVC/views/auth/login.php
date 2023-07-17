<h1>Login</h1>
<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesion</h1>
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error ?>
        </div>
    <?php endforeach; ?>
    <form method="POST" action="/login" class="formulario ">
        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" required placeholder="Tu Email" id="email">

            <label for="password">Contraseña</label>
            <input type="password" name="password" required placeholder="Tu Password" id="password">

        </fieldset>
        <input type="submit" value="Iniciar Sesion" class="boton boton-verde">
    </form>
</main>