var tryOn = (function(pub) {
    var _elem;
    var _options = {};
    var _faceTracker;
    var _drawOptions = {};

    function _render(options) {
        _elem = document.createElement('div');
        _elem.innerHTML = _options.template(_options.templateParams);
        _elem.addEventListener('changeGenderType', _onChangeGenderType);
        _elem.addEventListener('changeCurPhoto', _onChangeCurPhoto);
        _elem.addEventListener('activateWebcamMode', _onActivateWebcamMode);
        _elem.addEventListener('uploadPhoto', _onUploadPhoto);
        _elem.addEventListener('stopDraw', _onStopDraw);
    }

    function _init(options) {
        if (options.template)
            _options.template = options.template;
        if (options.templateParams)
            _options.templateParams = options.templateParams;
        else
            _options.templateParams = {};
        if (options.faceContainerWidth)  
          _options.faceContainerWidth = options.faceContainerWidth;
        if (options.faceContainerHeight)  
          _options.faceContainerHeight = options.faceContainerHeight;

        if (options.faceTracker)
            _faceTracker = options.faceTracker;
    }

    function _onStopDraw(e) {
        _faceTracker.stopDraw();
    }

    function _draw(options) {
        var modelEyePositions = [];
        _drawOptions = options;
        if (options.fotoSrc) {
            //foto mode
            _faceTracker.init({
                viewType: 'foto',
                glassesSrc: options.glassesSrc,
                trackerParams: options.trackerParams,
                trackerCanvas: options.trackerCanvas,
                overlayCanvas: options.overlayCanvas,
                model: options.model,
                renderMaxLoopNum: options.renderMaxLoopNum,
                fotoSrc: options.fotoSrc,
                containerWidth: options.faceContainerWidth,
                eyePositions: options.eyePositions
            });
        } else {
            //video mode
        }
        //_faceTracker.draw();
    }

    function _onChangeGenderType(e) {}

    function _onChangeCurPhoto(e) {
        if (!e.detail || !e.detail.photoSrc)
            return false;
        _faceTracker.stopDraw();
        _faceTracker.init({
            viewType: 'foto',
            glassesSrc: _drawOptions.glassesSrc,
            trackerParams: _drawOptions.trackerParams,
            trackerCanvas: e.detail.trackerCanvas,
            overlayCanvas: _drawOptions.overlayCanvas,
            model: _drawOptions.model,
            renderMaxLoopNum: _drawOptions.renderMaxLoopNum,
            fotoSrc: e.detail.photoSrc,
            containerWidth: _drawOptions.faceContainerWidth,
            eyePositions: e.detail.eyePositions
        });
        //_faceTracker.draw();
        return true;
    }

    function _onActivateWebcamMode(e) {
        _faceTracker.stopDraw();
        if (
          _faceTracker.init({
              viewType: 'video',
              glassesSrc: _drawOptions.glassesSrc,
              trackerParams: _drawOptions.trackerParams,
              trackerCanvas: e.detail.trackerCanvas,
              overlayCanvas: _drawOptions.overlayCanvas,
              model: _drawOptions.model,
              containerWidth: _drawOptions.faceContainerWidth,
          })
        )
          _faceTracker.draw();
    }

    function _onUploadPhoto(e) {
        var error = {};
        var postFileName;
        var file;
        var xhr;
        var fd;
        var submitPath;

        if (!e || !e.detail || !e.detail.inputElement || !e.detail.inputElement.files[0]) {
            error.errorNo = 1;
            error.errorText = 'wrong input parameters';
            error.data = {};
            if (e.detail && e.detail.error && e.detail.error instanceof Function) {
                e.detail.error(error);
            }
            return false;
        }
        postFileName = e.detail.postFileName || 'afile';
        submitPath = e.detail.submitPath || location.href;

        file = e.detail.inputElement.files[0];
        xhr = new XMLHttpRequest();
        fd = new FormData();
        fd.append(postFileName, file);
        xhr.onload = xhr.onerror = function() {
            if (this.status == 200) {
                _onChangeCurPhoto({
                    detail: {
                      photoSrc: this.response,
                      trackerCanvas: e.detail.trackerCanvas,
                    }
                });
                if (e.detail && e.detail.success && e.detail.success instanceof Function) {
                    e.detail.success({
                        photoSrc: this.response
                    });
                }
            } else {
                error.errorNo = 2;
                error.errorText = 'wrong server response';
                error.data = {
                    serverResponse: this.response
                };
            }

        };
        xhr.open("POST", submitPath, true);
        xhr.send(fd);
        return true;
    }

    pub.init = function(options) {
        _init(options);
    }
    pub.render = function(options) {
        _render(options);
    }
    pub.getElem = function() {
        if (!_elem)
            render();
        return _elem;
    }

    pub.draw = function(options) {
        _draw(options);
    }

    return pub;

})(tryOn || {});
