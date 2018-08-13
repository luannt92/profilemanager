<?php
$this->Form->setTemplates(
    [
        'inputContainer' => '<div class="form-group">{{content}}</div>',
    ]
);

echo $this->Form->create($loginForm, ['class' => 'm-t']);
echo $this->Form->control(
    'email', [
        'class'       => 'form-control',
        'placeholder' => 'Email',
        'autofocus'   => true,
        'label'       => false,
    ]
);
echo $this->Form->control(
    'password', [
        'class'       => 'form-control',
        'placeholder' => 'Password',
        'label'       => false,
    ]
);

echo $this->Form->button(
    'Login', [
        'type'  => 'submit',
        'class' => 'btn btn-primary block full-width m-b',
    ]
);
?>
<?php
echo $this->Form->end();
?>
