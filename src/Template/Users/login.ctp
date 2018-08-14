<?php
$this->Form->setTemplates(
    [
        'inputContainer' => '<div class="form-group">{{content}}<div class="help-block with-errors"></div></div>',
    ]
);
$urlRegister = $this->Url->build([
    'controller' => 'Users',
    'action'     => 'register',
    'language'   => $language,
]);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"
            aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><?php echo __(LOGIN); ?></h4>
</div>
<div class="modal-body">
    <?php
    echo $this->Form->create($loginForm, [
        'class'       => 'form-login',
        'data-toggle' => 'validator',
        'role'        => 'form',
    ]);
    $remember = $this->Form->checkbox('rememberMe', [
        'class'   => 'form-control',
        'checked' => 1,
    ]);
    echo $this->Form->control('email', [
            'class'               => 'form-control',
            'placeholder'         => __(PLACEHOLDER_EMAIL),
            'label'               => __(EMAIL),
//            'autofocus'           => true,
            'type'                => 'email',
            'required'            => true,
            'data-required-error' => __(PLACEHOLDER_EMAIL),
            'data-error'          => __(VALIDATE_INPUT_2, __(EMAIL)),
        ]
    );
    echo $this->Form->control('password', [
            'class'               => 'form-control',
            'placeholder'         => __(PLACEHOLDER_PASSWORD),
            'label'               => __(PASSWORD),
            'required'            => true,
            'data-required-error' => __(PLACEHOLDER_PASSWORD),
            'data-minlength'      => MIN_LENGTH_PASSWORD,
            'data-error'          => __(VALIDATE_INPUT_4, __(PASSWORD),
                MIN_LENGTH_PASSWORD),
        ]
    );
    ?>
    <div class="form-group form-check">
    <span class="checkbox">
       <label class="selectit">
          <?php echo $remember; ?>
           <span class="cr">
              <i class="cr-icon fa fa-check"></i>
          </span>
           <?php echo __(REMEMBER_ME); ?>
       </label>
    </span>
        <span class="forrget-pass">
    <?php
    echo $this->Html->link(__(FORGOT_PASSWORD),
        ['action' => 'forgotPassword', 'language' => $language],
        [
            "class"        => "click-to-open",
            "data-toggle"  => "modal",
            "data-dismiss" => "modal",
            "data-target"  => "#modalForgotPass",
        ]
    );
    ?>
    </span>
    </div>
    <div class="form-group form-submit">
        <?php
        echo $this->Form->button(__(LOGIN), [
                'type'  => 'submit',
                'class' => 'login',
                'id'    => 'btn-login',
            ]
        );
        ?>
        <span><?php echo __(OR_TXT); ?></span>
        <?php echo $this->Html->link(__(LOGIN_FACEBOOK),
            ['action' => 'socialLogin', 'facebook'],
            ['class' => 'loginfb']);
        ?>
        <a class="register click-to-open" data-target="#myRegister"
           href="<?php echo $urlRegister; ?>" data-toggle="modal"
           data-dismiss="modal">
            <?php echo __(BTN_REGISTER); ?>
        </a>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
