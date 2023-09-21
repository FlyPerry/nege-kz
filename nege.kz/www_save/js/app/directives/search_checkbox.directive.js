angular.module('admin').directive('searchCheckbox', function () {
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
                    if(!Number.isInteger(scope.val) && !scope.value){
                        scope.value = null;
                    }
                    else {
                        scope.value = scope.val;
                    }
                    console.log(scope.label,scope.model,scope.val,scope.value);
                    scope.model = scope.value;
                },
                post: function (scope, element, attrs) {
                    scope.check = function () {
                        scope.value = Math.abs(scope.value - 1);
                        if(!scope.value){
                            scope.model = '';
                        }

                    };
                    $.material.checkbox();
                }
            }
        }
    }
});
