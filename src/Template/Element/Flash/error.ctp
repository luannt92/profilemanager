<?php
if ( ! isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}

$this->Html->scriptStart(['block' => true]); ?>
    $(document).ready(function () {
        setTimeout(function () {
            toastr.options = {
                closeButton: true,
                preventDuplicates: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 2000
            };
            toastr.error('<?php echo $message; ?>', '<?php echo __(MESSAGE) ?>');
        }, 500);
    });
<?php $this->Html->scriptEnd();
