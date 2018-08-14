<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(CATEGORIES_MANAGEMENT),
    'subTitle' => __(VIEW, $item->id),
]);

$image    = empty($item->image) ? NO_IMAGE : $item->image;
$imgSlider = $this->Html->image(
    $image, [
        'id'    => 'previewImg',
        'style' => ['max-width: 200px; max-height :100px;'],
    ]
);

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
                                echo $this->Form->control('name', [
                                        'class'       => 'form-control',
                                        'placeholder' => __(NAME),
                                        'label'       => __(NAME),
                                        'disabled' => true,
                                    ]
                                );
                                echo $this->Form->control('slug', [
                                        'class' => 'form-control',
                                        'disabled' => true,
                                    ]
                                );
                                echo $this->Form->control('service_id', [
                                        'class'   => 'form-control',
                                        'options' => $services,
                                        'empty'   => ' ',
                                        'disabled' => true,
                                    ]
                                );
                                echo $this->Form->control('parent_id', [
                                        'class'   => 'form-control',
                                        'options' => $categories,
                                        'empty'   => ' ',
                                        'disabled' => true,
                                    ]
                                );
                                echo $this->Form->control('description',
                                    [
                                        'class'       => 'form-control',
                                        'type'        => 'textarea',
                                        'disabled' => true,
                                        'placeholder' => __(DESCRIPTION),
                                        'label'       => __(DESCRIPTION),
                                    ]
                                );

                                echo $this->element('Admin/Meta/frmMeta');

                                echo '<div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                ' . __(IMAGE) .
                                    '</label><div class="col-sm-6">'
                                    . $imgSlider . '</div></div>';

                                echo $this->Form->control('status', [
                                        'options' => [
                                            ENABLED  => 'Enabled',
                                            DISABLED => 'Disabled',
                                        ],
                                        'class'   => 'form-control',
                                        'disabled' => true,
                                    ]
                                );
                                echo $this->Form->control('position', [
                                        'class'       => 'form-control',
                                        'type'        => 'number',
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
                                    $iClass    = "fa fa-chevron-down";
                                    $boxStyle  = "display: none;";
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
                                            echo $this->Form->control('_translations.'. $key .'.name',
                                                [
                                                    'class'       => 'form-control',
                                                    'placeholder' => __(NAME),
                                                    'label'       => __(NAME),
                                                    'disabled' => true,
                                                ]
                                            );
                                            echo $this->Form->control('_translations.'. $key .'.description',
                                                [
                                                    'class'       => 'form-control',
                                                    'type'        => 'textarea',
                                                    'disabled' => true,
                                                    'placeholder' => __(DESCRIPTION),
                                                    'label'       => __(DESCRIPTION),
                                                ]
                                            );
                                            echo $this->element('Admin/Meta/frmMetaTranslate', compact('key'));
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                    $block++;
                                }
                                echo $this->Form->control(
                                    __(GO_TO_EDIT), [
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
<?php echo $this->Form->end(); ?>
