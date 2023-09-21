<div class="search">
    <form method="get">
        <div class="input-append">
            <?=Form::input($name,Arr::get($_GET,'search_text',$value),array('class'=>'col-lg-4 col-md-4 sol-sm-4'))?>
            <?= Form::submit($btn,$btn_value,array('id'=>$btn, 'class'=>'btn-default'))?>
        </div>


    </form>
</div>