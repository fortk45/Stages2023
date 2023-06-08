<!-- Mise en place du système d'apparition des messages d'erreurs s'il y en a -->
<?php  if (count($errors) > 0) : ?>
    <div class="msg">
        <?php foreach ($errors as $error) : ?>
            <span><?php echo $error ?></span>
        <?php endforeach ?>
    </div>
<?php  endif ?>