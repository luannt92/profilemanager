<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}

$this->Html->scriptStart(['block' => true]); ?>
    $(document).ready(function() {
    setTimeout(function () {
    toastr.options = {
    closeButton: true,
    preventDuplicates: true,
    progressBar: true,
    showMethod: 'slideDown',
    timeOut: 4000
    };
    toastr.error('<?php echo $message; ?>', 'Thông báo');
    }, 500);
    });
<?php $this->Html->scriptEnd();
