angular.module('admin').directive('textEditor', function () {
    return {
        restrict: 'A',
        compile: function compile(templateElement, templateAttrs, transclude) {
            return {
                pre: function (scope, element, attrs) {
                },
                post: function (scope, element, attrs) {

                    CKEDITOR.inline(attrs.id,{
                        filebrowserUploadUrl: BASE_URL + 'admin_panel/ck_file_upload',
                        uiColor: '#FAFAFA',
                        allowedContent: true
                    }, function () {
                        var _this = this;
                        this.on('change', function () {
                            _this.updateElement();
                            element.change();
                        });
                    });
                    //element.ckeditor();
                }
            }
        }
    }
});
