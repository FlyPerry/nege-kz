<html ng-app="storage">
    <head>
        <script>
            BASE_URL="<?=URL::base()?>";
        </script>
        <?=$page->get_head()?>
    </head>
    <body>
    <div class="row-fluid" ng-controller="CtrlMain">
        <div class="span12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#upload" data-toggle="tab">Загрузить файл</a></li>
                <li><a href="#select" data-toggle="tab">Ранее загруженные</a></li>
            </ul>
            <div class="tab-content">
                <div ng-controller="CtrlFileUploader" id="upload" class="tab-pane active">
                    <h1>Загрузите файл с компьютера</h1>
                    <div ng-show="uploading">
                        <p class="text-info">Загрузка на сервер ...</p>
                    </div>
                    <div>
                        <p class="text-error">{{response.msg}}</p>
                    </div>
                    <form action="<?=Url::site('storage/upload')?>/{{type}}" ng-upload>
                        <input type="file" name="file"><input type="submit" class="btn" name="save" value="Загрузить на сервер" upload-submit="results(content, completed)">
                    </form>
                </div>
                <div ng-controller="CtrlFileBrowser" id="select" class="tab-pane">
                        <!--                <div class="span4"><h4>Дерево папок</h4></div>-->
                            <h4>Список файлов</h4>

                            <form class="form-search" >
                                <input type="text" class="input-large search-query" ng-model="search" placeholder="Введите имя файла">
                            </form>
                            <table class="table">
                                <thead>
                                <tr>
                                    <td>Название</td>
                                    <td>Размер</td>
                                    <td>Добавлен</td>
                                    <td>&nbsp;</td>
                                </tr>
                                </thead>
                                <tr ng-repeat="file in files | filetype:filter | filter:search">
                                    <td><a href="{{file.url}}" target="_blank">{{file.name}}</a></td>
                                    <td>{{file.size}}</td>
                                    <td>{{file.created}}</td>
                                    <td>
                                        <button class="btn" ng-click="select(file.id,file.url,file.type)">Выбрать</button>
                                        <button class="btn" ng-click="delete(file.id)">Удалить</button>
                                    </td>
                                </tr>
                            </table>
                    </div>
                </div>
            </div>
        </div>

    </div>



    </body>
</html>