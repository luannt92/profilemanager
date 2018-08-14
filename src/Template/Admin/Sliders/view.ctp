<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(SLIDER_MANAGEMENT),
    'subTitle' => __(VIEW, $item->id),
]);

$image    = empty($item->image) ? NO_IMAGE : $item->image;
$imgSlider = $this->Html->image(
    $image, [
        'id'    => 'previewImg',
        'style' => ['max-width: 200px; max-height :100px;'],
    ]
);
$classHidden    = $classHiddenImg = "hidden";
$videoUrl       = "";
if ($item->type == SLIDER_VIDEO) {
    $classHidden = "";
    $videoUrl = $this->Html->link('<i class="fa fa-video-camera"></i> Click me!',
        $item->url,
        [
            'id'     => 'previewVideo',
            'class'  => 'btn btn-danger',
            'target' => '_blank',
            'escape' => false,
        ]);

} else {
    $classHiddenImg = "";
}

$this->Form->setTemplates($this->Utility->customFormTemplate());
echo $this->Form->create($item, [
    'type' => 'get',
    'url'  => ['action' => 'edit', $item->id],
]);
?>
    <div class="wrapper wrapper-content animated fadeInRight ecommerce">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#tab-1">
                                <?php echo __(VIEW_INFO) ?>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#tab-2">
                                <?php echo __('Translate') ?>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <fieldset class="form-horizontal">
                                    <?php
                                    echo $this->Form->control('title', [
                                            'class'    => 'form-control',
                                            'disabled' => true,
                                            'label'    => __(TITLE),
                                        ]
                                    );
                                    echo $this->Form->control('description', [
                                            'class'       => 'form-control',
                                            'placeholder' => __(DESCRIPTION),
                                            'label'       => __(DESCRIPTION),
                                            'disabled'    => true,
                                        ]
                                    );
                                    echo $this->Form->control('url', [
                                            'class'    => 'form-control',
                                            'disabled' => true,
                                            'templates'    => [
                                                'formGroup' => '<div class="form-group {{clsHidden}}">{{label}}<div class="col-sm-10">{{input}}{{error}}</div></div>',
                                            ],
                                            'templateVars' => [
                                                'clsHidden' => $classHiddenImg,
                                            ],
                                        ]
                                    );
                                    echo $this->Form->control('language', [
                                            'class'   => 'form-control',
                                            'options' => [
                                                SLIDER_VI => 'Vietnamese',
                                                SLIDER_EN => 'English',
                                            ],
                                            'disabled' => true,
                                        ]
                                    );
                                    echo $this->Form->control('position', [
                                            'class'    => 'form-control',
                                            'disabled' => true,
                                        ]
                                    );

                                    echo '<div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                ' . __(IMAGE) .
                                        '</label><div class="col-sm-6">'
                                        . $imgSlider . '</div></div>';

                                    echo '<div class="form-group '. $classHidden .'">
                                        <label class="col-sm-2 control-label">' . __(VIDEO) . '</label>
                                        <div class="col-sm-6">'.$videoUrl. '</div></div>';


                                    echo $this->Form->control('status', [
                                            'options'  => [
                                                ACTIVE   => 'Active',
                                                DEACTIVE => 'DeActive',
                                            ],
                                            'class'    => 'form-control',
                                            'disabled' => true,
                                        ]
                                    );
                                    echo '<div class="form-group"><label class = "col-sm-2 control-label">'
                                        . __(CREATED_AT)
                                        . '</label><div class="col-sm-10">';
                                    echo $this->Form->control('created_at', [
                                            'label'     => false,
                                            'templates' => [
                                                'inputContainer' => '<div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input name="start_date" class = "form-control datetimepicker4" type="text" value="'
                                                    . $item->created_at . '" disabled>
                                                </div></div></div>',
                                            ],
                                        ]
                                    );
                                    echo '<div class="form-group"><label class = "col-sm-2 control-label">'
                                        . __(UPDATED_AT)
                                        . '</label><div class="col-sm-10">';
                                    echo $this->Form->control('updated_at', [
                                            'label'     => false,
                                            'templates' => [
                                                'inputContainer' => '<div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input name="start_date" class = "form-control datetimepicker4" type="text" value="'
                                                    . $item->updated_at . '" disabled>
                                                </div></div></div>',
                                            ],
                                        ]
                                    );
                                    echo $this->Form->control(
                                        __(GO_TO_EDIT), [
                                            'class' => 'btn btn-info m-b',
                                            'type'  => 'submit',
                                        ]
                                    );
                                    ?>
                                </fieldset>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <fieldset class="form-horizontal">
                                    <?php
                                    $block = 1;
                                    foreach ($languages as $key => $value) {
                                        $inboxClass = "ibox float-e-margins";
                                        $iClass     = "fa fa-chevron-down";
                                        $boxStyle   = "display: none;";
                                        if ($block === 1) {
                                            $inboxClass
                                                      = "ibox float-e-margins border-bottom";
                                            $iClass   = "fa fa-chevron-up";
                                            $boxStyle = "";
                                        }
                                        ?>
                                        <div class="<?php echo $inboxClass ?>">
                                            <a class="collapse-link">
                                                <div class="ibox-title navy-bg">
                                                    <h5><?php echo $value ?></h5>
                                                    <div class="ibox-tools">
                                                        <i class="<?php echo $iClass ?>"></i>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="ibox-content"
                                                 style="<?php echo $boxStyle ?>">
                                                <?php
                                                echo $this->Form->control('_translations.'
                                                    . $key . '.title',
                                                    [
                                                        'class'       => 'form-control',
                                                        'placeholder' => __(TITLE),
                                                        'label'       => __(TITLE),
                                                        'disabled'    => true,
                                                    ]
                                                );
                                                echo $this->Form->control('_translations.'
                                                    . $key . '.description',
                                                    [
                                                        'label'       => __(DESCRIPTION),
                                                        'class'       => 'form-control',
                                                        'placeholder' => __(DESCRIPTION),
                                                        'disabled'    => true,
                                                    ]
                                                );
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                        $block++;
                                    }
                                    echo $this->Form->control(
                                        __(GO_TO_EDIT), [
                                            'class' => 'btn btn-info m-b',
                                            'type'  => 'submit',
                                        ]
                                    );
                                    ?>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo $this->Form->end(); ?>