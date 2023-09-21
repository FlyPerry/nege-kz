<?php
/**
 * Данный компонент требует jQuery 1.7 + и Twitter Bootstrap JavaScript
 * @$params['options'] должен создержать uri до экшена с данными
 * $params['value'] содержит список уже установленных значений
 *
 */

$size = Arr::get($params, 'size', 10);
?>
<div class="control-group <?=$error ? 'error' : ''?>">
    <label for="<?=$field?>" class="control-label"><?=__($label)?></label>

    <div class="controls">
        <?php
        $attr = Arr::get($params, 'attr', array());
        $attr = array_merge($attr, array(
            'id' => $field,
            'class' => 'span4',
            'data-src' => $params['options']
        ));
        ?>
        <?=Form::input("typeahead[$field]", "", $attr)?>

        <?php
        foreach ($params['value'] as $key => $value) {
            echo "<p class='single-value'>";
//                echo Form::hidden("model[$field][$key][key]",$key);
            echo Form::hidden("model[$field]", $value ? $value : $key);
            echo '<span class="help-inline">'.$key.' <a href="#delete"><i class="icon-remove"></i></a></span>';
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
            var label = $('<span class="help-inline">' + name + ' <a href="#delete"><i class="icon-remove"></i></a></span>');
            var p = $('<p class="single-value"></p>');
            p.append(value).append(label);
            target.siblings('.single-value').remove();
            p.insertAfter(target);
        }
        var target = $('input[name="typeahead[' + f + ']"]');
        target.typeahead({
            source:function (query, callback) {
                var src = target.attr('data-src');
                $.getJSON(src, {query:query}, function (data) {
                    var clear = [];
                    items = {};
                    for (var i in data) {
                        var item = data[i];
                        items[item.name] = item.id;
                        clear.push(item.name);
                    }
                    callback(clear)
                });
            },
            updater:function (el) {
                var id = items[el];
                create(el, target, id);
            }


        });


        target.parent().on('click', 'p a[href="#delete"]', function (e) {
            e.preventDefault();
            $(this).parents('p').remove();
        });
    });
</script>