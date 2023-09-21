angular.module('knm.ui.paginator',[])
    .directive('paginator',function($routeParams,$location){
    return {
        replace:true,
        template:'<div class="pagination" ng-show="count>perpage">'+
                    '<ul>'+
                       '<li ng-repeat="page in pages" ng-class="{active:page.active,disabled:page.disabled}" ><a href="" ng-click="goto(page.value)">{{page.title}}</a></li>'+

                    '</ul>'+
                '</div>',
        scope:{
            'page':'=',
            'count':'=',
            'perpage':'='
        },
        'link':function(scope,element,attr){
            scope.pages=[
//                {'link':'#',value:"1",'title':'1','active':true, 'disabled':false},
//                {'link':'#',value:"1",'title':'2','active':false,'disabled':false},
//                {'link':'#',value:"1",'title':'3','active':false,'disabled':false},
//                {'link':'#',value:"1",'title':'4','active':false,'disabled':true},
//                {'link':'#',value:"1",'title':'5','active':false,'disabled':false},
            ];

            scope.goto=function(page){
                scope.page=page;
                $location.search('page',page);
            };

            scope.update=function(){
//               element.find('ul').empty();
               var page=parseInt(scope.page),
                   count=parseInt(scope.count),
                   perpage=parseInt(scope.perpage),
                   count_in= 3,
                   count_out= 2,
                   total_pages = Math.ceil(count/perpage),
                   n1= 1,
                   n2= Math.min(count_out,total_pages),
                   n7= Math.max(1,total_pages-count_out+1),
                   n8=total_pages,
               // Middle group of pages: $n4...$n5
                   n4 = Math.max(n2 + 1, page - count_in),
                   n5 = Math.min(n7 - 1, page + count_in),
                   use_middle = (n5 >= n4),
                    // Point $n3 between $n2 and $n4
                   n3 = Math.floor((n2 + n4) / 2),
                   use_n3 = (use_middle && ((n4 - n2) > 1)),
                   // Point $n6 between $n5 and $n7
                   n6 = Math.floor((n5 + n7) / 2),
                   use_n6 = (use_middle && ((n7 - n5) > 1));
                var links = [];
                scope.pages=[];

                // Generate links data in accordance with calculated numbers
                for (var i = n1; i <= n2; i++)
                {
                    links[i] = i;
                }
                if (use_n3)
                {
                    links[n3] = '...';
                }
                for (var i = n4; i <= n5; i++)
                {
                    links[i] = i;
                }
                if (use_n6)
                {
                    links[n6] = '...';
                }
                for (var i = n7; i <= n8; i++)
                {
                    links[i] = i;
                }

                var prev = page - 1 > 0 ? page - 1 : 1;
                scope.pages.push({

                    'value': prev,
                    'title':'<<',
                    'active':false,
                    'disabled':prev==page
                });

                angular.forEach(links,function(title,val){
                    scope.pages.push({

                        'value':val,
                        'title':title,
                        'active':val==page,
                        'disabled':false
                    });
                });

                var next = page + 1 <= total_pages ? page + 1 : total_pages;
                scope.pages.push({
                    'value': next,
                    'title':'>>',
                    'active':false,
                    'disabled':next==page
                });

            };

            scope.update();
            scope.$watch('page',scope.update);
            scope.$watch('count',scope.update);
            scope.$watch('perpage',scope.update);
        }

    };
});