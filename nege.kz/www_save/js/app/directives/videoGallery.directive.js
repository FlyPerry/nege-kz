angular.module('admin').directive('videoGallery', function () {
    return {
        restrict: 'E',
        replace: false,
        templateUrl: BASE_URL + 'js/app/templates/videoGallery.template.html',
        scope: {
            field: '@',
            size: '@',
            items: '@',
            label: '@',
            imageField: '@'
        },

        compile: function compile(templateElement, templateAttrs, transclude) {
            return {
                pre: function (scope, element, attrs) {
                },
                post: function (scope, element, attrs) {
                    scope.fields = element.data('fields');
                    scope.files = element.data('items');
                    scope.hidden_fields = element.data('hidden-fields');


                    scope.remove = function (item) {
                        console.log(scope.files);
                        console.log(item);
                        console.log(scope.files.indexOf(item));
                        scope.files.splice(item, 1);
                    };

                    scope.add = function () {
                        var object = {};
                        object[scope.field] = null;
                        scope.files.push(object);
                    };


                }
            }
        }
    }
});