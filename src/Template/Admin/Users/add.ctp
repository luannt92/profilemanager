<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(USERS_MANAGEMENT),
    'subTitle' => __(ADD),
]);

$avatar    = empty($user->avatar) ? NO_IMAGE : $user->avatar;
$avatarImg = $this->Html->image(
    $avatar, [
        'id'    => 'previewImg',
        'style' => ['max-width: 200px; max-height :100px;']
    ]
);
$backLink = $this->Html->link(
    __(BACK), ['action' => 'index'], [
        'class' => 'btn btn-white m-b pull-right',
    ]
);
$this->Form->setTemplates(
    [
        'formGroup'           => '<div class="form-group">{{label}}<div class="col-sm-10">{{input}}</div></div>',
        'label'               => '<label class="col-sm-2 control-label" {{attrs}}>{{text}}</label>',
        'submitContainer'     => '<div class="form-group row"><div class="col-sm-2"></div>
                                <div class="col-sm-10">{{content}} ' . $backLink
            . '</div></div>',
        'inputContainerError' => '<div class="input {{type}}{{required}} error">{{content}}</div>',
    ]
);
$time = time();
echo $this->Form->create($user)
?>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab"
                           href="#tab-1"><?php echo __(NEW_INFO); ?></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <div class="form-horizontal">
                                <div class="col-md-6">
                                    <?php
                                    echo $this->Form->control('email', [
                                            'class'       => 'form-control',
                                            'placeholder' => 'sport@gmail.com',
                                            'type'        => 'email',
                                            'autofocus'   => true,
                                        ]
                                    );
                                    echo $this->Form->control('password', [
                                            'class'       => 'form-control',
                                            'placeholder' => __(PASSWORD),
                                            'type'        => 'password',
                                        ]
                                    );
                                    echo $this->Form->control('name', [
                                            'class'       => 'form-control',
                                            'placeholder' => 'Nguyen Van A',
                                            'required'    => false,
                                        ]
                                    ); ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"><?php echo __(
                                                AVATAR
                                            ) ?></label>
                                        <div class="col-sm-6">
                                            <?php echo $avatarImg; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-7">
                                            <?php echo $this->Form->control(
                                                'avatar',
                                                [
                                                    'class'       => 'form-control',
                                                    'type'        => 'text',
                                                    'id'          => 'Image',
                                                    'label'       => false,
                                                    'placeholder' => __(AVATAR),
                                                    'templates'   => [
                                                        'formGroup' => '{{input}}',
                                                    ],
                                                ]
                                            ); ?>
                                        </div>
                                        <div class="col-sm-3 text-right">
                                            <a href="/filemanager/dialog.php?type=0&field_id=Image&relative_url=1"
                                               class="btn btn-success iframe-btn"
                                               type="button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>Image...</span>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                    echo $this->Form->control('about_me', [
                                            'class'       => 'form-control',
                                            'placeholder' => 'About me',
                                            'type'        => 'textarea',
                                            'required'    => false,
                                        ]
                                    );
                                    ?>
                                </div>

                                <div class="col-md-6">
                                    <?php
                                    echo $this->Form->control('slug', [
                                            'class'       => 'form-control',
                                            'placeholder' => 'Slug',
                                            'required'    => false,
                                        ]
                                    );
                                    echo $this->Form->control('phone', [
                                            'class'       => 'form-control',
                                            'placeholder' => '0981234567',
                                        ]
                                    );
                                    echo $this->Form->control('address', [
                                            'class'       => 'form-control',
                                            'placeholder' => 'Ha Noi',
                                        ]
                                    );
                                    echo $this->Form->control('user_group_id', [
                                            'class'   => 'form-control',
                                            'options' => $groups,
                                        ]
                                    );
                                    echo '<div class="form-group"><label class = "col-sm-2 control-label">Birthday</label><div class="col-sm-10">';
                                    echo $this->Form->control(
                                        'birthday', [
                                            'label'     => false,
                                            'templates' => [
                                                'inputContainer' => '<div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input name="birthday" class = "form-control datetimepicker4" type="text" value="'
                                                    . date('Y/m/d', $time)
                                                    . '">
                                            </div></div></div>',
                                            ],
                                        ]
                                    );
                                    echo $this->Form->control('gender', [
                                            'class'   => 'form-control',
                                            'options' => [
                                                MALE   => 'Nam',
                                                FEMALE => 'Nữ',
                                            ],
                                        ]
                                    );
                                    echo $this->Form->control(
                                        __(SAVE_CHANGE), [
                                            'class' => 'btn btn-primary m-b',
                                            'type'  => 'submit',
                                        ]
                                    ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>

<?php echo $this->Html->scriptStart(['block' => true]); ?>
$(document).ready(function () {
$('.datetimepicker4').datetimepicker({
format: "YYYY-MM-DD"
});
});
<?php echo $this->Html->scriptEnd();
echo $this->element('Admin/Editor/popup');
?>
