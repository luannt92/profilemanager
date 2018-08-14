<?php
$this->Form->setTemplates(
    [
        'inputContainer' => '<div class="form-group">{{content}}<div class="help-block with-errors"></div></div>',
    ]
);
?>
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
    ]);
    echo $this->Form->control('email', [
            'class'               => 'form-control',
            'placeholder'         => __(PLACEHOLDER_EMAIL),
            'label'               => __(EMAIL),
            'autofocus'           => true,
            'type'                => 'email',
            'required'            => true,
            'data-required-error' => __(PLACEHOLDER_EMAIL),
            'data-error'          => __(VALIDATE_INPUT_2, __(EMAIL)),
        ]
    );
    ?>
    <div class="form-group form-submit">
        <?php
        echo $this->Form->button(__(BTN_SEND), [
                'type'  => 'submit',
                'class' => 'register',
            ]
        );
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
