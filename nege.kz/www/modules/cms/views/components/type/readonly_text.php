
    <label for="<?=$field?>" class="control-label"><?=__($label).(Arr::get($params,'need_help')?View::factory('components/help',array('model'=>$model->object_name(),'field'=>$field)):null)?></label>

    <div class="controls">
         <p style="padding-top: 5px;"><?=$params['value']?></p>
        <span class="help-inline"><?=$error?></span>
    </div>
