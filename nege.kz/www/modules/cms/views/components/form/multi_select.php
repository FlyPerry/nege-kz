<div class="form-group">
    <label for="<?=$name?>" class="control-label"><?=$label?></label>

    <div class="controls">
        <?=Form::select($name,$options,$selected,array(
        'id'=>$name,
        'multiple'=>'multiple',
        'size'=>$size,
        'class'=>'col-sm-4 col-md-4'
    ))?>
        <div class="err"><?=$error?></div>
    </div>
</div>