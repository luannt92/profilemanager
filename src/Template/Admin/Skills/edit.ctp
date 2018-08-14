<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(PAGE_MANAGEMENT),
    'subTitle' => __(EDIT, $item->id),
]);

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
                                echo $this->Form->control('title', [
                                        'class'       => 'form-control',
                                        'placeholder' => __(NAME),
                                        'label'       => __(NAME),
                                        'autofocus'   => true,
                                        'required'    => true,
                                    ]
                                );
                                echo $this->Form->control('percent', [
                                        'class' => 'form-control',
                                        'type'  => 'number',
                                        'label' => __(PERCENT),
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
                                            <?php echo $this->Form->control('_translations.'
                                                . $key . '.name',
                                                [
                                                    'class'       => 'form-control',
                                                    'placeholder' => __(NAME),
                                                    'label'       => __(NAME),
                                                    'required'    => false,
                                                ]
                                            ); ?>
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
