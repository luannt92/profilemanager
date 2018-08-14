<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(USERS_MANAGEMENT),
    'subTitle' => __(VIEW, $user->id),
]);
echo $this->Html->css(
    [
        'admin/customstyle.css',
    ],
    ['block' => true]
);
echo $this->Html->script(
    [
        'admin/app.js',
    ],
    ['block' => 'scriptBottom']
);

$avatar    = empty($user->avatar) ? NO_IMAGE : $user->avatar;
$avatarImg = $this->Html->image(
    $avatar, [
        'id'    => 'previewImg',
        'style' => ['max-width: 200px; max-height :100px;']
    ]
);
$this->Form->setTemplates($this->Utility->customFormTemplate());
echo $this->Form->create($user, [
    'type' => 'get',
    'url'  => ['action' => 'edit', $user->id],
]);
?>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab"
                           href="#tab-1"><?php echo __(EDIT_INFO) ?></a>
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
                                            'disabled'    => true,
                                        ]
                                    );
                                    echo $this->Form->control('password', [
                                            'class'       => 'form-control',
                                            'placeholder' => __(PASSWORD),
                                            'type'        => 'password',
                                            'disabled'    => true,
                                        ]
                                    );
                                    echo $this->Form->control('name', [
                                            'class'       => 'form-control',
                                            'placeholder' => 'Nguyen Van A',

                                            'disabled'    => true,
                                        ]
                                    );
                                    ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <?php echo __(AVATAR) ?>
                                        </label>
                                        <div class="col-sm-6">
                                            <?php echo $avatarImg; ?>
                                        </div>
                                    </div>
                                    <?php
                                    echo $this->Form->control('note', [
                                            'class'       => 'form-control',
                                            'placeholder' => 'About me',
                                            'type'        => 'textarea',
                                            'disabled'    => true,
                                        ]
                                    );
                                    ?>
                                </div>

                                <div class="col-md-6">
                                    <?php
                                    echo $this->Form->control('slug', [
                                            'class'       => 'form-control',
                                            'placeholder' => 'Slug',
                                            'disabled'    => true,
                                        ]
                                    );
                                    echo $this->Form->control('phone', [
                                            'class'       => 'form-control',
                                            'placeholder' => '0987654321',
                                            'disabled'    => true,
                                        ]
                                    );
                                    echo $this->Form->control('address', [
                                            'class'       => 'form-control',
                                            'placeholder' => 'Ha Noi',
                                            'disabled'    => true,
                                        ]
                                    );
                                    echo $this->Form->control('user_group_id',
                                        [
                                            'class'    => 'form-control',
                                            'options'  => $groups,
                                            'disabled' => true,
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
                                                    . date('Y/m/d',
                                                        strtotime($user->birthday))
                                                    . '" disabled>
                                            </div></div></div>',
                                            ],
                                        ]
                                    );
                                    echo $this->Form->control('gender', [
                                            'class'    => 'form-control',
                                            'options'  => [
                                                MALE   => 'Nam',
                                                FEMALE => 'Nữ',
                                            ],
                                            'disabled' => true,
                                        ]
                                    );
                                    echo $this->Form->control('status', [
                                            'class'    => 'form-control',
                                            'options'  => [
                                                ENABLED  => 'Enabled',
                                                DISABLED => 'Disabled',
                                                TRASH    => 'Trash',
                                                REGISTER_STATUS => 'Register',
                                            ],
                                            'disabled' => true,
                                        ]
                                    );
                                    echo $this->Form->control(
                                        __(GO_TO_EDIT), [
                                            'class' => 'btn btn-primary m-b',
                                            'type'  => 'submit',
                                        ]
                                    );
                                    ?>
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