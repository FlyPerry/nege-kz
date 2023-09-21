angular.module('admin').directive('checkbox', function () {
    return {
        restrict: 'E',
        templateUrl: BASE_URL + 'js/app/templates/checkbox.template.html',
        scope: {
            val: '@',
            field: '@',
            defaultChecked: '@',
            model: '=',
            label: '@',
            error: '@',
            checkboxDisabled: '@'
        },
        compile: function compile(templateElement, templateAttrs, transclude) {
            return {
                pre: function (scope, element, attrs) {
                    scope.val = parseInt(scope.val);
                    if ((!Number.isInteger(scope.val) && Number(scope.defaultChecked))) {
                        scope.value = 1;
                    }
                    else if(!Number.isInteger(scope.val)) {
                        scope.value = 0;
                    }else{
                        scope.value = scope.val;
                    }
                    scope.model = scope.value;
                },
                post: function (scope, element, attrs) {
                    scope.check = function () {
                        scope.value = Math.abs(scope.value - 1);
                        scope.model = scope.value;
                    };
                    $.material.checkbox();
                }
            }
        }
    }
});
