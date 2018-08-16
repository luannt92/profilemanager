<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(PAGE_MANAGEMENT),
    'subTitle' => __(VIEW, $item->id),
]);

$avatar    = empty($item->image) ? NO_IMAGE : $item->image;
$avatarImg = $this->Html->image(
    $avatar, [
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
                                    echo $this->Form->control('content', [
                                            'class'       => 'form-control',
                                            'placeholder' => __(CONTENT_TEXT),
                                            'label'       => __(CONTENT_TEXT),
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
                                                        'class'    => 'form-control',
                                                        'label'    => __(NAME),
                                                        'disabled' => true,
                                                    ]
                                                );

                                                echo $this->Form->control('_translations.'
                                                    . $key . '.description',
                                                    [
                                                        'class'    => 'form-control',
                                                        'label'    => __(DESCRIPTION),
                                                        'disabled' => true,
                                                    ]
                                                );

                                                echo $this->Form->control('_translations.'
                                                    . $key . '.content',
                                                    [
                                                        'class'       => 'form-control tinyMceEditor',
                                                        'placeholder' => __(CONTENT_TEXT),
                                                        'label'       => __(CONTENT_TEXT),
                                                        'type'        => 'textarea',
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