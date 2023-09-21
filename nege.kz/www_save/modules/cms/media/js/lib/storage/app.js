var app=angular.module('storage',['ngUpload']);
var reloadFiles=null;
var callbackArgs={};
var open=null;
var openForEditor=null;
var setUploadType=null;

function CtrlMain($scope){

}

function CtrlFileBrowser($scope){
    $scope.files=[];
    $scope.filter=["png","jpg","gif"];

    var storageSelectHandler=function(id,url,type){
        window.parent['set'+callbackArgs.type](callbackArgs.field,url,id,type);
        window.parent.closeFileBrowser();
    }

    var tinyMCEElement=null;

    var tinyMCESelectHandler=function(id,url,type){
        tinyMCEElement.value=url;
        window.parent.closeFileBrowser();
    }

    $scope.load=function(parent){
        $.getJSON(BASE_URL+'storage/list/'+parent,function(data){
            $scope.files=data;
            $scope.$apply();
        });
    };

    $scope.delete=function(id){
        $.post(BASE_URL+'storage/delete',{id:id},function(data){
            $scope.load(null);
        });
    };

    $scope.select=function(id,url,type){
       window.parent['set'+callbackArgs.type](callbackArgs.field,url,id,type);
       window.parent.closeFileBrowser();
    }

    $scope.load(null);
    reloadFiles=$scope.load;
    open=function(args){
        $scope.select=storageSelectHandler;
        callbackArgs=args;
        if (args.type=="Img"){
            $scope.filter=["png","jpg","gif"];
        } else {
            $scope.filter=[];
        }
        setUploadType(args.type);
        $scope.$apply();
        window.parent.openFileBrowser();
    }
    openForEditor=function(field_name, url, type, win){
        $scope.select=tinyMCESelectHandler;
        tinyMCEElement=win.document.getElementById(field_name);
        if (type=="image"){
            $scope.filter=["png","jpg","jpeg","gif"];
        } else {
            $scope.filter=[];
        }
        setUploadType(type);
        $scope.$apply();
        window.parent.openFileBrowser();
    }

}

function CtrlFileUploader($scope){
    $scope.uploading=false;
    $scope.type="File";
    $scope.response={err:0,msg:""};
    $scope.results=function(content, completed){
        if (completed && content.length>0){
            $scope.uploading=false;
            $scope.response=JSON.parse(content);
            if ($scope.response.err==0){
                window.parent['set'+callbackArgs.type](callbackArgs.field,$scope.response.url,$scope.response.file,$scope.response.type);
                window.parent.closeFileBrowser();
            }
            reloadFiles();
//            $scope.$apply();
//            console.log($scope.response);
        } else {
            $scope.uploading=true;
//            console.log(content.length,completed);
        }
    }

    setUploadType=function(type){
        $scope.type=type;
        $scope.$apply();
    }


}

app.filter('filetype',function(){
    return function(input,types){
//       console.log(input,types,types.length);
        var filtred=[];
        if (types.length==0){
            return input;
        }

       angular.forEach(input,function(file){
           if (types.indexOf(file.type)!=-1){
               filtred.push(file);
           }
       });
//        console.log(filtred);
        return filtred;
    }
});
