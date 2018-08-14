<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(SLIDER_MANAGEMENT),
    'subTitle' => __(ADD),
]);

$img   = $this->Html->image(
    NO_IMAGE, [
        'id'          => 'previewImg',
        'style'       => ['max-width: 200px; max-height :100px;'],
        'data-banner' => true,
    ]
);
$video = $this->Html->link('<i class="fa fa-video-camera"></i> Click me!', '#',
    [
        'id'     => 'previewVideo',
        'class'  => 'btn btn-danger',
        'target' => '_blank',
        'escape' => false,
    ]);

$this->Form->setTemplates($this->Utility->customFormTemplate());
echo $this->Form->create();
?>
    <div class="wrapper wrapper-content animated fadeInRight ecommerce">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#tab-1">
                                <?php echo __(NEW_INFO) ?>
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
                                            'class'       => 'form-control',
                                            'placeholder' => __(TITLE),
                                            'label'       => __(TITLE),
                                            'autofocus'   => true,
                                            'required'    => true,
                                        ]
                                    );
                                    echo $this->Form->control('description', [
                                            'class'       => 'form-control',
                                            'placeholder' => __(DESCRIPTION),
                                            'label'       => __(DESCRIPTION),
                                            'type'        => 'textarea',
                                        ]
                                    );
                                    echo $this->Form->control('position', [
                                            'class' => 'form-control',
                                            'type'  => 'number',
                                        ]
                                    );
                                    echo $this->Form->control('type', [
                                            'class'   => 'form-control',
                                            'options' => [
                                                SLIDER_IMAGE => 'Image',
                                                SLIDER_VIDEO => 'Video',
                                            ],
                                        ]
                                    );
                                    echo $this->Form->control('url', [
                                            'class' => 'form-control',
                                        ]
                                    );
                                    echo $this->Form->control('language', [
                                            'class'   => 'form-control',
                                            'options' => [
                                                SLIDER_VI => 'Vietnamese',
                                                SLIDER_EN => 'English',
                                            ],
                                        ]
                                    );
                                    ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"><?php echo __(IMAGE) ?></label>
                                        <div class="col-sm-6">
                                            <?php echo $img; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-7">
                                            <?php echo $this->Form->control(
                                                'image',
                                                [
                                                    'class'       => 'form-control',
                                                    'type'        => 'text',
                                                    'id'          => 'Image',
                                                    'label'       => false,
                                                    'placeholder' => __(IMAGE),
                                                    'templates'   => [
                                                        'formGroup' => '{{input}}',
                                                    ],
                                                ]
                                            ); ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <a href="/filemanager/dialog.php?type=0&field_id=Image&relative_url=1&akey=<?php echo FILE_ACCESS_KEY; ?>"
                                               class="btn btn-success iframe-btn"
                                               type="button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>Image...</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-group hidden">
                                        <label class="col-sm-2 control-label"><?php echo __(VIDEO) ?></label>
                                        <div class="col-sm-6">
                                            <?php echo $video; ?>
                                        </div>
                                    </div>
                                    <div class="form-group hidden">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-7">
                                            <?php echo $this->Form->control(
                                                'video',
                                                [
                                                    'class'       => 'form-control',
                                                    'type'        => 'text',
                                                    'id'          => 'Video',
                                                    'label'       => false,
                                                    'placeholder' => __(VIDEO),
                                                    'templates'   => [
                                                        'formGroup' => '{{input}}',
                                                    ],
                                                ]
                                            ); ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <a href="/filemanager/dialog.php?type=3&field_id=Video&relative_url=1&akey=<?php echo FILE_ACCESS_KEY; ?>"
                                               class="btn btn-success iframe-btn"
                                               type="button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>Video...</span>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                    echo $this->Form->control(
                                        'status', [
                                            'options' => [
                                                ENABLED  => 'Enabled',
                                                DISABLED => 'Disabled',
                                            ],
                                            'class'   => 'form-control',
                                        ]
                                    );
                                    echo $this->Form->control(
                                        __(SAVE_CHANGE), [
                                            'class' => 'btn btn-primary m-b',
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
                                    foreach ($languages as $key => $language) {
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
                                                    <h5><?php echo $language ?></h5>
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
                                                        'required'    => false,
                                                    ]
                                                );
                                                echo $this->Form->control('_translations.'
                                                    . $key . '.description',
                                                    [
                                                        'label'       => __(DESCRIPTION),
                                                        'class'       => 'form-control',
                                                        'placeholder' => __(DESCRIPTION),
                                                        'required'    => false,
                                                        'type'        => 'textarea',
                                                    ]
                                                );
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                        $block++;
                                    }
                                    echo $this->Form->control(
                                        __(SAVE_CHANGE), [
                                            'class' => 'btn btn-primary m-b',
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
<?php
echo $this->Form->end();
echo $this->element('Admin/Editor/tinymce');
echo $this->element('Admin/Editor/popup'); ?>
<?php $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
    $(document).ready(function () {
    $('#type').on('change', function () {
    var type = this.value;
    if (type == 2) {
    $('#url').parents('.form-group').addClass();
    $('#Video').parents('.form-group').removeClass('hidden');
    } else {
    $('#url').parents('.form-group').removeClass('hidden');
    $('#Video').parents('.form-group').addClass('hidden');
    $('#previewVideo').parents('.form-group').addClass('hidden');
    }
    });
    $('#Video').on('keypress', function () {
    $('#previewVideo').parents('.form-group').addClass('hidden');
    });
    $('#Video').on('paste', function () {
    $('#previewVideo').parents('.form-group').addClass('hidden');
    });
    });
<?php $this->Html->scriptEnd();
