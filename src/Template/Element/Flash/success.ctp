<?php
if ( ! isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}

$this->Html->scriptStart(['block' => true]); ?>
    $(document).ready(function() {
    setTimeout(function () {
    toastr.options = {
    closeButton: true,
    progressBar: true,
    preventDuplicates: true,
    showMethod: 'slideDown',
    timeOut: 4000
    };
    toastr.success('<?php echo $message; ?>', 'Thông báo');
    }, 500);
    });
<?php $this->Html->scriptEnd();
