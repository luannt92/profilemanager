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
    <h4 class="modal-title"><?php echo __(REGISTER); ?></h4>
</div>
<div class="modal-body">
    <?php echo $this->Form->create($registerForm, [
        'class'       => 'form-login',
        'data-toggle' => 'validator',
        'role'        => 'form',
    ]); ?>
    <?php
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
    <input type="hidden" name="phone_code" id="phone_number" value="84">
    <?php
    echo $this->Form->control('phone_number', [
            'class'               => 'form-control',
            'placeholder'         => __(PLACEHOLDER_PHONE_NUMBER),
            'label'               => __(PHONE_NUMBER_TXT),
            'type'                => 'tel',
            'required'            => true,
            'data-required-error' => __(PLACEHOLDER_PHONE_NUMBER),
        ]
    );
    ?>
    <div class="clearfix"></div>
    <?php
    echo $this->Form->control(
        'full_name', [
            'class'               => 'form-control',
            'placeholder'         => __(PLACEHOLDER_FULL_NAME),
            'label'               => __(FULL_NAME),
            'required'            => true,
            'data-required-error' => __(PLACEHOLDER_FULL_NAME),
        ]
    );
    echo $this->Form->control('password', [
            'class'               => 'form-control',
            'placeholder'         => __(PLACEHOLDER_PASSWORD),
            'label'               => __(PASSWORD),
            'required'            => true,
            'id'                  => 'registerPassword',
            'data-minlength'      => MIN_LENGTH_PASSWORD,
            'data-required-error' => __(PLACEHOLDER_PASSWORD),
            'data-error'          => __(VALIDATE_INPUT_4, __(PASSWORD),
                MIN_LENGTH_PASSWORD),
        ]
    );
    echo $this->Form->control(
        'confirmPass', [
            'type'                => 'password',
            'class'               => 'form-control',
            'placeholder'         => __(PLACEHOLDER_CONFIRM_PASSWORD),
            'label'               => __(CONFIRM_PASSWORD),
            'required'            => true,
            'data-minlength'      => MIN_LENGTH_PASSWORD,
            'data-match'          => '#registerPassword',
            'data-error'          => __(USER_MSG_0057),
            'data-required-error' => __(PLACEHOLDER_CONFIRM_PASSWORD),
        ]
    );
    ?>
    <div class="form-group form-submit">
        <?php
        echo $this->Form->button(__(BTN_REGISTER), [
                'type'  => 'submit',
                'class' => 'register',
                'id'    => 'btn-register',
            ]
        );
        ?>
        <span><?php echo __(OR_TXT); ?></span>
        <?php echo $this->Html->link(__(REGISTER_FACEBOOK),
            ['action' => 'socialLogin', 'facebook'],
            ['class' => 'loginfb']);
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
