<?php
if ( ! isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}

$this->Html->scriptStart(['block' => true]); ?>
    $(document).ready(function () {
        setTimeout(function () {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                preventDuplicates: true,
                showMethod: 'slideDown',
                timeOut: 2000
            };
            toastr.success('<?php echo $message; ?>', '<?php echo __(MESSAGE) ?>');
        }, 500);
    });
<?php $this->Html->scriptEnd();
