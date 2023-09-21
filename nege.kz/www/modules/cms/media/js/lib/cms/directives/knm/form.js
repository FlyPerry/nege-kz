angular.module('knm.ui.dynamic.form',[]).
    controller('ctrlForm',['$scope','Model','ModelInfo',function($scope,Model,ModelInfo){

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
            $scope.embeded = {};
            $scope.select = {};

//            if($scope.model && $scope.model.id){
                angular.forEach($scope.metadata.fields.edit,function(f){

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
                            $scope.select[f] = select4single(f,$scope.metadata.info[f].params.values)
                        }
                        if($scope.metadata.info[f].type==='embeded'){
                            embeded($scope.model,f);
                        }
                    }
                });
//            }



            function roles(model){
                var val = [];
                $scope.relations['roles'] = ['values','options'];
                if(model && model.id){
                    model.rel('roles',null,function(values){
                        angular.forEach(values,function(item){
                            val.push({'key':item.description,'value':item.id});
                        });
                        ($scope.relations['roles'] && $scope.relations['roles']['values']) || (($scope.relations['roles']=['values','options']) && ($scope.relations['roles']['values'] = val));

                    });
                }else{

                    $scope.relations['roles']['values'] = [];
                }

                $scope.relations['roles']['options'] = select4single($scope.metadata.info['roles'].params.options);

            }

            function select_values(model,key){
                if(model && model.id){

                        ($scope.relations[key] && $scope.relations[key]['values']) || (($scope.relations[key] = ['values']) && ($scope.relations[key]['values']=model.rel(key)));
                        ($scope.relations[key] && $scope.relations[key]['options']) || ($scope.relations[key]['options'] = select4single($scope.metadata.info[key].params.options));

                }
            }

            function select4single (values){
                var val = [];
                angular.forEach(values,function(index,value){
                    val.push({'key':index,'value':value});
                });
                return val;
            }

            function embeded(model,key){

                if(model && model.id){
                    $scope.embeded[key] || ($scope.embeded[key]=model.rel(key,null,function(){
                    }));
                    ($scope.embeded[key] && $scope.embeded[key]['metadata']) || ($scope.embeded[key]['metadata'] = ModelInfo.metadata($scope.metadata.hasMany[key].model));
//                    $scope.$emit('$re_init');
                }
            }





        }

        $scope.$on('$re_init',re_init);
        $scope.$watch('model',re_init);
        function re_init(){
             $scope.init(init_val);
        }
        re_init();




    }]).
    directive('dynamicForm',[function(){
        return {
            'replace':true,
            'restrict':'E',
            'template':
                "<form class='form-horizontal'>" +
                    "<div " +
                        "class='control-group' " +
                        "ng-repeat='f in metadata.fields.edit' " + //Перебор редактируемый полей
                        "ng-switch='metadata.info[f].type'" + //Свитч по типу
                        "ng-class='{error:model.errors[f]}'" + //Добавление класса, если ошибка
                    ">" +
                    '<label class="control-label">{{metadata.info[f].label}}</label>' +

                        '<div class="controls" ng-switch-default>' + //Дефолтный тип
                            '<input ng-model="model[f]" type="text" class="span8 {{metadata.info[f].params.class}}">' +
                            '<span class="help-inline">{{model.errors[f]}}</span>'+
                        '</div>'+

                        '<div class="controls" ng-switch-when="span">' + //нередактируемое поле
                        '<span  class="span8 uneditable-input">{{model[f]}}</span>'+
                        '</div>'+


                        '<div class="controls" ng-switch-when="text">' + //Текст
                            '<textarea redactor id="{{f}}" ng-model="model[f]" rows="4" class="editor"></textarea>' +
                            '<span class="help-inline">{{model.errors[f]}}</span>'+
                        '</div>'+

//                        '<div class="controls" ng-switch-when="select">' + //Select
//                            '<select ' +
//                                'ng-model="model[f]" ' +
//                                'ng-options="m[metadata.info[f].params.value] as m[metadata.info[f].params.name] for m in select(f)">' +
//                            '</select>' +
//                            '<span class="help-inline">{{model.errors[f]}}</span>'+
//                        '</div>'+

//                        '<div class="controls" ng-switch-when="multi_select">' + //Multi Select
//                                '<select ' +
//                                'multiple="multiple"' +
//                                'ng-model="model[f]" ' +
//                                'ng-options="m[metadata.info[f].params.value] as m[metadata.info[f].params.name] for m in select_has_many(f)">' +
//                                '</select>' +
//                            '<span class="help-inline">{{model.errors[f]}}</span>'+
//                        '</div>'+
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

                        '<div class="controls" ng-switch-when="matchable">' + //matchable
                            '<dynamic-table collection="embeded[f]" metadata="embeded[f][\'metadata\']"></dynamic-table>'+
                        '</div>'+

                        '<div class="controls" ng-switch-when="embeded">' + //embeded
                            '<dynamic-table collection="embeded[f]" metadata="embeded[f][\'metadata\']"></dynamic-table>'+
                        '</div>'+


                    "</div>" +
                    '<div class="form-actions span10">'+
                        '<btn-group buttons="metadata.buttons.edit"></btn-group>'+
                    '</div>'+
                "</form>",
            'scope':{
                'model':'=',
                'metadata':'=',
                'initval':'='
//
            },
            'controller':'ctrlForm'



};
}]);