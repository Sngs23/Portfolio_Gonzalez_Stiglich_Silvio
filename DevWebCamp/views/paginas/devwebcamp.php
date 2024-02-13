<main class="devwebcamp">
    <h2 class="devwebcamp__heading"><?php echo $titulo; ?></h2>
    <p class="devwebcamp__descripcion">Conoce la conferencia más importante de Latinoamérica</p>

    <div class="devwebcamp__grid">
        <div <?php aos_animacion(); ?> class="devwebcamp__imagen">
            <picture>
                <source srcset="build/img/sobre_devwebcamp.avif" type="image/avif">
                <source srcset="build/img/sobre_devwebcamp.webp" type="image/webp">
                <img loading="lazy" width="200" height="300" src="build/img/sobre_devwebcamp.jpg" alt="Imagen DevWebcamp">
            </picture>
        </div>

        <div  class="devwebcamp__contenido">
            <p <?php aos_animacion(); ?> class="devwebcamp__texto">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc euismod nulla dapibus quam imperdiet interdum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae lacus pellentesque dolor eleifend auctor a molestie ante Vivamus vitae volutpat ipsum. Leo eros semper magna, vel varius magna ligula vel risus. Nunc dui sapien, egestas et porta in, porta id nibh. </p>
            
            <p <?php aos_animacion(); ?> class="devwebcamp__texto">Sed molestie, sapien sit amet dignissim consectetur, nisl orci suscipit ipsum, a volutpat arcu mi ac leo. Morbi volutpat, lorem sit amet placerat malesuada, tellus felis efficitur massa, vitae dictum nunc nibh vel neque. Duis quis viverra odio, ac sollicitudin turpis. Nulla mi est, interdum a orci ac, facilisis dictum tellus. Ut scelerisque felis ut nisl interdum tincidunt. </p>
        </div>
    </div>
</main>