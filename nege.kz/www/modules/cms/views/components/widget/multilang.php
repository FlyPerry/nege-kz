
    <ul class="nav nav-tabs nav-inverse" id="<?=$prefix?>">
        <?php
            foreach($langs as $lang){

                echo "<li><a href=\"#{$prefix}{$lang}\" data-toggle=\"tab\">Версия сайта: {$lang}</a></li>";
            }
        ?>

    </ul>

    <div class="tab-content">
        <?php
            foreach($langs as $lang){
                ?>

                <div class="tab-pane" id="<?=$prefix?><?=$lang?>">
                    <?foreach($elements[$lang] as $v):?>
                    <?=$v?>
                    <?endforeach;?>
                </div>


                <?php
            }

        ?>



    </div>


    <script type="text/javascript">
        $(function(){
            $("#<?=$id?> a").click(function(e){
                e.preventDefault();
                $(this).tab('show');
            });
            $('#<?=$id?> a:first').tab('show');
        });
    </script>
