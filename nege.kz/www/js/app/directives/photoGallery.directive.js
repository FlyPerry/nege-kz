angular.module('admin').directive('photoGallery', function ($uploader) {
    return {
        restrict: 'E',
        replace: false,
        templateUrl: BASE_URL + 'js/app/templates/photoGallery.template.html',
        scope: {
            field: '@',
            size: '@',
            items: '@',
            label: '@',
            imageField: '@',
            aspect: '@'
        },

        compile: function compile(templateElement, templateAttrs, transclude) {
            return {
                pre: function (scope, element, attrs) {
                },
                post: function (scope, element, attrs) {
                    $.material.checkbox(element.find('input[type=checkbox]'));
                    scope.watermark = false;
                    scope.fields = element.data('fields');
                    scope.files = element.data('items');
                    var fileInput = element.find('input[type=file]');
                    scope.hidden_fields = element.data('hidden-fields');

                    scope.remove = function (item) {
                        scope.files.splice(scope.files.indexOf(item), 1);
                    };

                    scope.openFileDialog = function () {
                        fileInput.click();
                    };

                    fileInput.change(function (e) {
                        scope.$apply(function () {
                            scope.files = Array.prototype.concat(scope.files, [].slice.call(e.target.files));
                        });
                    });
                    scope.openUrlUploadDialog = function () {
                        element.find('.url-list-modal').modal('show');
                    };

                    scope.urlUpload = function (urls) {
                        scope._url = null;
                        urls.split('\n').map(function (item) {
                            scope.files.push({uploadUrl: item});
                        });
                        element.find('.url-list-modal').modal('hide');
                    };
                }
            }
        }
    }
});