<?php
/**
 * Данный компонент требует jQuery 1.7 + и Twitter Bootstrap JavaScript
 * @$params['options'] должен создержать uri до экшена с данными
 * $params['value'] содержит список уже установленных значений
 *
 */

$size = Arr::get($params, 'size', 10);
?>
<div class="group-checkbox-list <?=$error ? 'error' : ''?>">




        <ul class="vlist">


            <?foreach (Arr::get($params, 'options') as $key => $value): ?>
            <li class="first_item accordion_na">
                <span><strong><?=$value?></strong></span>
                <ul>
                    <li>
                        <?php
                        $attr = Arr::get($params, 'attr', array());
                        $attr = array_merge($attr, array(
                            'id' => 'id_' . $key,
                            'class' => 'span4',
                            'type' => 'checkbox',
                            'rel'=>'root'

                        ));
                        ?>
                        <?$check=false?>
                        <?if (array_key_exists($key, Arr::get($params, 'value'))) {
                        $check = true;
                        $attr = array_merge($attr, array(
                            'checked' => 'checked'
                        ));
                    }
                        ?>

                        <label for="id_<?=$key?>" class="check-all  custom-checkbox <?=($check)?"checked":''?>">
                            <?=Form::input("model[$field][]", $key, $attr)?>
                            <?=$value?>
                        </label>
                        <?if (Arr::get($params, 'model') && ORM::factory(Arr::get($params, 'model'), $key)->children->reset(false)->count_all()): ?>
                        <?$rel=$key?>
                        <ul class="vlist">


                            <?foreach (ORM::factory(Arr::get($params, 'model'), $key)->children->lang()->reset(false)->find_all()->as_array('id', 'title') as $key => $value): ?>
                            <li>
                                <?php
                                $attr = Arr::get($params, 'attr', array());
                                $attr = array_merge($attr, array(
                                    'id' => 'id_' . $key,
                                    'class' => 'span4',
                                    'type' => 'checkbox',
                                    'rel'=>'id_'.$rel

                                ));
                                ?>
                                <?
                                $check=false;
                                $model = ORM::factory('category',$key);
                                $val = ($model->lang_root)?$model->lang_root:$key;
                                ?>
                                <?if (array_key_exists($val, Arr::get($params, 'value'))) {
                                $check = true;
                                $attr = array_merge($attr, array(
                                    'checked' => 'checked'
                                ));
                            }
                                ?>
                                <label for="id_<?=$key?>" class="custom-checkbox <?=($check)?"checked":''?>">
                                    <?=Form::input("model[$field][]", $val, $attr)?>
                                    <?=$value?>
                                </label>
                            </li>
                            <? endforeach?>
                        </ul>
                        <? endif?>
                    </li>
                </ul>

            </li>
            <? endforeach?>
        </ul>
        <span class="help-inline"><?=$error?></span>
</div>
<script type="text/javascript">

    $(function () {
        $('[type="checkbox"]').bind('click',function(){
            var self = $(this);
            if(self.attr('rel')=='root'){
                if(self.attr('checked')){
                    $('[rel="'+self.attr('id')+'"]').attr('checked','checked');
                    $('[rel="'+self.attr('id')+'"]').parent().addClass('checked')

                }else{
                    $('[rel="'+self.attr('id')+'"]').parent().removeClass('checked')
                    $('[rel="'+self.attr('id')+'"]').attr('checked',null);
                }
            }
            if(self.is(":checked"))
                self.parent().addClass('checked');
            else
                self.parent().removeClass('checked');;

        });
    });
</script>