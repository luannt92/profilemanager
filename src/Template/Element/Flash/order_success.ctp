<?php
if ( ! isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
    <div class="modal myPopup fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php echo __(MESSAGE) ?></h4>
                </div>
                <div class="modal-body modal-body-noti">
                    <p><?php echo $message; ?> <br>
                        <?php echo __(MSG_CALL_ORDER); ?></p>
                    <p><?php echo __(MSG_FOLLOW_ORDER); ?></p>
                    <ul>
                        <li><a class="fb-like"
                               href="<?php echo $settingInfo['site_facebook']; ?>"
                               target="_blank"><i
                                        class="fa fa-facebook-f"></i></a></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn success"
                            data-dismiss="modal"><?php echo __(OK_TXT); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php
$this->Html->scriptStart(['block' => true]); ?>
    $(document).ready(function () {
    $('#myModal').modal('show');
    });
<?php $this->Html->scriptEnd();