<?php echo $this->element('Admin/breadcrumb', [
    'title' => 'Site’s Configuration',
]);

echo $this->Html->css(
    [
        'admin/plugins/select2/select2.min.css',
        'admin/plugins/clockpicker/clockpicker.css',
        'admin/jquery.fancybox.min.css',
        'admin/plugins/switchery/switchery.css',
    ],
    ['block' => true]
);

echo $this->Html->script(
    [
        'admin/plugins/select2/select2.full.min.js',
        'admin/plugins/switchery/switchery.js',
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
$email       = $this->Form->control('site_mail', [
        'class'       => 'form-control',
        'placeholder' => 'email@gmail.com',
        'type'        => 'email',
        'error'       => isset($errors['site_mail']) ? $errors['site_mail']
            : '',
    ]
);
$slogan      = $this->Form->control('site_slogan', [
        'class'       => 'form-control',
        'placeholder' => 'Site slogan',
        'error'       => isset($errors['site_slogan']) ? $errors['site_slogan']
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
$about       = $this->Form->control('site_about', [
        'class'       => 'form-control',
        'placeholder' => 'Site about',
        'type'        => 'textarea',
        'error'       => isset($errors['site_about'])
            ? $errors['site_about'] : '',
    ]
);
$tag         = $this->Form->control('site_tag', [
        'class'       => 'form-control',
        'placeholder' => 'Google analytic,...',
        'type'        => 'textarea',
        'error'       => isset($errors['site_tag'])
            ? $errors['site_tag'] : '',
    ]
);
$language    = $this->Form->control('site_language', [
        'class'   => 'form-control',
        'options' => [
            VI_VN => 'Tiếng việt',
        ],
        'error'   => isset($errors['site_language']) ? $errors['site_language']
            : '',
    ]
);

$logoFooter         = $this->Form->control('site_logo_footer', [
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
$facebook           = $this->Form->control('site_facebook', [
        'class'       => 'form-control',
        'type'        => 'text',
        'label'       => ['class' => 'control-label'],
        'placeholder' => 'Link facebook',
        'error'       => isset($errors['site_facebook'])
            ? $errors['site_facebook'] : '',
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
$seoTitleEn           = $this->Form->control('meta_title_en', [
        'class'       => 'form-control',
        'placeholder' => 'Meta title english',
        'error'       => isset($errors['meta_title_en']) ? $errors['meta_title_en']
            : '',
    ]
);
$seoKeywordEn         = $this->Form->control('meta_keyword_en', [
        'class'       => 'form-control',
        'placeholder' => 'Meta keyword english',
        'type'        => 'textarea',
        'rows'        => 4,
        'error'       => isset($errors['meta_keyword_en'])
            ? $errors['meta_keyword_en'] : '',
    ]
);
$seoDescriptionEn     = $this->Form->control('meta_description_en', [
        'class'       => 'form-control',
        'placeholder' => 'Meta description english',
        'type'        => 'textarea',
        'rows'        => 8,
        'error'       => isset($errors['meta_description_en'])
            ? $errors['meta_description_en'] : '',
    ]
);
$seoTitleVi           = $this->Form->control('meta_title_vi', [
        'class'       => 'form-control',
        'placeholder' => 'Meta title vietnamese',
        'error'       => isset($errors['meta_title_vi']) ? $errors['meta_title_vi']
            : '',
    ]
);
$seoKeywordVi         = $this->Form->control('meta_keyword_vi', [
        'class'       => 'form-control',
        'placeholder' => 'Meta keyword vietnamese',
        'type'        => 'textarea',
        'rows'        => 4,
        'error'       => isset($errors['meta_keyword_vi'])
            ? $errors['meta_keyword_vi'] : '',
    ]
);
$seoDescriptionVi     = $this->Form->control('meta_description_vi', [
        'class'       => 'form-control',
        'placeholder' => 'Meta description vietnamese',
        'type'        => 'textarea',
        'rows'        => 8,
        'error'       => isset($errors['meta_description_vi'])
            ? $errors['meta_description_vi'] : '',
    ]
);
$submit             = $this->Form->button(
    __(SAVE_CHANGE), [
        'type'  => 'submit',
        'class' => 'btn btn-primary block m-b',
    ]
);
$zalo               = $this->Form->control('contact_zalo', [
        'class'       => 'form-control',
        'type'        => 'text',
        'label'       => ['class' => 'control-label'],
        'placeholder' => 'Zalo',
        'error'       => isset($errors['contact_zalo'])
            ? $errors['contact_zalo'] : '',
    ]
);
$viber              = $this->Form->control('contact_viber', [
        'class'       => 'form-control',
        'type'        => 'text',
        'label'       => ['class' => 'control-label'],
        'placeholder' => 'Viber',
        'error'       => isset($errors['contact_viber'])
            ? $errors['contact_viber'] : '',
    ]
);
$whatsapp           = $this->Form->control('contact_whatsapp', [
        'class'       => 'form-control',
        'type'        => 'text',
        'label'       => ['class' => 'control-label'],
        'placeholder' => 'Whatsapp',
        'error'       => isset($errors['contact_whatsapp'])
            ? $errors['contact_whatsapp'] : '',
    ]
);
$appAndroid         = $this->Form->control('download_android', [
        'class'        => 'form-control',
        'type'         => 'text',
        'label'        => ['class' => 'control-label'],
        'placeholder'  => 'Link app Android',
        'error'        => isset($errors['download_android'])
            ? $errors['download_android'] : '',
        'templateVars' => [
            'switch' => '<div class="input-switcher"><input type="checkbox" class="js-switch"/></div>',
        ],
    ]
);
$appIOS             = $this->Form->control('download_ios', [
        'class'        => 'form-control',
        'type'         => 'text',
        'label'        => ['class' => 'control-label'],
        'placeholder'  => 'Link app IOS',
        'error'        => isset($errors['download_ios'])
            ? $errors['download_ios'] : '',
        'templateVars' => [
            'switch' => '<div class="input-switcher"><input type="checkbox" class="js-switch"/></div>',
        ],
    ]
);
$addressVi            = $this->Form->control('site_address_vi', [
        'class'       => 'form-control',
        'placeholder' => 'Site address vietnamese',
        'type'        => 'textarea',
        'error'       => isset($errors['site_address_vi'])
            ? $errors['site_address_vi'] : '',
    ]
);

$addressEn            = $this->Form->control('site_address_en', [
        'class'       => 'form-control',
        'placeholder' => 'Site address english',
        'type'        => 'textarea',
        'error'       => isset($errors['site_address_en'])
            ? $errors['site_address_en'] : '',
    ]
);

$typeLayout         = $this->Form->control('site_layout_product', [
        'class'   => 'form-control',
        'options' => \Cake\Core\Configure::read('type_layout'),
        'label'   => 'Layout',
        'error'   => isset($errors['site_layout_product'])
            ? $errors['site_layout_product'] : '',
    ]
);
$minPrice           = $this->Form->control('site_min_price', [
        'class'       => 'form-control',
        'placeholder' => '150000',
        'label'       => 'Minimum price',
        'error'       => isset($errors['site_min_price'])
            ? $errors['site_min_price'] : '',
    ]
);
$zaloOAID           = $this->Form->control('site_zalo_id', [
        'class'       => 'form-control',
        'type'        => 'text',
        'label'       => ['class' => 'control-label'],
        'placeholder' => 'OA ID',
        'error'       => isset($errors['site_zalo_id'])
            ? $errors['site_zalo_id'] : '',
    ]
);
$zaloOAKey          = $this->Form->control('site_zalo_key', [
        'class'       => 'form-control',
        'type'        => 'text',
        'label'       => ['class' => 'control-label'],
        'placeholder' => 'OA Secret',
        'error'       => isset($errors['site_zalo_key'])
            ? $errors['site_zalo_key'] : '',
    ]
);
$zaloPhones         = $this->Form->control('site_zalo_phones', [
        'class'       => 'form-control',
        'type'        => 'text',
        'label'       => ['class' => 'control-label'],
        'placeholder' => '84xxxxxxxx,84yyyyyyyyyy',
        'error'       => isset($errors['site_zalo_phones'])
            ? $errors['site_zalo_phones'] : '',
        'templates'   => [
            'inputContainer' => '<div class="form-group">
                <div class="form-group {{type}} ">{{content}}
                <span class="help-block m-b-none">' . NOTE_SETTING_ZALO_OA . '
                </span></div></div>',
        ],
    ]
);
$zaloMessage        = $this->Form->control('site_zalo_message', [
        'class'       => 'form-control',
        'type'        => 'textarea',
        'label'       => ['class' => 'control-label'],
        'placeholder' => 'Message',
        'error'       => isset($errors['site_zalo_message'])
            ? $errors['site_zalo_message'] : '',
    ]
);
$saleOffVi           = $this->Form->control('site_sale_off_vi', [
        'class'       => 'form-control',
        'placeholder' => 'Order 500k được tặng 1 mũ bảo hiểm',
        'label'       => 'Sale off Vietnamese',
        'error'       => isset($errors['site_sale_off_vi'])
            ? $errors['site_sale_off_vi'] : '',
    ]
);
$saleOffEn           = $this->Form->control('site_sale_off_en', [
        'class'       => 'form-control',
        'placeholder' => 'Order 500k donated 1 helmet',
        'label'       => 'Sale off English',
        'error'       => isset($errors['site_sale_off_en'])
            ? $errors['site_sale_off_en'] : '',
    ]
);
$linkSaleOffVi       = $this->Form->control('site_sale_off_link_vi', [
        'class'       => 'form-control',
        'placeholder' => 'http://',
        'label'       => 'Link to sale off Vietnamese',
        'error'       => isset($errors['site_sale_off_link_vi'])
            ? $errors['site_sale_off_link_vi'] : '',
    ]
);
$linkSaleOffEn           = $this->Form->control('site_sale_off_link_en', [
        'class'       => 'form-control',
        'placeholder' => 'http://',
        'label'       => 'Link to sale off English',
        'error'       => isset($errors['site_sale_off_link_en'])
            ? $errors['site_sale_off_link_en'] : '',
    ]
);
$banner              = $this->Form->control('site_banner_popup', [
        'class'       => 'form-control',
        'type'        => 'text',
        'id'          => 'site_banner_popup',
        'label'       => ['class' => 'control-label'],
        'placeholder' => __('Banner popup in homepage'),
        'error'       => isset($errors['site_banner_popup'])
            ? $errors['site_banner_popup'] : '',
        'templateVars' => [
            'switch' => '<div class="input-switcher"><input type="checkbox" class="js-switch"/></div>',
        ],
    ]
);
$linkBanner          = $this->Form->control('site_banner_popup_link', [
        'class'       => 'form-control',
        'placeholder' => 'http://',
        'label'       => 'Link to banner',
        'error'       => isset($errors['site_banner_popup_link'])
            ? $errors['site_banner_popup_link'] : '',
    ]
);
$linkZone          = $this->Form->control('link_zone', [
        'class'       => 'form-control',
        'placeholder' => 'Link Zone',
        'label'       => 'Link to Zone',
        'error'       => isset($errors['link_zone'])
            ? $errors['link_zone'] : '',
    ]
);
$tagTrackingPopup    = $this->Form->control('site_tracking_popup', [
        'class'       => 'form-control',
        'placeholder' => "ga('send','event','Click popup homepage', 'click');",
        'type'        => 'textarea',
        'error'       => isset($errors['site_tracking_popup'])
            ? $errors['site_tracking_popup'] : '',
    ]
);
$mailReceipt = $this->Form->control('site_mail_order_receipt', [
    'class'       => 'form-control',
    'type'        => 'text',
    'error'       => isset($errors['site_mail_order_receipt'])
        ? $errors['site_mail_order_receipt'] : '',
    'label' => __('Mail nhận order (cách nhau bằng dấu ,)')
]);
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
                            Product</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-5">
                            Message Configuration</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-6">
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
                                    echo $about;
                                    echo $tag;
                                    echo $tagTrackingPopup;
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    echo $slogan;
                                    echo $facebook;
                                    echo $language;
                                    echo $appAndroid;
                                    echo $appIOS;
                                    echo $logoFooter;
                                    echo '<a href="/filemanager/dialog.php?type=0&field_id=logo_footer&relative_url=1&akey='. FILE_ACCESS_KEY .'"
                                           class="btn btn-success iframe-btn m-b-md"
                                           type="button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Image...</span>
                                        </a>';
                                    echo $banner;
                                    echo '<a href="/filemanager/dialog.php?type=0&field_id=site_banner_popup&relative_url=1&akey='. FILE_ACCESS_KEY.'"
                                           class="btn btn-success iframe-btn m-b-md"
                                           type="button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Image...</span>
                                        </a>';
                                    echo $linkBanner;
                                    echo $linkZone;
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
                                    echo $viber;
                                    echo $zalo;
                                    echo $whatsapp;
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
                                    echo $minPrice;
                                    echo $typeLayout;
                                    echo $mailReceipt;
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <?php echo __(OPEN_HOUR) ?>
                                        </label>
                                        <?php echo $this->Form->control('time_open',
                                            [
                                                'class'     => 'form-control clockpicker',
                                                'required'  => false,
                                                'templates' => [
                                                    'formGroup' => '
                                                <div class="input-group clockpicker" data-autoclose="true">
                                                    {{input}}
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-clock-o"></span>
                                                    </span>
                                                </div>',
                                                ],
                                            ]
                                        ); ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <?php echo __(CLOSE_HOUR) ?>
                                        </label>
                                        <?php echo $this->Form->control('time_close',
                                            [
                                                'class'     => 'form-control clockpicker',
                                                'required'  => false,
                                                'templates' => [
                                                    'formGroup' => '
                                                <div class="input-group clockpicker" data-autoclose="true">
                                                    {{input}}
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-clock-o"></span>
                                                    </span>
                                                </div>',
                                                ],
                                            ]
                                        ); ?>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-5" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                    echo $zaloOAID;
                                    echo $zaloOAKey;
                                    echo $zaloPhones;
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    echo $zaloMessage;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-6" class="tab-pane">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-100">
                                            English</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-101">
                                            Vietnamese</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-100" class="tab-pane active">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php
                                                echo $seoTitleEn;
                                                echo $seoKeywordEn;
                                                ?>
                                            </div>
                                            <div class="col-md-6">
                                                <?php
                                                echo $seoDescriptionEn;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php
                                                echo $saleOffEn;
                                                echo $linkSaleOffEn;
                                                ?>
                                            </div>
                                            <div class="col-md-6">
                                                <?php echo $addressEn; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-101" class="tab-pane">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php
                                                echo $seoTitleVi;
                                                echo $seoKeywordVi;
                                                ?>
                                            </div>
                                            <div class="col-md-6">
                                                <?php
                                                echo $seoDescriptionVi;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php
                                                echo $saleOffVi;
                                                echo $linkSaleOffVi;
                                                ?>
                                            </div>
                                            <div class="col-md-6">
                                                <?php echo $addressVi; ?>
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
//<script>
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
        var defaults = {
            disabled: true,
            disabledOpacity: 0.75,
            size: 'small'
        };
        var url = '<?php echo $this->Url->build(['action' => 'switchery']); ?>';
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html, i) {
            var switchery = new Switchery(html, defaults);
            var divParent = $(elems[i]).parent();
            var input = divParent.parents('.form-group').children('.form-control');
            var data = {check: 1, name: input.attr('name')};
            $.ajax({
                type: 'post',
                url: url,
                data: data,
                success: function (result) {
                    var rlt = JSON.parse(result);
                    if (rlt.status && rlt.data == 1) {
                        divParent.children('.js-switch').click().prop('checked', true);
                    }
                }
            });
            divParent.children('.switchery').on("click", function () {
                var input = $(this).parents('.group-input-child').children('.form-control');
                var checkbox = $(this).parent().children('.js-switch');
                var check = checkbox.prop('checked');
                check = (check === false) ? 0 : 1;
                data = {check: 0, name: input.attr('name'), status: check};
                $.ajax({
                    type: 'post',
                    url: url,
                    data: data,
                    success: function (result) {
                        var rlt = JSON.parse(result);
                        alertMsg(rlt);
                        if(rlt.status === false) {
                            checkbox.click().removeProp('checked');
                        }
                    }
                });
            });
        });

        $('.clockpicker').clockpicker();
    });
    <?php echo $this->Html->scriptEnd(); ?>
