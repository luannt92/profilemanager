<?php
echo $this->Html->css(
    [
        'admin/jquery.fancybox.min.css',
    ],
    ['block' => true]
);
echo $this->Html->script(
    [
        'admin/jquery.fancybox.min.js',
    ],
    ['block' => 'scriptBottom']
);
?>
<?php echo $this->Html->scriptStart(['block' => true]); ?>
//<script>
    $(document).ready(function () {
        $('.iframe-btn').fancybox({
            'width': 900,
            'height': 600,
            'type': 'iframe',
            'autoScale': false
        });

        $('#Image').change(function () {
            var url = $('#Image').val();
            $('#previewImg').attr('src', url);
        });
    });

    function responsive_filemanager_callback(field_id) {
        var url = jQuery('#' + field_id).val();
        $("#previewImg").attr('src', url);
        var banner = $("#previewImg").attr('data-banner');
        if(banner == undefined){
            $("#Image").val(url.replace('source', 'thumbs'));
        }else {
            $("#Image").val(url);
        }
    }
    <?php echo $this->Html->scriptEnd(); ?>
