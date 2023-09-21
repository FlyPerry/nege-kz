angular.module('admin').directive('files', function ($uploader) {
    return {
        restrict: 'E',
        replace: false,
        templateUrl: BASE_URL + 'js/app/templates/files.template.html',
        scope: {
            field: '@',
            size: '@',
            items: '@',
            label: '@',
            fileField: '@'
        },

        compile: function compile(templateElement, templateAttrs, transclude) {
            return {
                pre: function (scope, element, attrs) {
                },
                post: function (scope, element, attrs) {

                    scope.fields = element.data('fields');
                    scope.files = element.data('items');
                    var fileInput = element.find('._files_input');
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



                }
            }
        }
    }
});