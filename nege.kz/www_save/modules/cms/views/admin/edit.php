<?php
/**
 * @var $model ORM
 */
//echo Form::open(null,array('class'=>'form-horizontal'));
//$cp = Component::factory();
//$outer = Component::factory('components/plain');
$cp_blocks = array();
$cp_outer_blocks = array();
?>

<?
$main = Arr::get($model::$_model_blocks,'main');
$rt = Arr::get($model::$_model_blocks,'rt');
$rb = Arr::get($model::$_model_blocks,'rb');
foreach($main as $bl => $i)
{
    $cp_blocks[$bl] = Component::factory('components/plain');
    $cp_outer_blocks[$bl] = Component::factory('components/plain');
};
foreach($rt as $bl => $i)
{
    $cp_blocks[$bl] = Component::factory('components/plain');
    $cp_outer_blocks[$bl] = Component::factory('components/plain');
};
foreach($rb as $bl => $i)
{
    $cp_blocks[$bl] = Component::factory('components/plain');
    $cp_outer_blocks[$bl] = Component::factory('components/plain');
};
?>
<?=Form::open(null,array('ng-controller'=>ucfirst($model->object_name()).'Controller'))?>
<div class="row">

    <?if(count($model::$_model_langs)):?>
        <?if($model instanceof IC_Translatable):?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3><?=$model->loaded()?"Редактировать":"Создать"?> <?=strtolower($model->edit_title())?></h3>
            </div>
        <?else:?>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <h3><?=$model->loaded()?"Редактировать":"Создать"?> <?=strtolower($model->edit_title())?></h3>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="btn-group btn-group-justified btn-group-raised" data-toggle="buttons">
                    <?foreach($model::$_model_langs as $i=>$lang):?>
                        <label class="lang_select_label btn <?=$model->lang==$i?"active btn-raised btn-primary":""?>">
                            <input class="lang_select" type="radio" name="model[lang]" value="<?=$i?>" autocomplete="off" <?=$model->lang==$i?"checked":""?>><?=$lang?>
                        </label>
                    <?endforeach?>
                </div>
            </div>
        <?endif?>
    <?else:?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><?=$model->loaded()?"Редактировать":"Создать"?> <?=strtolower($model->edit_title())?></h3>
        </div>
    <?endif?>


</div>
<div class="row">
    <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
        <?foreach($main as $block=>$values):?>
            <div class="panel panel-default">
                <div class="panel-heading" id="heading_<?=$block?>"><a role="button" data-toggle="collapse" aria-expanded="<?=Arr::get($values,'hidden',false)?"false":"true"?>" aria-controls="<?=$block?>" href="#<?=$block?>"><?=Arr::get($values,'title')?></a></div>
                <div id="<?=$block?>" class="panel-collapse collapse <?=Arr::get($values,'hidden',false)?"":"in"?>" role="tabpanel" aria-labelledby="heading_<?=$block?>">
                    <div class="panel-body">
                        <?foreach($fields as $field=>$info):?>
                            <?if($field!='lang'):?>
                                <?if(Arr::get($info,'block')==$block):?>
                                    <?
//                            $cp = Component::factory();
                                    if (Arr::get($info, 'edit') && (!Arr::get($info, 'loaded', false) || $model->loaded())) {
                                        $call = $info['type'];
                                        if ($call == 'embeded') {
                                            $cp_outer_blocks[$block]->$call($info['label'], $model, $field, Arr::get($info, 'params'));
                                        } else {
//                                    echo $cp->$call($info['label'], $model, $field, Arr::get($info, 'params'));
                                            $cp_blocks[$block]->$call($info['label'], $model, $field, Arr::get($info, 'params'));
                                        }
                                    }
                                    ?>
                                <?endif?>
                            <?endif?>
                        <?endforeach?>
                        <?=$cp_blocks[$block]->render()?>
                        <?=$cp_outer_blocks[$block]->render()?>
                    </div>
                </div>
            </div>
        <?endforeach?>
    </div>
    <div id="right_block" class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
        <!--        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 add-news">-->
        <!--            <button type="button" class="btn btn-outline btn-default">Просмотреть страницу</button>-->
        <!--        </div>-->
        <div class="form-group">


            <?
            $cp = Component::factory('components/plain');

            $cp->form_button_save();
            $cp->form_button_save('cancel', "Назад");
            $cp->form_button_save_and_resume();
            $ref = new ReflectionClass($model);
            if($model->loaded() && Authority::can('view',$model->object_name())) $cp->button_link(Site::domain() .str_replace('cp/', '/', $model->view_url(true)), __('Просмотр'), array('class' => 'btn btn-info btn-raised', 'target' => '_blank'));
            if($model->loaded() && Authority::can('delete',$model->object_name())) $cp->button_link($model->delete_url(true), __('Удалить'), array('class' => 'btn btn-danger btn-raised'));
            if ($ref->hasMethod('form_button')) {
                $model->form_button($cp);
            }

            echo $cp->render();
            ?>
        </div>
        <?foreach($rt as $block=>$values):?>
            <div class="panel panel-default">
                <div class="panel-heading" id="heading_<?=$block?>"><a role="button" data-toggle="collapse" aria-expanded="<?=(Arr::get($values,'hidden',false))?"false":"true"?>" aria-controls="<?=$block?>" href="#<?=$block?>"><?=Arr::get($values,'title')?></a></div>
                <div id="<?=$block?>" class="panel-collapse collapse <?=(Arr::get($values,'hidden',false))?"":"in"?>" role="tabpanel" aria-labelledby="heading_<?=$block?>">
                    <div class="panel-body">

                        <?foreach($fields as $field=>$info):?>
                            <?if($field!='lang'):?>
                                <?if(Arr::get($info,'block')==$block):?>
                                    <?
//                            $cp = Component::factory();
                                    if (Arr::get($info, 'edit') && (!Arr::get($info, 'loaded', false) || $model->loaded())) {
                                        $call = $info['type'];
                                        if ($call == 'embeded') {
                                            $cp_outer_blocks[$block]->$call($info['label'], $model, $field, Arr::get($info, 'params'));
                                        } else {
                                            $cp_blocks[$block]->$call($info['label'], $model, $field, Arr::get($info, 'params'));
                                        }
                                    }
                                    ?>
                                <?endif?>
                            <?endif?>
                        <?endforeach?>
                        <?=$cp_blocks[$block]->render()?>
                        <?=$cp_outer_blocks[$block]->render()?>
                    </div>
                </div>
            </div>
        <?endforeach?>


    </div>
</div>


<?=Form::close()?>
<?if(!$ng_controller):?>
    <script>
        admin.controller('<?=ucfirst($model->object_name())?>Controller', ['$scope', function($scope) {

        }]);
    </script>
<?endif?>
<script>
    $(".lang_select").on("change",function(){
        $(".lang_select_label").removeClass("btn-raised btn-primary");
        $(this).parent("label").addClass("btn-raised btn-primary");
    });

</script>
<?

//echo $cp->render();
//echo $outer->render();
//echo Form::close();
?>
