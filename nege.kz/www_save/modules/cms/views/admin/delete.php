<div class="row well">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h4><?=__('Вы уверены что хотите удалить элемент').'?'?></h4>
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
            <form method="post" action="">
                <?php
                $cp = Component::factory();
                $cp->form_button_save('save',__('Да'), array('class'=>'btn btn-cancel btn-raised'));
                $cp->form_button_save('cancel',__('Нет'), array('class'=>'btn btn-success btn-raised'));
                echo $cp->render();
                ?>
            </form>
        </div>
    </div>
</div>