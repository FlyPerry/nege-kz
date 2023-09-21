<div class="control-group <?=$error ? 'error' : ''?>">
    <?=Form::label($field, __($label),array('class'=>'control-label'))?>


    <?php
    $attr = Arr::get($params, 'attr', array());
    $attr = $attr + array(
            'id' => $field,
            'class' => 'span8'
        );
    $key=Arr::get($params,'key','id');
    $title=Arr::get($params,'title','title');

    $values=Arr::get($params,'values',$model->$field->select_options($title,$key));
    $src=Arr::get($params,'src',$model->$field->external_list());
    ?>
    <div class="controls">
        <a id="<?=$field?>" data-toggle="modal" href="<?=$src?>" data-target="#modalSelect">Добавить <i class="icon-edit"></i></a>
        <?php
        foreach ($values as $key => $value) {
            echo "<p class='single-value'>";
            echo Form::hidden("model[$field][]", $value ? $value : $key);
            echo '<span class="alert alert-success">'.strip_tags($key).' <a href="#delete"><i class="icon-remove"></i></a></span>';
            echo "</p>";
        }
        ?>
        <span class="help-inline"><?=$error?></span>
    </div>
</div>



<script type="text/javascript">

    $(function () {
        var f = "<?=$field?>";
        var items = {};
        var create = function (name, target, id) {
            var value = $('<input type="hidden" />');
            value.attr('name', 'model[' + f + '][]');
            if (id) {
                value.attr('value', id);
            } else {
                value.attr('value', name);
            }
            var label = $('<span class="alert alert-success">' + name + ' <a href="#delete"><i class="icon-remove"></i></a></span>');
            var p = $('<p class="single-value"></p>');
            p.append(value);
            if(value.val()!=0){
                p.append(label);
            }
//            target.siblings('.single-value').remove();
//            target.hide();
            p.insertAfter(target);
        }
        var target = $('a#' + f );
        if (target.siblings('.single-value').length>0){
//            target.hide();
        }

        target.on('click',function(){
            $('body').one('click','#modalSelect table a.select',function(e){
                e.preventDefault();
                var self=$(this);
                var id = self.attr('data-id');
                if (target.parent().find('input[value="'+id+'"]').length==0){
                    create(self.attr('data-title'),target, id);
                }
                $('#modalSelect').modal('hide');
            });
            var modalBody = $('#modalSelect .modal-body');
            if (modalBody.text()!=''){
                modalBody.load(target.attr('href'));
            }
            $('#modalSelect').one('hidden',function(){
                $('body').off('click','#modalSelect table a.select');
            })
        });

        target.parent().on('click', '.single-value a[href="#delete"]', function (e) {
            e.preventDefault();
            $(this).parents('.single-value').remove();
            create(0, target, null);
//            target.show();
        });
    });
</script>