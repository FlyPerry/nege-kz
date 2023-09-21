angular.module('knm.ui.dynamic.table',[]).
    controller('tableController',['$scope',function($scope){
        $scope.isCheckAll=false;
//        $scope.check=function(m){
//            m.isChecked=!m.isChecked;
//        };
        $scope.checkAll=function(){
            angular.forEach($scope.collection,function(m){
                m.isChecked=$scope.isCheckAll;
            });
        };
        $scope.$watch('isCheckAll',$scope.checkAll);
    }]).
    directive('dynamicTable',['$compile',function($compile){
        return {
            'restrict':'E',
            'replace':true,
            'scope':{
                'collection':'=',
                'metadata':'='
            },
            'controller':'tableController',
            'template':
            '<table class="table table-hover table-striped">' +
                '<thead>' +
                '<tr>' +
                    '<th>' +
                        '<input type="checkbox" class="check-all" ng-model="isCheckAll" value="1">' +
                    '</th>' +
                    '<th>&nbsp;</th>' +
                    '<th ng-repeat="f in metadata.fields.list">' +
                        '{{metadata.labels[f]}}' +
                    '</th>' +

                '</tr>' +
                '</thead>' +
                '<tbody>' +
                    '<tr ng-repeat="m in collection">' +
                        '<td><input type="checkbox" value="1" ng-model="m.isChecked"></td>' +

                        '<td>' +
                            '<div class="btn-group">' +
                            '<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">' +
                                '<i class="icon-pencil"></i>' +
                            '</a>' +
                            '<drop-down-menu items="metadata.actions" model="m"></drop-down-menu>' +
                            '</div>' +
                        '</td>' +
                        '<td ng-repeat="f in metadata.fields.list" ng-bind-html-unsafe="m[f]"></td>' +
                '</tbody>' +
            '</table>'

        };
    }]);