<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(MENU_MANAGEMENT),
    'subTitle' => __(ADD),
]);
$this->Form->setTemplates($this->Utility->customFormTemplate());
echo $this->Form->create()
?>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab"
                           href="#tab-1"><?php echo __(NEW_INFO); ?></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <div class="form-horizontal">
                                <div class="col-md-12">
                                    <?php echo $this->Form->control('name', [
                                            'class'       => 'form-control',
                                            'placeholder' => __(NAME),
                                            'autofocus'   => true,
                                        ]
                                    );
                                    echo $this->Form->control('type', [
                                            'options' => $typeMenu,
                                            'label'   => __('type'),
                                            'class'   => 'form-control',
                                        ]
                                    );
                                    echo $this->Form->control('status', [
                                            'class'   => 'form-control',
                                            'options' => [
                                                ENABLED   => 'Enabled',
                                                DISABLED => 'Disabled',
                                            ],
                                        ]
                                    );
                                    echo $this->Form->control(
                                        __(SAVE_CHANGE), [
                                            'class' => 'btn btn-primary m-b',
                                            'type'  => 'submit',
                                        ]
                                    );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>
