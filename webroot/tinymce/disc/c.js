tinymce.init({
    selector: ".tinyMceEditor",height: 300,
    plugins: [
        "advlist autolink link image lists preview hr anchor pagebreak",
        "wordcount media nonbreaking table contextmenu paste textcolor code responsivefilemanager",
    ],
    toolbar1: " undo redo | styleselect bold italic underline forecolor backcolor | bullist numlist outdent indent | link unlink anchor | responsivefilemanager image media | preview code",
    toolbar2: "",
    image_advtab: true ,
    filemanager_crossdomain: true,
    menubar: false,
    relative_urls: false,
    external_filemanager_path:"/filemanager/",
    filemanager_title:"Filemanager" ,
    external_plugins: { "filemanager" : "/filemanager/plugin.min.js"},
    file_picker_types: 'file image media',
    file_picker_callback: function(cb, value, meta) {
        var width = window.innerWidth - 30;
        var height = window.innerHeight - 60;
        if (width > 1800) width = 1800;
        if (height > 1200) height = 1200;
        if (width > 600) {
            var width_reduce = (width - 20) % 138;
            width = width - width_reduce + 10;
        }
        var urltype = 2;
        if (meta.filetype == 'image') {
            urltype = 1;
        }
        if (meta.filetype == 'media') {
            urltype = 3;
        }
        var title = "FileManager";
        if (typeof this.settings.filemanager_title !== "undefined" && this.settings.filemanager_title) {
            title = this.settings.filemanager_title;
        }
        var akey = "key";
        if (typeof this.settings.filemanager_access_key !== "undefined" && this.settings.filemanager_access_key) {
            akey = this.settings.filemanager_access_key;
        }
        var sort_by = "";
        if (typeof this.settings.filemanager_sort_by !== "undefined" && this.settings.filemanager_sort_by) {
            sort_by = "&sort_by=" + this.settings.filemanager_sort_by;
        }
        var descending = "false";
        if (typeof this.settings.filemanager_descending !== "undefined" && this.settings.filemanager_descending) {
            descending = this.settings.filemanager_descending;
        }
        var fldr = "";
        if (typeof this.settings.filemanager_subfolder !== "undefined" && this.settings.filemanager_subfolder) {
            fldr = "&fldr=" + this.settings.filemanager_subfolder;
        }

        tinymce.activeEditor.windowManager.open({
            title: title,
            file: this.settings.external_filemanager_path + 'dialog.php?type=' + urltype + '&descending=' + descending + sort_by + fldr  + '&lang=' + this.settings.language + '&akey=' + akey,
            width: width,
            height: height,
            resizable: true,
            maximizable: true,
            inline: 1
        }, {
            setUrl: function(url) {
                cb(url);
            }
        });
    },
});