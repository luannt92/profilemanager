<?php echo $this->element('Admin/breadcrumb', [
    'title' => 'Site’s Configuration',
]);

echo $this->Html->css(
    [
        'admin/plugins/select2/select2.min.css',
        'admin/jquery.fancybox.min.css',
        'admin/plugins/summernote/summernote.css',
        'admin/plugins/summernote/summernote-bs3.css',
    ],
    ['block' => true]
);

echo $this->Html->script(
    [
        'admin/plugins/select2/select2.full.min.js',
        'summernote.min.js',
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
        'inputContainer' => '<div class="form-group">
                <div class="form-group {{type}} ">{{content}}</div></div>',
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

$userName           = $this->Form->control('site_mail_username', [
        'class'       => 'form-control',
        'placeholder' => 'abcxxxx',
        'required'    => false,
        'error'       => isset($errors['site_mail_username'])
            ? $errors['site_mail_username'] : '',
    ]
);
$password           = $this->Form->control('site_mail_password', [
        'class'       => 'form-control',
        'placeholder' => 'xxxxxxxxx',
        'type'        => 'password',
        'required'    => false,
        'error'       => isset($errors['site_mail_password'])
            ? $errors['site_mail_password'] : '',
    ]
);
$port               = $this->Form->control('site_mail_port', [
        'class'       => 'form-control',
        'placeholder' => '25',
        'type'        => 'number',
        'required'    => false,
        'error'       => isset($errors['site_mail_port'])
            ? $errors['site_mail_port'] : '',
    ]
);
$timeout            = $this->Form->control('site_mail_timeout', [
        'class'       => 'form-control',
        'placeholder' => '30',
        'type'        => 'number',
        'required'    => false,
        'error'       => isset($errors['site_mail_timeout'])
            ? $errors['site_mail_timeout'] : '',
    ]
);
$number             = $this->Form->control('site_mail_number', [
        'class'       => 'form-control',
        'placeholder' => '100',
        'type'        => 'number',
        'required'    => false,
        'error'       => isset($errors['site_mail_number'])
            ? $errors['site_mail_number'] : '',
    ]
);
$siteName           = $this->Form->control('site_name', [
        'class'       => 'form-control',
        'placeholder' => 'Site name',
        'autofocus'   => true,
        'required'    => false,
        'error'       => isset($errors['site_name']) ? $errors['site_name'] : '',
    ]
);
$email              = $this->Form->control('site_mail', [
        'class'       => 'form-control',
        'placeholder' => 'email@gmail.com',
        'type'        => 'email',
        'error'       => isset($errors['site_mail']) ? $errors['site_mail']
            : '',
    ]
);
$slogan             = $this->Form->control('site_slogan', [
        'class'       => 'form-control',
        'placeholder' => 'Site slogan',
        'error'       => isset($errors['site_slogan']) ? $errors['site_slogan'] : '',
    ]
);
$description        = $this->Form->control('site_description', [
        'class'       => 'form-control',
        'placeholder' => 'Site description',
        'type'        => 'textarea',
        'error'       => isset($errors['site_description'])
            ? $errors['site_description'] : '',
    ]
);
$about              = $this->Form->control('site_about', [
        'class'       => 'form-control',
        'placeholder' => 'Site about',
        'type'        => 'textarea',
        'error'       => isset($errors['site_about'])
            ? $errors['site_about'] : '',
    ]
);
$tag              = $this->Form->control('site_tag', [
        'class'       => 'form-control',
        'placeholder' => 'Google analytic,...',
        'type'        => 'textarea',
        'error'       => isset($errors['site_tag'])
            ? $errors['site_tag'] : '',
    ]
);
$language           = $this->Form->control('site_language', [
        'class'   => 'form-control',
        'options' => [
            VI_VN => 'Tiếng việt',
        ],
        'error'   => isset($errors['site_language']) ? $errors['site_language']
            : '',
    ]
);
//$logoHeader         = $this->Form->control('site_logo_header', [
//        'class'       => 'form-control',
//        'type'        => 'text',
//        'id'          => 'logo_header',
//        'label'       => ['class' => 'control-label'],
//        'placeholder' => 'Logo header url',
//        'error'       => isset($errors['site_logo_header'])
//            ? $errors['site_logo_header'] : '',
//    ]
//);
$logoFooter         = $this->Form->control('site_logo_footer', [
        'class'       => 'form-control',
        'type'        => 'text',
        'id'          => 'logo_footer',
        'label'       => ['class' => 'control-label'],
        'placeholder' => 'Logo footer url',
        'error'       => isset($errors['site_logo_footer'])
            ? $errors['site_logo_footer'] : '',
    ]
);
$facebook           = $this->Form->control('site_facebook', [
        'class'       => 'form-control',
        'type'        => 'text',
        'label'       => ['class' => 'control-label'],
        'placeholder' => 'Link facebook',
        'error'       => isset($errors['site_facebook'])
            ? $errors['site_facebook'] : '',
    ]
);
$linked            = $this->Form->control('site_linked', [
        'class'       => 'form-control',
        'type'        => 'text',
        'label'       => ['class' => 'control-label'],
        'placeholder' => 'Linked',
        'error'       => isset($errors['site_linked'])
            ? $errors['site_linked'] : '',
    ]
);
$twitter            = $this->Form->control('site_twitter', [
        'class'       => 'form-control',
        'type'        => 'text',
        'label'       => ['class' => 'control-label'],
        'placeholder' => 'Link twitter',
        'error'       => isset($errors['site_twitter'])
            ? $errors['site_twitter'] : '',
    ]
);
$phoneNumber        = $this->Form->control('site_phone', [
        'class'       => 'form-control',
        'placeholder' => '0123 814 6189',
        'error'       => isset($errors['site_phone'])
            ? $errors['site_phone'] : '',
    ]
);
$owner              = $this->Form->control('contact_owner', [
        'class'       => 'form-control',
        'placeholder' => 'Contact owner',
        'error'       => isset($errors['contact_owner'])
            ? $errors['contact_owner'] : '',
    ]
);
$contactDescription = $this->Form->control('contact_description', [
        'class'       => 'form-control',
        'placeholder' => 'description',
        'type'        => 'textarea',
        'rows'        => 8,
        'error'       => isset($errors['contact_description'])
            ? $errors['contact_description'] : '',
    ]
);
$seoTitle             = $this->Form->control('seo_title', [
        'class'       => 'form-control',
        'placeholder' => 'Site slogan',
        'error'       => isset($errors['seo_title']) ? $errors['seo_title']
            : '',
    ]
);
$seoKeyword             = $this->Form->control('seo_keyword', [
        'class'       => 'form-control',
        'placeholder' => 'Từ khóa',
        'type'        => 'textarea',
        'rows'        => 4,
        'error'       => isset($errors['seo_keyword'])
            ? $errors['seo_keyword'] : '',
    ]
);
$seoDescription             = $this->Form->control('seo_description', [
        'class'       => 'form-control',
        'placeholder' => 'Mô tả',
        'type'        => 'textarea',
        'rows'        => 8,
        'error'       => isset($errors['seo_description'])
            ? $errors['seo_description'] : '',
    ]
);
$submit             = $this->Form->button(
    __(SAVE_CHANGE), [
        'type'  => 'submit',
        'class' => 'btn btn-primary block m-b',
    ]
);
$banner         = $this->Form->control('site_banner_popup', [
        'class'       => 'form-control',
        'type'        => 'text',
        'id'          => 'site_banner_popup',
        'label'       => ['class' => 'control-label'],
        'placeholder' => 'Logo footer url',
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
                            SEO</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                    echo $siteName;
                                    echo $description;
                                    echo $about;
                                    echo $tag;
//                                    echo $logoHeader;
//                                    echo '<a href="/filemanager/dialog.php?type=1&field_id=logo_header&relative_url=0"
//                                           class="btn btn-success iframe-btn"
//                                           type="button">
//                                            <i class="glyphicon glyphicon-plus"></i>
//                                            <span>Image...</span>
//                                        </a>';
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    echo $slogan;
                                    echo $facebook;
                                    echo $linked;
                                    echo $twitter;
                                    echo $language;
                                    echo $logoFooter;
                                    echo '<a href="/filemanager/dialog.php?type=1&field_id=logo_footer&relative_url=0"
                                           class="btn btn-success iframe-btn m-b-md"
                                           type="button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Image...</span>
                                        </a>';
                                    echo $banner;
                                    echo '<a href="/filemanager/dialog.php?type=1&field_id=site_banner_popup&relative_url=0"
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
                                    <?php
                                    echo $hostName;
                                    echo $userName;
                                    echo $password;
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    echo $port;
                                    echo $timeout;
                                    echo $number;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                    echo $email;
                                    echo $phoneNumber;
                                    echo $owner;
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    echo $contactDescription;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                    echo $seoTitle;
                                    echo $seoKeyword;
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    echo $seoDescription;
                                    ?>
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
    $('.iframe-btnf').fancybox({
        'width': 900,
        'height': 600,
        'type': 'iframe',
        'autoScale': false
    });
    $(document).ready(function () {
        $('#site-about').summernote();
    });
    <?php echo $this->Html->scriptEnd(); ?>
