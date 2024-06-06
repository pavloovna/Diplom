<?php if (count($errMassage) > 0) : ?>
    <ul>
        <?php foreach ($errMassage as $error) : ?>
            <li><?= $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>