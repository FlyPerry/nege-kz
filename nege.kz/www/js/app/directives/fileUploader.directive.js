angular.module('admin').directive('fileUploader', function ($uploader) {
    return {
        restrict: 'E',
        replace: false,
        templateUrl: BASE_URL + 'js/app/templates/fileUploader.template.html',
        scope: {
            label: '@',
            field: '@',
            name: '@',
            url: '@',
            value: '@',
            error: '@'
        },

        compile: function compile(templateElement, templateAttrs, transclude) {
            return {
                pre: function (scope, element, attrs) {
                    scope.progress = 0;
                    scope.loading = false;
                },
                post: function (scope, element, attrs) {
                    scope.openFileDialog = function () {
                        element.find('input[type=file]').click();
                    };

                    scope.abort = function () {
                        if (scope.hasOwnProperty('upload')) {
                            scope.upload.abort();
                        }
                        scope.progress = 0;
                        scope.loading = false;
                        element.find('input[type=file]').val('');
                        element.find('input[type=text]').val('');
                        scope.name = '';
                        scope.value = '';
                        scope.url = '';
                    };

                    var fileInput = element.find('._file_input');
                    fileInput.change(function (e) {
                        scope.loading = true;
                        scope.progress = 0;
                        scope.error = '';

                        scope.upload = $uploader.uploadFile({
                            file: e.target.files[0],
                            onProgress: function (val) {
                                scope.$apply(function () {
                                    scope.progress = val;
                                });
                            },
                            onSuccess: function (data) {
                                scope.$apply(function () {
                                    console.log(data);
                                    if (!data.err) {
                                        scope.value = data.file;
                                        scope.url = data.url;
                                    }
                                    else {
                                        scope.error = data.msg;
                                        scope.abort();
                                    }
                                    scope.progress = 0;
                                    scope.loading = false;
                                });
                            }
                        });
                    })
                }
            }
        }
    }
});
