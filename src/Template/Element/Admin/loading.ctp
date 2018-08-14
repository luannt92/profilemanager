<div id="lds-page" class="lds-css ng-scope">
    <div id="preloader">
        <div class="lds-spinner">
            <?php echo $this->Html->image('admin-loading.gif', ['alt' => 'Spinner']);?>
        </div>
    </div>
</div>
<?php echo $this->Html->scriptStart(['block' => true]); ?>
    $(document).ready(function () {
        var $loading = $('#lds-page').hide();
        $(document)
            .ajaxStart(function () {
                $loading.show();
            })
            .ajaxStop(function () {
                $loading.hide();
            });
    });
<?php echo $this->Html->scriptEnd(); ?>