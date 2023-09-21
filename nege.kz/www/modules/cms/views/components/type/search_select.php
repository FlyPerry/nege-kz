<div class="form-group">
    <label for="<?=$field?>" class="control-label"><?=$label?></label>
    <div>
        <select id="<?=$field?>" name="<?=$field?>" class="form-control">
            <?foreach(array(null=> __('Не выбрано')) + $params['options'] as $id=>$row):?>
                <option <?=$id===$value?"SELECTED":""?> value="<?=$id?>"><?=$row?></option>
            <?endforeach?>
        </select>
    </div>
    <span class="material-input"></span>
</div>
