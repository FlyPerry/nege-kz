angular.module('admin').service('$uploader', function () {
    var config = {
        fileName: 'file',
        uploadUrl: '/storage/upload/File'
    };

    this.upload = function (params) {
        var defaultParams = {
            file: '',
            postData: {},
            onProgress: angular.noop,
            onSuccess: angular.noop,
            onError: angular.noop
        };

        params = angular.extend(defaultParams, params);
        var formData = new FormData();
        formData.append(config.fileName, params.file);
        for (var property in params.postData) {
            if (params.postData.hasOwnProperty(property)) {
                formData.append(property, params.postData[property]);
            }
        }

        return $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        params.onProgress(percentComplete);
                    }
                }, false);
                return xhr;
            },
            url: config.uploadUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: params.onSuccess
        });
    };
    this.uploadFile = function (params) {
        config.uploadUrl = BASE_URL + 'storage/upload/File';
        return this.upload(params);
    };
    this.uploadImage = function (params) {
        config.uploadUrl = BASE_URL + 'storage/upload/Image';
        return this.upload(params);
    };
    this.urlUpload = function (url, watermark) {
        return $.post(BASE_URL + 'storage/load_image_from', {url: url, watermark: watermark}, null, 'json');
    }
});