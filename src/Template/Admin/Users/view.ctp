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
$backLink  = $this->Html->link(
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
                            <?php echo $this->Form->create($user, [
                                'type' => 'get',
                                'url'  => ['action' => 'edit', $user->id],
                            ]);
                            ?>
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
                                            'required'    => false,
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
                                    echo $this->Form->control('about_me', [
                                            'class'       => 'form-control',
                                            'placeholder' => 'About me',
                                            'typr'        => 'textarea',
                                            'required'    => false,
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
                                            'required'    => false,
                                            'disabled'    => true,
                                        ]
                                    );
                                    echo $this->Form->control('phone', [
                                            'class'       => 'form-control',
                                            'placeholder' => '0987654321',
                                            'required'    => false,
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
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Html->scriptStart(['block' => true]); ?>
//<script>
    $(document).ready(function () {
        function messageToastr(mess, success) {
            setTimeout(function () {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                if (success) {
                    toastr.success(mess, 'Thông báo');
                } else {
                    toastr.error(mess, 'Thông báo');
                }
            }, 500);
        }

        $('.deleteAjax').on('click', function () {
            var url = $(this).attr('data-url');
            var tr = $(this).parents('tr');
            if (confirm("Xác nhận xóa !")) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    success: function (result) {
                        var obj = JSON.parse(result);
                        if (obj.success) {
                            messageToastr(obj.message, true);
                            tr.remove();
                        } else {
                            messageToastr(obj.message, false);
                        }
                    },
                    error: function (result) {
                        var obj = JSON.parse(result);
                        messageToastr('<?php echo COMMON_MSG_0004 ?>', false);
                    }
                });
            }
        });
        $('.editAjax').on('click', function () {
            var url = $(this).attr('data-url');
            var controller = $(this).attr('data-control');
            var displayD = $(this).attr('data-display');
            var name = $(this).parents('tr').children('.info-name');
            var des = $(this).parents('tr').children('.info-des').children();
            var dateS = $(this).parents('tr').children('.info-date-s');
            var dateE = $(this).parents('tr').children('.info-date-e');
            $('.modal-body').html('');

            function tempalteAP(lable, name, value, type, classD) {
                if (type) {
                    $('.modal-body').append('<div class="form-group"><label class="col-sm-3 text-ctr">' + lable + '</label>' +
                        '<div class="col-sm-9 ip-lb"><textarea name="' + name + '" class="form-control">' + value.trim() + '</textarea></div></div>');
                } else {
                    $('.modal-body').append('<div class="form-group"><label class="col-sm-3 text-ctr">' + lable + '</label>' +
                        '<div class="col-sm-9 ip-lb"><input name="' + name + '" class="form-control ' + classD + '" type="text" value="' + value.trim() + '"/></div></div>');
                }
            }

            tempalteAP('Name', 'name', name.html(), false);
            tempalteAP('Description', 'description', des.html(), true);
            if (displayD) {
                if (controller !== 'UserPrizes') {
                    tempalteAP('Start date', 'start_date', dateS.html(), false, 'dtpStart');
                    tempalteAP('End date', 'end_date', dateE.html(), false, 'dtpEnd');
                } else {
                    tempalteAP('Start date', 'start_date', dateS.html(), false, 'datetimepicker');
                }
            }
            $('.dtpStart').datetimepicker({
                format: "YYYY-MM-DD hh:mm:ss"
            });
            $('.dtpEnd').datetimepicker({
                useCurrent: false,
                format: "YYYY-MM-DD hh:mm:ss"
            });
            $('.dtpStart').on('dp.change', function (e) {
                $('.dtpEnd').data('DateTimePicker').minDate(e.date);
            });
            $('.dtpEnd').on('dp.change', function (e) {
                $('.dtpStart').data('DateTimePicker').maxDate(e.date);
            });
            $('.datetimepicker').datetimepicker({
                format: "YYYY-MM-DD hh:mm:ss"
            });

            $('#modal-form').unbind(); // reset event
            $('#modal-form').submit(function (e) {
                e.preventDefault();
                dataF = $("#modal-form").serialize();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: dataF,
                    success: function (result) {
                        var obj = JSON.parse(result);
                        if (obj.success) {
                            messageToastr(obj.message, true);
                            name.html(obj.data['name']);
                            des.html(obj.data['description']);
                            dateS.html(obj.data['start_date']);
                            dateE.html(obj.data['end_date']);
                            $('#myModal').modal("hide");
                        } else {
                            messageToastr(obj.message, false);
                        }
                    },
                    error: function (data) {
                        var obj = JSON.parse(result);
                        messageToastr('<?php echo COMMON_MSG_0002 ?>', false);
                    }
                });
            });
        });
    });
    <?php echo $this->Html->scriptEnd(); ?>
