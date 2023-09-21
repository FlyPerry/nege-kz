<form class="form-horizontal" method="post">
    <?php

    foreach ($elements as $el) {
        echo $el;
    }

    ?>

    <div class="form-actions btn-group">
        <?php

        foreach ($buttons as $el) {
            echo $el;
        }

        ?>
    </div>

</form>