if (typeof RedactorPlugins === 'undefined') var RedactorPlugins = {};

RedactorPlugins.spoiler = {

    init: function()
    {
        this.addBtnAfter('link', 'spoiler', 'Создать спойлер', function(obj)
        {
            obj.setBuffer();

            var name_class = 'spoiler_text';
            var button = obj.getBtn('spoiler');
            var cur_node = obj.getCurrentNode();
            var node = obj.getParentNode();

            var html = obj.getSelectedHtml();




            if($(cur_node).parents('.spoiler').length > 0)
            {
                var spoiler = $(cur_node).parents('.spoiler');
                var text = spoiler.find('.spoiler_text').html();
                spoiler.remove();
                obj.insertHtml(text);
            }
            else
            {
                if(html.length > 0)
                {
                    obj.insertHtml('<div class="spoiler"><a class="spoiler_name" href="return false;">Нажмите что бы посмотреть полностью.</a><i class="spoiler_show spoiler_down"></i><div class="'+name_class+'">'+html+'</div></div><p>&nbsp</p>');
                    var spoiler = $(node).parentNode.find('.spoiler');
                    obj.setFocusNode(spoiler.siblings(':first'));
                }
            }
        });

        this.addBtnSeparatorBefore('spoiler');
    }
}