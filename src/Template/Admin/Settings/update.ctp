<?php echo $this->element('Admin/breadcrumb', [
    'title' => 'Site’s Configuration',
]);

echo $this->Html->css(
    [
        'admin/plugins/select2/select2.min.css',
        'admin/plugins/clockpicker/clockpicker.css',
        'admin/jquery.fancybox.min.css',
    ],
    ['block' => true]
);

echo $this->Html->script(
    [
        'admin/plugins/select2/select2.full.min.js',
        'admin/plugins/clockpicker/clockpicker.js',
    ],
    ['block' => true]
);
echo $this->Html->script(
    [
        'admin/jquery.fancybox.min.js',
    ],
    ['block' => 'scriptBottom']
);
$this->Form->setTemplates(
    [
        'inputContainer' => '{{content}}',
        'formGroup'      => '<div class="form-group group-input">
                <div class="form-group group-input-child {{type}} ">{{label}}{{input}}
                {{switch}}</div></div>',
    ]
);

echo $this->Form->create($settingForm);

$hostName = $this->Form->control('site_mail_hostname', [
        'class'       => 'form-control',
        'placeholder' => 'smtp.gmail.com',
        'required'    => false,
        'error'       => isset($errors['site_mail_hostname'])
            ? $errors['site_mail_hostname'] : '',
    ]
);

$userName    = $this->Form->control('site_mail_username', [
        'class'       => 'form-control',
        'placeholder' => 'abcxxxx',
        'required'    => false,
        'error'       => isset($errors['site_mail_username'])
            ? $errors['site_mail_username'] : '',
    ]
);
$password    = $this->Form->control('site_mail_password', [
        'class'       => 'form-control',
        'placeholder' => 'xxxxxxxxx',
        'type'        => 'password',
        'required'    => false,
        'error'       => isset($errors['site_mail_password'])
            ? $errors['site_mail_password'] : '',
    ]
);
$port        = $this->Form->control('site_mail_port', [
        'class'       => 'form-control',
        'placeholder' => '25',
        'type'        => 'number',
        'required'    => false,
        'error'       => isset($errors['site_mail_port'])
            ? $errors['site_mail_port'] : '',
    ]
);
$timeout     = $this->Form->control('site_mail_timeout', [
        'class'       => 'form-control',
        'placeholder' => '30',
        'type'        => 'number',
        'required'    => false,
        'error'       => isset($errors['site_mail_timeout'])
            ? $errors['site_mail_timeout'] : '',
    ]
);
$number      = $this->Form->control('site_mail_number', [
        'class'       => 'form-control',
        'placeholder' => '100',
        'type'        => 'number',
        'required'    => false,
        'error'       => isset($errors['site_mail_number'])
            ? $errors['site_mail_number'] : '',
    ]
);
$siteName    = $this->Form->control('site_name', [
        'class'       => 'form-control',
        'placeholder' => 'Site name',
        'autofocus'   => true,
        'required'    => false,
        'error'       => isset($errors['site_name']) ? $errors['site_name']
            : '',
    ]
);
$description = $this->Form->control('site_description', [
        'class'       => 'form-control',
        'placeholder' => 'Site description',
        'type'        => 'textarea',
        'error'       => isset($errors['site_description'])
            ? $errors['site_description'] : '',
    ]
);
$email       = $this->Form->control('me_mail', [
        'class'       => 'form-control',
        'placeholder' => 'email@gmail.com',
        'type'        => 'email',
        'error'       => isset($errors['me_mail']) ? $errors['me_mail']
            : '',
    ]
);
$aboutVi     = $this->Form->control('me_about_vi', [
        'class'       => 'form-control',
        'placeholder' => 'About',
        'type'        => 'textarea',
        'error'       => isset($errors['me_about_vi']) ? $errors['me_about_vi']
            : '',
    ]
);
$aboutEn     = $this->Form->control('me_about_en', [
        'class'       => 'form-control',
        'placeholder' => 'About',
        'type'        => 'textarea',
        'error'       => isset($errors['me_about_en']) ? $errors['me_about_en']
            : '',
    ]
);
$birthday    = $this->Form->control('me_birthday', [
        'class'       => 'form-control',
        'placeholder' => 'Birth day',
        'error'       => isset($errors['me_birthday'])
            ? $errors['me_birthday'] : '',
    ]
);
$phone       = $this->Form->control('me_phone', [
        'class'       => 'form-control',
        'placeholder' => 'Phone number',
        'type'        => 'number',
        'error'       => isset($errors['me_phone'])
            ? $errors['me_phone'] : '',
    ]
);
$addressVi   = $this->Form->control('me_address_vi', [
        'class'       => 'form-control',
        'placeholder' => 'Address vietnamese',
        'error'       => isset($errors['me_address_vi'])
            ? $errors['me_address_vi'] : '',
    ]
);

$addressEn = $this->Form->control('me_address_en', [
        'class'       => 'form-control',
        'placeholder' => 'Address english',
        'error'       => isset($errors['site_address_en'])
            ? $errors['site_address_en'] : '',
    ]
);

$language = $this->Form->control('site_language', [
        'class'   => 'form-control',
        'options' => [
            VI_VN => 'Tiếng việt',
        ],
        'error'   => isset($errors['site_language']) ? $errors['site_language']
            : '',
    ]
);

$logoFooter       = $this->Form->control('site_logo_footer', [
        'class'        => 'form-control',
        'type'         => 'text',
        'id'           => 'logo_footer',
        'label'        => ['class' => 'control-label'],
        'placeholder'  => 'Logo footer url',
        'error'        => isset($errors['site_logo_footer'])
            ? $errors['site_logo_footer'] : '',
        'templateVars' => [
            'switch' => '<div class="input-switcher"><input type="checkbox" class="js-switch"/></div>',
        ],
    ]
);
$seoTitleEn       = $this->Form->control('meta_title_en', [
        'class'       => 'form-control',
        'placeholder' => 'Meta title english',
        'error'       => isset($errors['meta_title_en'])
            ? $errors['meta_title_en']
            : '',
    ]
);
$seoKeywordEn     = $this->Form->control('meta_keyword_en', [
        'class'       => 'form-control',
        'placeholder' => 'Meta keyword english',
        'type'        => 'textarea',
        'rows'        => 4,
        'error'       => isset($errors['meta_keyword_en'])
            ? $errors['meta_keyword_en'] : '',
    ]
);
$seoDescriptionEn = $this->Form->control('meta_description_en', [
        'class'       => 'form-control',
        'placeholder' => 'Meta description english',
        'type'        => 'textarea',
        'rows'        => 8,
        'error'       => isset($errors['meta_description_en'])
            ? $errors['meta_description_en'] : '',
    ]
);
$seoTitleVi       = $this->Form->control('meta_title_vi', [
        'class'       => 'form-control',
        'placeholder' => 'Meta title vietnamese',
        'error'       => isset($errors['meta_title_vi'])
            ? $errors['meta_title_vi']
            : '',
    ]
);
$seoKeywordVi     = $this->Form->control('meta_keyword_vi', [
        'class'       => 'form-control',
        'placeholder' => 'Meta keyword vietnamese',
        'type'        => 'textarea',
        'rows'        => 4,
        'error'       => isset($errors['meta_keyword_vi'])
            ? $errors['meta_keyword_vi'] : '',
    ]
);
$seoDescriptionVi = $this->Form->control('meta_description_vi', [
        'class'       => 'form-control',
        'placeholder' => 'Meta description vietnamese',
        'type'        => 'textarea',
        'rows'        => 8,
        'error'       => isset($errors['meta_description_vi'])
            ? $errors['meta_description_vi'] : '',
    ]
);
$submit           = $this->Form->button(
    __(SAVE_CHANGE), [
        'type'  => 'submit',
        'class' => 'btn btn-primary block m-b',
    ]
);
$banner           = $this->Form->control('site_banner_popup', [
        'class'       => 'form-control',
        'type'        => 'text',
        'id'          => 'site_banner_popup',
        'label'       => ['class' => 'control-label'],
        'placeholder' => __('Banner popup in homepage'),
        'error'       => isset($errors['site_banner_popup'])
            ? $errors['site_banner_popup'] : '',
    ]
);
?>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1">
                            Hệ thống</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-2">
                            Mail</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3">
                            Liên Hệ</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-4">
                            Translate</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                    echo $siteName;
                                    echo $description;
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    echo $language;
                                    echo $banner;
                                    echo '<a href="/filemanager/dialog.php?type=0&field_id=site_banner_popup&relative_url=1&akey='
                                        . FILE_ACCESS_KEY . '"
                                           class="btn btn-success iframe-btn m-b-md"
                                           type="button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Image...</span>
                                        </a>';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo $hostName;
                                    echo $userName;
                                    echo $password; ?>
                                </div>
                                <div class="col-md-6">
                                    <?php echo $port;
                                    echo $timeout;
                                    echo $number; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                    echo $aboutVi;
                                    echo $aboutEn;
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    echo $email;
                                    echo $birthday;
                                    echo $phone;
                                    echo $addressVi;
                                    echo $addressEn; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab"
                                                          href="#tab-100">
                                            English</a></li>
                                    <li class=""><a data-toggle="tab"
                                                    href="#tab-101">
                                            Vietnamese</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-100" class="tab-pane active">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php echo $seoTitleEn;
                                                echo $seoKeywordEn; ?>
                                            </div>
                                            <div class="col-md-6">
                                                <?php echo $seoDescriptionEn; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-101" class="tab-pane">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php echo $seoTitleVi;
                                                echo $seoKeywordVi; ?>
                                            </div>
                                            <div class="col-md-6">
                                                <?php echo $seoDescriptionVi; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-t-sm pull-right">
                <?php echo $submit; ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end();
echo $this->element('Admin/Editor/popup');
?>

<?php echo $this->Html->scriptStart(['block' => true]); ?>
//
<script>
    $('.iframe-btn').fancybox({
        'width': 900,
        'height': 600,
        'type': 'iframe',
        'autoScale': false
    });

    function alertMsg(result) {
        setTimeout(function () {
            toastr.options = {
                closeButton: true,
                preventDuplicates: false,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 2000
            };
            if (result.status) {
                toastr.success(result.message, 'Thông báo');
            } else {
                toastr.error(result.message, 'Thông báo');
            }
        }, 500);
    }

    $(document).ready(function () {
        $('.clockpicker').clockpicker();
    });
    <?php echo $this->Html->scriptEnd(); ?>
