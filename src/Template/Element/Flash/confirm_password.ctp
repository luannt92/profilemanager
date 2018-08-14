<?php
$this->Form->setTemplates(
    [
        'inputContainer' => '<div class="form-group">{{content}}<div class="help-block with-errors"></div></div>',
    ]
);
$request = ! empty($params['request'])
    ? $params['request'] : '';
$key     = ! empty($params['key'])
    ? $params['key'] : '';
?>
    <div class="modal fade myPopup" id="changePassword" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php echo __(FORGOT_PASSWORD); ?></h4>
                </div>
                <div class="modal-body">
                    <?php
                    echo $this->Form->create(null, [
                        'class'       => 'form-forgot-password',
                        'data-toggle' => 'validator',
                        'role'        => 'form',
                        'url'         => [
                            'controller' => 'Users',
                            'action'     => 'confirmPasswordAjax',
                            '?'          => [
                                'request' => $request,
                                'key'     => $key,
                            ],
                        ],
                    ]);
                    /* echo $this->Form->control(
                         'oldPassword', [
                             'type'           => 'password',
                             'class'          => 'form-control',
                             'placeholder'    => __(PLACEHOLDER_PASSWORD),
                             'label'          => __(OLD_PASSWORD),
                             'required'       => true,
                             'data-minlength' => MIN_LENGTH_PASSWORD,
                         ]
                     );*/
                    echo $this->Form->control('newPassword', [
                            'class'               => 'form-control',
                            'placeholder'         => __(PLACEHOLDER_PASSWORD),
                            'label'               => __(NEW_PASSWORD),
                            'data-minlength'      => MIN_LENGTH_PASSWORD,
                            'required'            => true,
                            'type'                => 'password',
                            'id'                  => "newPassword",
                            'data-required-error' => __(PLACEHOLDER_PASSWORD),
                            'data-error'          => __(VALIDATE_INPUT_4,
                                __(PASSWORD),
                                MIN_LENGTH_PASSWORD),
                        ]
                    );
                    echo $this->Form->control(
                        'confirmNewPassword', [
                            'type'                => 'password',
                            'class'               => 'form-control',
                            'placeholder'         => __(PLACEHOLDER_CONFIRM_PASSWORD),
                            'label'               => __(CONFIRM_NEW_PASSWORD),
                            'required'            => true,
                            'data-minlength'      => MIN_LENGTH_PASSWORD,
                            'data-match'          => '#newPassword',
                            'data-error'          => __(USER_MSG_0046),
                            'data-required-error' => __(PLACEHOLDER_CONFIRM_PASSWORD),
                        ]
                    );
                    ?>
                    <div class="form-group form-submit">
                        <?php
                        echo $this->Form->button(__(CHANGE_PASSWORD), [
                                'type'  => 'submit',
                                'class' => 'register',
                                'id'    => 'btnComfirmPassword',
                            ]
                        );
                        ?>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
<?php
$this->Html->scriptStart(['block' => true]); ?>
    $(document).ready(function () {
    $('#changePassword').modal('show');
    var $form = $('#changePassword').find('form');
    $($form).validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
    } else {
    e.preventDefault();
    $.ajax({
    type: $form.attr('method'),
    url: $form.attr('action'),
    data: $form.serialize(),
    success: function (data) {
    var $result = JSON.parse(data);
    if ($result.success) {
    window.location.href = appConfig.baseUrl + appConfig.language + $result.redirect;
    } else {
    setTimeout(function () {
    toastr.options = {
    closeButton: true,
    preventDuplicates: true,
    progressBar: true,
    showMethod: 'slideDown',
    timeOut: 2000
    };
    if ($result.success) {
    toastr.success($result.message, '<?php echo __(MESSAGE); ?>');
    } else {
    toastr.error($result.message, '<?php echo __(MESSAGE); ?>');
    }
    }, 500);
    }
    }
    });
    }
    });
    });
<?php $this->Html->scriptEnd();

