<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(USERS_MANAGEMENT),
    'subTitle' => __(EDIT, $user->id),
]);

$avatar    = empty($user->avatar) ? NO_IMAGE : $user->avatar;
$avatarImg = $this->Html->image(
    $avatar, [
        'id'    => 'previewImg',
        'style' => ['max-width: 200px; max-height :100px;']
    ]
);
$this->Form->setTemplates($this->Utility->customFormTemplate());
echo $this->Form->create($user)
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
                                            'placeholder' => 'phuquocdelivery@gmail.com',
                                            'type'        => 'email',
                                            'autofocus'   => true,
                                        ]
                                    );
                                    echo $this->Form->control('password', [
                                            'class'       => 'form-control',
                                            'placeholder' => 'xxxxxxxxx',
                                            'type'        => 'password',
                                            'value'       => '',
                                            'required'    => false,
                                            'templates'   => [
                                                'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/><em class="help-block">'
                                                    . __(USER_MSG_0009) . '</em>',
                                            ],
                                        ]
                                    );
                                    echo $this->Form->control('name', [
                                            'class'       => 'form-control',
                                            'placeholder' => 'Nguyen Van A',
                                            'required'    => false,
                                        ]
                                    );
                                    ?>
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
                                            <a href="/filemanager/dialog.php?type=0&field_id=Image&relative_url=1&akey=<?php echo FILE_ACCESS_KEY; ?>"
                                               class="btn btn-success iframe-btn"
                                               type="button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>Image...</span>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                    echo $this->Form->control('note', [
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
                                            'class'   => 'form-control',
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
                                                    . date('Y/m/d',
                                                        strtotime($user->birthday))
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
                                    echo $this->Form->control('status', [
                                            'class'   => 'form-control',
                                            'options' => [
                                                ENABLED         => 'Enabled',
                                                DISABLED        => 'Disabled',
                                                TRASH           => 'Trash',
                                                REGISTER_STATUS => 'Register',
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

$('.datetimepicker4').datepicker({
    format: "yyyy-mm-dd",
    autoclose: true
});

$('.clickImg').on('click', function () {
CKFinder.popup({
chooseFiles: true,
width: 800,
height: 600,
onInit: function (finder) {
finder.on('files:choose', function (evt) {
var file = evt.data.files.first();
var output = document.getElementById('Image');
output.value = location.protocol + "//" + location.host+file.getUrl();
});

finder.on('file:choose:resizedImage', function (evt) {
var output = document.getElementById('Image');
output.value = evt.data.resizedUrl;
});
}
});
});
});
<?php echo $this->Html->scriptEnd();
echo $this->element('Admin/Editor/popup');
?>
