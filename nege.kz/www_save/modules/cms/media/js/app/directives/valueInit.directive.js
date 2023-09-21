angular.module('admin').directive('valueInit', function ($sce) {
    return {
        restrict: 'A',
        scope: {
            ngModel: '='
        },
        compile: function compile(templateElement, templateAttrs, transclude) {
            return {
                pre: function (scope, element, attrs) {
                   scope.ngModel = element.val();
                },
                post: function (scope, element, attrs) {
                }
            }
        }
    }
});
