$(function(){
    //$.material.options.autofill = true;
    $.material.init();
    var redactor_buttons = ['html', '|', 'formatting', '|', 'bold', 'italic','|', 'deleted', '|',
        'unorderedlist','|', 'orderedlist', 'outdent', 'indent', '|',
        'image', '|', 'video','|', 'file', 'table', 'link', '|',
        'fontcolor', '|','backcolor', '|', 'alignment', 'aligncenter', 'alignright', '|'];

    var redactor_opt =
    {
        imageUpload: BASE_URL+'admin/panel/image_upload',
        fileUpload: BASE_URL+'admin/panel/file_upload',
        lang: 'ru',
        toolbarFixed: true,
        convertDivs: false,
        buttons: redactor_buttons,
        imageUploadCallback: function(obj, json) {
            if (!json.filelink){
                alert(json.filename);

            }
        },
        fileUploadCallback: function(obj, json) {
            if (!json.filelink){
                alert(json.filename);

            }
        }
    };
    $(document).on('click', 'input[name="delete"]', function (e) {

        if (!confirm('Подтвердите удаление выбранных элементов')) {
            e.preventDefault();
        }
    });

    $(document).on('click', 'input.check-all', function (e) {
        var self = $(this);
        self.parents('table').find('input[type="checkbox"]').not('.check-all').prop('checked', self.is(':checked'));
    });

    $('.modal-select, .embeded-edit').on('click','.pagination a,form .accordion a.btn',function(e){
        e.preventDefault();
        var self = $(this);
        var parent=self.parents('.modal-body, .embeded-edit');
//        var options={'remote':self.attr('href')};

        parent.load(self.attr('href'));
    });

    $('.modal-select, .embeded-edit').on('click','input[type="submit"]',function(e){
        e.preventDefault();
        e.stopPropagation();
        var self=$(this);
        var form=self.parents('form');
        var parent=self.parents('.modal-body, .embeded-edit');
        var me={};
        me[self.attr('name')]=self.attr('value');
        var q=form.serialize() + '&'+ $.param(me);
        if (form.attr('method')=='post'){
            $.post(form.attr('action'),q,function(data){
                parent.html(data);
            })
        } else {
            parent.load(self.attr('action')+'?'+q);
        }
    });

    $('.embeded-edit').each(function(){
        var self = $(this);
        var src=self.attr('data-src');
        self.load(src);
    });


});

var admin = angular.module('admin', []);