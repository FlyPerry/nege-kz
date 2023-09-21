function setImg(field,url,id)
{
    if (id!='')
    {
        //var $parent=$(document);
        $('.storage#'+field).find('input[name="model['+field+']"]').val(id);
        var pre=$('.storage#'+field).find('img');
        if (pre.length>0)
        {
            if (pre.data('Jcrop'))
            {
                pre.data('Jcrop').destroy();
            }
            var img=$('<img src="'+url+'"/>');
            img.attr('data-src',url);
            pre.after(img);
            pre.remove();
        } else {
            var pre=$('.storage#'+field).find('.thumbnail');
            var img=$('<img src="'+url+'"/>');
            img.attr('data-src',url);
            pre.empty();
            pre.append(img);
        }

    };
}

function setFile(field,url,id,type)
{
    if (id!='')
    {
        //var $parent=$(document);
        $('.storage#'+field).find('input[name="model['+field+']"]').val(id);
        var pre=$('.storage#'+field).find('.preview');
        pre.empty();
        var link=$('<a href="'+url+'" class="btn">Скачать</a>');
        pre.append(link);

    };
}

function getStorageId(field)
{
    return  $('.storage#'+field+' input.'+field).val();
}

function closeFileBrowser(){
    $('#storage').modal('hide');
}

function openFileBrowser(){
    $('#storage').modal('show');
}

$(function()
{
    $(document).delegate('.storage a.edit','click',
        function(e){
            e.preventDefault();

            //   if ($.browser.msie) window.open(this.href,null,'Загрузка файла',"top="+e.screenY+", left="+e.screenX+",width=250, height=100, toolbar=0, directories=0, status=1, menubar=0, modal=1, scrollbars=0");
//            window.open(this.href,'',"top="+e.screenY+", left="+e.screenX+",width=300, height=150, toolbar=0, directories=0, status=1, menubar=0, modal=1, scrollbars=0")
            var $this = $(this);
            $('#fileBrowser')
                .get(0)
                .contentWindow
                .open({
                field:$this.attr('data-field'),
                title:$this.attr('data-title'),
                type:$this.attr('data-type')
            });

        }
    );

    $(document).delegate('.storage a.delete','click',
        function(e){
            e.preventDefault();
            var $parent=$(this).parents('.storage');
            $('input[name="model['+$parent.attr('id')+']"]').val('');
            $parent.find('.preview').html('<span class="help-inline">Поле очещено от файла, сохраните измениня<span>');
        }
    );

});