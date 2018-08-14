<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(STORE_MANAGEMENT),
    'subTitle' => __(EDIT, $item->id),
]);

$image = empty($item->image) ? NO_IMAGE : $item->image;
$img   = $this->Html->image(
    $image, [
        'id'    => 'previewImg',
        'style' => ['max-width: 200px; max-height :100px;'],
    ]
);

$this->Form->setTemplates($this->Utility->customFormTemplate());
echo $this->Form->create($item);
?>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#tab-1">
                            <?php echo __(EDIT_INFO) ?>
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
                                echo $this->Form->control('name', [
                                        'class'       => 'form-control',
                                        'placeholder' => __(NAME),
                                        'label'       => __(NAME),
                                        'autofocus'   => true,
                                        'required'    => true,
                                    ]
                                );
                                echo $this->Form->control('slug', [
                                        'class' => 'form-control',
                                    ]
                                );

                                echo $this->Form->control('service_id', [
                                        'class'   => 'form-control',
                                        'options' => $services,
                                        'empty'   => ' ',
                                    ]
                                );

                                echo $this->Form->control('parent_id', [
                                        'class'   => 'form-control',
                                        'options' => $categories,
                                        'empty'   => ' ',
                                    ]
                                );
                                echo $this->Form->control('description',
                                    [
                                        'class'       => 'form-control',
                                        'type'        => 'textarea',
                                        'placeholder' => __(DESCRIPTION),
                                        'label'       => __(DESCRIPTION),
                                    ]
                                );
                                echo $this->element('Admin/Meta/frmMeta');
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
                                <?php
                                echo $this->Form->control('status', [
                                        'options' => [
                                            ENABLED  => 'Enabled',
                                            DISABLED => 'Disabled',
                                        ],
                                        'class'   => 'form-control',
                                    ]
                                );

                                echo $this->Form->control('position', [
                                        'class'       => 'form-control',
                                        'type'        => 'number',
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
                                $block     = 1;
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
                                                . $key . '.name',
                                                [
                                                    'class'       => 'form-control',
                                                    'placeholder' => __(NAME),
                                                    'label'       => __(NAME),
                                                    'required'    => false,
                                                ]
                                            );
                                            echo $this->Form->control('_translations.'. $key .'.description',
                                                [
                                                    'class'       => 'form-control',
                                                    'type'        => 'textarea',
                                                    'placeholder' => __(DESCRIPTION),
                                                    'label'       => __(DESCRIPTION),
                                                ]
                                            );
                                            echo $this->element('Admin/Meta/frmMetaTranslate',
                                                compact('key'));
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
<?php echo $this->Form->end();
echo $this->element('Admin/Editor/popup');
?>

