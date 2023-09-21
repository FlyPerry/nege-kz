angular.module('knm.ui.dynamic.form.search',[]).
    controller('ctrlSearch',['$scope','Model',function($scope,Model){
        $scope.relations = {};
        $scope.embeded = {};
        $scope.select = {};

        var init_val = $scope.initval;


        $scope.init = function(init_val){

            init_val = init_val || {};


            /*Основная функция работы контроллера формы, принимает объект инициализации $scope.initval
             *передаваемый в директиву формы
             *объект инициализации должен иметь структуру:
             *{
             *    'matchable': { название поля модели
             *        'container': 'embeded', контейнер, в котором форма будет хранить значения
             *        'data': function (model, metadata,callback) { функция, которая вернет значение в контейнер
             *           var values = [];
             *           if (model && model.id) {
             *              var rel = metadata &&
             *                   metadata.hasMany &&
             *                    metadata.hasMany['matchable'];
             *                values = Model(rel.model).query({'method': 'matchable', 'params': model.id, 'project': model.domain_id});
             *                values['metadata'] = ModelInfo.metadata(metadata.hasMany['matchable'].model);
             *
             *           }
             *        callback(values);
             *        }
             *    }
             *}
             * */
            $scope.relations = {};

            $scope.select = {};


                angular.forEach($scope.metadata.fields.search,function(f){

                    if(f in init_val){
                        init_val[f].data($scope.model,$scope.metadata,function(data){
                            $scope[init_val[f].container][f] = data;
                        });

                    }else{
                        if($scope.metadata.info[f].type==='multi_select' && f=='roles'){
                            roles($scope.model);
                        }else if($scope.metadata.info[f].type==='multi_select'){
                            select_values($scope.model,f);
                        }
                        if($scope.metadata.info[f].type==='select'){
                            $scope.select[f] = select4single($scope.metadata.info[f].params.values)

                        }

                    }
                });




            function roles(model){


                    $scope.relations['roles'] = ['values','options'];
                    $scope.relations['roles']['values'] = [];

                $scope.relations['roles']['options'] = select4single($scope.metadata.info['roles'].params.options);

            }

            function select_values(model,key){
                if(model && model.id){
                    if(key=='roles'){
                        roles(model);
                    }
                    else{
                        ($scope.relations[key] && $scope.relations[key]['values']) || (($scope.relations[key] = ['values']) && ($scope.relations[key]['values']=model.rel(key)));
                        ($scope.relations[key] && $scope.relations[key]['options']) || ($scope.relations[key]['options'] = select4single($scope.metadata.info[key].params.options));
                    }
                }
            }

            function select4single (values){
                var val = [];
                angular.forEach(values,function(index,value){
                    val.push({'key':index,'value':value});
                });
                return val;
            }







        }

        $scope.$on('$re_init',re_init);
        $scope.$watch('model',re_init);
        function re_init(){
            $scope.init(init_val);
        }
        re_init();




    }]).
    directive('dynamicFormSearch',[function(){
        return {
            'replace':true,
            'restrict':'E',
            'template':
                '<form>' +
                    '<div class="control-group" ng-repeat="f in metadata.fields.search" ng-switch="metadata.info[f].type">' +
                    '   <label class="control-label">{{metadata.labels[f]}}</label>' +

                    '   <div class="controls" ng-switch-default>' +
                    '       <input type="text" ng-model="model[f]" class="span10">' +
                    '   </div>' +



                    '<div class="controls" ng-switch-when="multi_select">' + //Multi Select
                    '<select-extended ' +
                    'options="relations[f][\'options\']" ' +
                    'values="relations[f][\'values\']" ' +
                    'ng-model="model[f]" '+
                    'field="f">' +
                    '</select-extended>' +
                    '<span class="help-inline">{{model.errors[f]}}</span>'+
                    '</div>'+


                    '<div class="controls" ng-switch-when="select">' + //Select value
                    '<select ' +
                    'ng-model="model[f]" ' +
                    'ng-options="m.value as m.key for m in select[f]">' +
                    '</select>' +
                    '<span class="help-inline">{{model.errors[f]}}</span>'+
                    '</div>'+

                    '</div>' +



                    '<div class="form-actions span10">'+
                        '<btn-group buttons="metadata.buttons.search"></btn-group>'+
                    '</div>'+
                '</form>',
            'controller':'ctrlSearch',
            'scope':{
                'model':'=',
                'metadata':'=',
                'buttons':'=',
                'init_val':'='
            }
        };
    }]);