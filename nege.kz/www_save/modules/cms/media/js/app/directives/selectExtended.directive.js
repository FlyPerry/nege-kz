angular.module('admin').directive('selectExtended', function ($uploader) {
    return {
        restrict: 'E',
        replace: true,
        require: 'ngModel',
        templateUrl: BASE_URL + 'js/app/templates/selectExtended.template.html',
        scope: {
            field: '@',
            error: '@',
            label: '@',
            values: '=',
            disabled: '@',
            val: '='
        },

        compile: function compile(templateElement, templateAttrs, transclude) {
            var items = JSON.parse(templateAttrs.options);
            var values = JSON.parse(templateAttrs.val);
            return {
                pre: function (scope, element, attrs) {
                },
                post: function (scope, element, attrs, ngModel) {
                    scope.values = values;
                    scope.options = items;
                    scope.check = function (id) {
                        return scope.values.indexOf(Number(id)) == -1
                    };
                    scope.selectItem = function (id) {
                        if (typeof scope.values != 'object') {
                            scope.values = [];
                        }
                        scope.values.push(Number(id));
                    };
                    scope.removeItem = function (id) {
                        if (!scope.disabled) {
                            scope.values.splice(scope.values.indexOf(Number(id)), 1)
                        }
                    }
                }
            }
        }
    }
});