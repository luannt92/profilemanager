<?php
$this->Form->setTemplates(
    [
        'submitContainer'     => '<div class="form-group row text-right">
               <div class="col-md-12">{{content}}</div></div>',
        'inputContainer'      => '{{row}}<div class="{{col}} has-required">
               <span class="span-required">*</span>{{content}}<div class="help-block with-errors"></div></div>{{endRow}}',
        'inputContainerError' => '{{row}}<div class="{{col}} has-required error has-error">
               <span class="span-required">*</span>{{content}}{{error}}</div>{{endRow}}',
        'error'               => '<div class="error-message help-block">{{content}}</div>',
    ]
);
$address  = empty($dataSettings['site_address']) ? ''
    : $dataSettings['site_address'];
$mail     = empty($dataSettings['site_mail']) ? '' : $dataSettings['site_mail'];
$phone    = empty($dataSettings['site_phone']) ? ''
    : $dataSettings['site_phone'];
$viber    = empty($dataSettings['contact_viber']) ? ''
    : $dataSettings['contact_viber'];
$zalo     = empty($dataSettings['contact_zalo']) ? ''
    : $dataSettings['contact_zalo'];
$whatsapp = empty($dataSettings['contact_whatsapp']) ? ''
    : $dataSettings['contact_whatsapp'];

$infoSite = [
    [
        'name'     => $address,
        'position' => null,
        'email'    => $mail,
        'phone'    => $phone,
        'viber'    => $viber,
        'zalo'     => $zalo,
        'whatsapp' => $whatsapp,
    ],
];
$dataInfo = empty($dataSupports) ? $infoSite
    : array_merge($infoSite, $dataSupports);

$blockInfo = '';
foreach ($dataInfo as $keyInfo => $info) {
    $iconFirst = '<i class="fa fa-user"></i>';
    $name      = empty($info['position']) ? $info['name']
        : $keyInfo . ' : ' . $info['name'];
    if ($keyInfo === 0) {
        $iconFirst = '<i class="fa fa-map-marker"></i>';
        $blockInfo .= '<div class="block-info-contact"><h3>' . __(INFORMATION)
            . '</h3>';
    } elseif ($keyInfo === 1) {
        $blockInfo .= '<div class="block-info-contact"><h3>'
            . __('Contact & cooperation') . '</h3>';
    }

    $phoneNumber = !empty($info['phone']) ? '<p><span><i class="fa fa-phone"></i></span><span><a href="tel:'
        . $info['phone'] . '">' . $info['phone'] . '</a></span></p>' : '';

    $blockInfo .= '<p><span>' . $iconFirst . '</span><span>'
        . $name . '</span></p>
                    <p><span><i class="fa fa-envelope"></i></span><span><a href="mailto:'
        . $info['email'] . '">' . $info['email'] . '</a></span></p>' . $phoneNumber;

    $socialInfo = '';
    $socialInfo .= empty($info['viber'])
        ? ''
        : '<li><a href="viber://pa?chatURI=' . $info['viber']
        . '" class="social viber"></a></li>';
    $socialInfo .= empty($info['zalo'])
        ? ''
        : '<li><a href="http://zalo.me/' . $info['zalo']
        . '" class="social zalo" target="_blank"></a></li>';
    $socialInfo .= empty($info['whatsapp'])
        ? ''
        : '<li><a href="whatsapp://send?abid=' . $info['whatsapp']
        . '" class="social webapp"></a></li>';

    if ( ! empty(trim($socialInfo))) {
        $blockInfo .= '<p><span><i class="fa fa-share-alt"></i></span><span>'
            . __('Or contact via') . ':'
            . '</span></p><ul class="social-app list-inline">' . $socialInfo
            . '</ul>';
    }

    $blockInfo .= ($keyInfo === 0 || $keyInfo === (count($dataInfo) - 1))
        ? '</div>' : '<p class="p-clear"></p>';
}

$captchaId = uniqid();
$url       = $this->Url->build(['action' => 'captcha', $captchaId]);
$image     = $this->Html->image($url,
    ['fullBase' => true, 'style' => 'width: 125px;height:33px;']);
?>
<div class="block-map">
    <!--    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d18681.58306219332!2d103.95654922348481!3d10.216864987063675!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a78c8873a4ac7f%3A0x2b2582f4d1ce7ef9!2sCrab+House!5e0!3m2!1sen!2s!4v1521860522405"-->
    <!--            width="600" height="450" frameborder="0" style="border:0"-->
    <!--            allowfullscreen></iframe>-->
</div>
<div class="block-content-contact">
    <div class="container bg-contact">
        <div class="row">
            <div class="col-md-4">
                <?php echo $blockInfo; ?>
            </div>
            <div class="col-md-8">
                <div class="block-info-contact">
                    <h3><?php echo __(CONTACT); ?></h3>
                    <?php
                    echo $this->Form->create($contactForm,
                        [
                            'name'        => 'frm-contact',
                            'id'          => 'contactForm',
                            'data-toggle' => 'validator',
                            'role'        => 'form',
                        ]);
                    echo $this->Form->control('name', [
                        'class'               => 'form-control col-name-contact',
                        'placeholder'         => __(YOUR_NAME),
                        'required'            => true,
                        'autofocus'           => true,
                        'label'               => false,
                        'templateVars'        => [
                            'row' => '<div class="row">',
                            'col' => 'col-md-6 form-group',
                        ],
                        'data-required-error' => __(VALIDATE_INPUT_1,
                            __(YOUR_NAME)),
                    ]);
                    echo $this->Form->control('email', [
                        'class'               => 'form-control',
                        'type'                => 'email',
                        'placeholder'         => __(YOUR_EMAIL),
                        'required'            => true,
                        'label'               => false,
                        'templateVars'        => [
                            'endRow' => '</div>',
                            'col'    => 'col-md-6 form-group',
                        ],
                        'data-required-error' => __(VALIDATE_INPUT_1,
                            __(YOUR_EMAIL)),
                        'data-error'          => __(VALIDATE_INPUT_2,
                            __(YOUR_EMAIL)),
                    ]);
                    echo $this->Form->control('phone', [
                        'class'               => 'form-control',
                        'placeholder'         => __(YOUR_PHONE_NUMBER),
                        'required'            => true,
                        'label'               => false,
                        'templateVars'        => [
                            'row'    => '<div class="form-group row">',
                            'col'    => 'col-md-12',
                            'endRow' => '</div>',
                        ],
                        'data-required-error' => __(VALIDATE_INPUT_1,
                            __(YOUR_PHONE_NUMBER)),
                    ]);
                    echo $this->Form->control('subject', [
                        'class'               => 'form-control',
                        'placeholder'         => __(SUBJECT),
                        'required'            => true,
                        'label'               => false,
                        'templateVars'        => [
                            'row'    => '<div class="form-group row">',
                            'col'    => 'col-md-12',
                            'endRow' => '</div>',
                        ],
                        'data-required-error' => __(VALIDATE_INPUT_1,
                            __(SUBJECT)),
                    ]);
                    echo $this->Form->control('message', [
                        'class'               => 'form-control',
                        'type'                => 'textarea',
                        'placeholder'         => __(YOUR_MESSAGE),
                        'required'            => true,
                        'label'               => false,
                        'templateVars'        => [
                            'row'    => '<div class="form-group row">',
                            'col'    => 'col-md-12',
                            'endRow' => '</div>',
                        ],
                        'data-required-error' => __(VALIDATE_INPUT_1,
                            __(YOUR_MESSAGE)),
                    ]);
                    echo '<div class="form-group row">
                            <div class="col-md-12">' . __(CAPTCHA_MSG) . '</div>
                        </div>';
                    echo '<div class="form-group row col-img-contact">
                            <div class="col-md-2 col-img-check">'
                        . $image . '
                            </div>'
                        . $this->Form->control('captcha', [
                            'class'               => 'form-control',
                            'required'            => true,
                            'label'               => false,
                            'templateVars'        => [
                                'col' => 'col-md-3 col-img-result',
                            ],
                            'data-required-error' => __(VALIDATE_INPUT_1,
                                __('the correct code')),
                        ]) . '
                        </div>';
                    echo $this->Form->hidden('captchaId',
                        ['value' => $captchaId]);

                    echo $this->Form->control(__(BTN_SEND), [
                        'class' => 'btn btn-contact',
                        'type'  => 'submit',
                    ]);
                    echo $this->Form->end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>