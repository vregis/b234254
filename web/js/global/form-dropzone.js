

var FormDropzone = function () {

    function initDropzone(thisDropzone, category, id) {
        $.post('upload_' + category, {'id' : id,'_csrf' : $("meta[name=csrf-token]").attr("content")}, function(data) {
            var files;
            var path;
            if(typeof data =='object')
            {
                files = data.files;
                path = data.path;
            }
            else
            {
                var response=jQuery.parseJSON(data);
                files = response.files;
                path = response.path;
            }
            $.each(files, function(key,value){

                var mockFile = { name: value.name, size: value.size };
                thisDropzone.emit("addedfile", mockFile);
                if(category == 'photo') {
                    thisDropzone.emit("thumbnail", mockFile, path + value.name);
                }
                thisDropzone.emit("complete", mockFile);
            });

        });
    }
    function addedfile(_this, file, category, id) {
        if (_this.files.length) {
            var _i, _len;
            for (_i = 0, _len = _this.files.length; _i < _len - 1; _i++) // -1 to exclude current file
            {
                if(_this.files[_i].name === file.name && _this.files[_i].size === file.size && _this.files[_i].lastModifiedDate.toString() === file.lastModifiedDate.toString())
                {
                    _this.removeFile(file);
                    return;
                }
            }
        }
        // Create the remove button
        var removeButton = Dropzone.createElement("<button class='btn btn-sm btn-block'>Remove file</button>");

        // Listen to the click event
        removeButton.addEventListener("click", function(e) {
            // Make sure the button click doesn't submit the form:
            e.preventDefault();
            e.stopPropagation();

            // Remove the file preview.
            _this.removeFile(file);
            // If you want to the delete the file on the server as well,
            // you can do the AJAX request here.
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'delete_' + category,
                data: 'file=' + file.name + '&id=' + id + '&_csrf='+$("meta[name=csrf-token]").attr("content"),
                success:function (json) {
                }
            });
        });

        // Add the button to the file preview element.
        file.previewElement.appendChild(removeButton);
    }

    return {
        //main function to initiate the module
        init: function (id) {
            Dropzone.options.dropzoneAudio = {
                maxFilesize: 2,
                acceptedFiles: "audio/*",
                    init: function() {
                    this.on("addedfile", function(file) {
                        addedfile(this, file, 'audio', id);
                    });
                    initDropzone(this,'audio',id);
                }            
            };
            Dropzone.options.dropzonePhoto = {
                maxFilesize: 2,
                acceptedFiles: "image/*",
                init: function() {
                    this.on("addedfile", function(file) {
                        addedfile(this, file, 'photo', id);
                    });
                    initDropzone(this,'photo',id);
                }
            };
            Dropzone.options.dropzoneArchive = {
                maxFilesize: 25,
                acceptedFiles: ".zip,.rar,.7z",
                init: function() {
                    this.on("addedfile", function(file) {
                        addedfile(this, file, 'archive', id);
                    });
                    initDropzone(this,'archive',id);
                }
            };
            Dropzone.options.dropzoneDocument = {
                maxFilesize: 2,
                acceptedFiles: ".txt,.doc,.docm,.docx,.dot,.dotm,.dotx,.html,.mht,.odt,.pdf,.rtf,.wps,.xml,.xps,.xls,.xlsx,.ppt,.pptx",
                init: function() {
                    this.on("addedfile", function(file) {
                        addedfile(this, file, 'document', id);
                    });
                    initDropzone(this,'document',id);
                }
            };
        }
    };
}();