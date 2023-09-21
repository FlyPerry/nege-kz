angular.module('admin').directive('imageUploader', function ($uploader, $timeout) {
    return {
        restrict: 'E',
        replace: false,
        templateUrl: BASE_URL + 'js/app/templates/imageUploader.template.html',
        scope: {
            file: '=',
            onCancel: '&',
            field: '@',
            label: '@',
            size: '@',
            originalImage: '@',
            image: '@',
            imageId: '@',
            aspect: '@',
            watermark: '=',
            downloadUrl: '@'
        },

        compile: function compile(templateElement, templateAttrs, transclude) {
            return {
                pre: function (scope, element, attrs) {
                    $.material.checkbox(element.find('input[type=checkbox]'));
                    element.find('[data-toggle="tooltip"]').tooltip({container: element});
                },
                post: function (scope, element, attrs) {
                    var
                        fileInput = element.find('._file_input'),
                        cropModal = element.find('.crop-dialog'),
                        uploadModal = element.find('.upload-dialog'),
                        upload = false;

                    scope.progres = 0;
                    scope.watermark = scope.watermark || false;
                    scope.error = null;
                    scope.loading = false;

                    scope.upload = function (file) {
                        scope.error = null;
                        scope.progress = 0;
                        scope.loading = true;
                        upload = $uploader.uploadImage({
                            file: file,
                            postData: {
                                watermark: scope.watermark
                            },
                            onProgress: function (val) {
                                scope.$apply(function () {
                                    scope.progress = val;
                                });
                            },
                            onSuccess: function (data) {
                                scope.$apply(function () {
                                    if (!data.err) {
                                        scope.originalImage = data.url;
                                        scope.image = data.url;
                                        scope.imageId = data.file;
                                    }
                                    else {
                                        scope.error = data.msg;
                                        scope.abort();
                                    }
                                    scope.progress = 0;
                                    scope.loading = false;
                                });
                            }
                        })
                    };
                    scope.urlUpload = function (url) {
                        if (!url) {
                            return;
                        }
                        scope.loading = true;
                        scope.error = false;
                        upload = $uploader.urlUpload(url, scope.watermark);
                        upload.then(function (data) {
                            scope.$apply(function () {
                                scope.loading = false;
                                scope._url = null;
                                if (data.error) {
                                    scope.error = data.error;
                                    return;
                                }
                                scope.originalImage = scope.image = data.url;
                                scope.imageId = data.file;
                                $timeout(function () {
                                    uploadModal.modal('hide');
                                }, 0);

                            })
                        })
                    };
                    scope.openCropDialog = function () {
                        cropModal.modal('show');
                    };
                    scope.openFileDialog = function () {
                        fileInput.click();
                    };
                    scope.openUrlFileDialog = function () {
                        scope.error = null;
                        uploadModal.modal('show');
                    };
                    scope.crop = function () {
                        $.post(BASE_URL + 'storage/crop/' + scope.imageId, scope.params, function (data) {
                            scope.$apply(function () {
                                scope.image = data;
                            })
                        });
                        cropModal.modal('hide')
                    };
                    scope.cancel = function () {
                        (scope.onCancel || angular.noop)();
                        scope.abort();
                    };
                    scope.abort = function () {
                        element.find('.image').cropper('destroy');
                        scope.image = null;
                        scope.originalImage = null;
                        if (upload) {
                            console.log(upload);
                            upload.abort()
                        }
                        scope._url = null;
                        scope.progress = 0;
                        scope.loading = false;
                        scope.imageId = null;
                    };
                    scope.cancelUrlUpload = function () {
                        scope.abort();
                    };
                    scope.$on('$destroy', function () {

                    });

                    cropModal.on('shown.bs.modal', function () {
                        element.find('.image').cropper({
                            aspectRatio: scope.aspect,
                            background: false,
                            crop: function (e) {
                                scope.params = {
                                    x: Math.round(e.x),
                                    y: Math.round(e.y),
                                    w: Math.round(e.width),
                                    h: Math.round(e.height),
                                    r: scope.aspect
                                };
                            }
                        });
                    });
                    fileInput.on('change', function (e) {
                        scope.error = null;
                        scope.progress = 0;
                        scope.loading = true;
                        scope.upload(e.target.files[0]);
                    });
                    uploadModal.on('hide.bs.modal', function () {
                        scope.$apply(function () {
                            scope.error = null;
                        })
                    });
                    uploadModal.on('shown.bs.modal', function () {
                        uploadModal.find('input[type=text]').focus();
                    });

                    if (scope.file) {
                        scope.upload(scope.file);
                    }
                    else if (scope.downloadUrl) {

                        scope.urlUpload(scope.downloadUrl);
                    }
                }
            }
        }
    }
});
