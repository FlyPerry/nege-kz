angular.module('knm.model',['ngResource'])
.factory('Model',['$resource','Metadata',function($resource,metadata){
        var models={};
        var metadatas={};

        function ensure(obj, name, factory) {
            return obj[name] || (obj[name] = factory(name));
        }

        function modelFactory(name){
            var md=ensure(metadatas,name,metadata.factory);
            return $resource(md.url,md.paramDefaults,md.actions);
        }

        return function(model){
            return ensure(models,model,modelFactory);
        }
}])
.provider('Metadata',function(){
    var instance={};

    instance.metadata={}; //Метаданные для генерации фабрики
    instance.metadata.defaults={
        'editRoles':[],
        'listRoles':[],
        'url':BASE_URL+'admin/api/',
        'paramDefaults':{'id':'@id'},
        'actions':{
            'metadata':{'method':'get','params':{'method':'metadata'}},
            'countAll':{'method':'get','params':{'method':'countAll'}}
        }
    };
    instance.factory=function(name){
        return instance.metadata[name] || (instance.metadata[name]=instance.describe(name));
    };
    instance.describe=function(name,actions,paramDefaults){
        actions=actions || {};
        paramDefaults=paramDefaults || {};
        instance.metadata[name]=angular.copy(instance.metadata.defaults);
        instance.metadata[name].url+=name+'/:id';
        angular.extend(instance.metadata[name].paramDefaults,paramDefaults);
        angular.extend(instance.metadata[name].actions,actions);
        return instance.metadata[name];
    };

    this.configure=function(){
        return instance;
    };

    this.$get=function(){
        return instance;
    };
})
.factory('ModelInfo',["Model",function(Model){
    var metadata={}; //Серверные метаданные
    var instance={};
    //Получает метаданные с сервера
    instance.metadata=function(className,callback){
        if (metadata[className]){
            (callback || angular.noop)(metadata[className]);
            return metadata[className];
        } else {
            metadata[className]=new (Model(className));
            metadata[className].$metadata(function(){
                (callback || angular.noop)(metadata[className]);
            });
        }


    };
    //Изменяет прототип класса модели, добавляя в него новые функции
    instance.extend=function(modelClass,className,callback){

        instance.metadata(className,function(meta){
            modelClass.prototype.rel=function(alias,params,callback){

                return this.relations[alias](this,params,callback);
            };
            modelClass.prototype.relations=modelClass.prototype.relations || {};
            if (meta.hasMany){
                angular.forEach(meta.hasMany,function(rel,name){

                    modelClass.prototype.relations[name]=function(self,params,callback){
                        var defaults={};
                        if (rel.through){ //При связи много ко многим танцы с бубном
                            defaults['method']='through';
                            defaults['model']=meta.ClassName;
                            defaults['alias']=name;
                            defaults['fk']=self.id;
//                            defaults['through']=rel.through;

                        } else {
                            defaults[rel.foreign_key]=self.id;
                        }
                        params=angular.extend({},defaults,params);
                        return Model(rel.model).query(params,callback);
                    }
                });
            }
            if (meta.belongsTo){
                angular.forEach(meta.belongsTo,function(rel,name){
                    modelClass.prototype.relations[name]=function(params,callback){
                        var defaults={};
                        defaults['id']=this[rel.foreign_key];
                        params=angular.extend({},defaults,params);
                        return Model(rel.model).get(params,callback);
                    };
                });
            }

            if (meta.hasOne){
                angular.forEach(meta.hasOne,function(rel,name){
                    modelClass.prototype.relations[name]=function(params,callback){
                        var defaults={};
                        defaults[rel.foreign_key]=this[id];
                        params=angular.extend({},defaults,params);
                        return Model(rel.model).get(params,callback);
                    };
                });
            }

            (angular.noop || callback)();

        });
    };

    return instance;
}]);