
    <ul class="nav nav-tabs" id="<?=$prefix?>">
        <?php
            $lang_tabs=Components_Widget_Partial::$langs;
            foreach($langs as $lang){

                echo "<li><a href=\"#{$prefix}{$lang}\" data-toggle=\"tab\">{$lang_tabs[$lang]}</a></li>";
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
