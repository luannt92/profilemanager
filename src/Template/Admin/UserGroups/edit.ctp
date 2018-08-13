<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(USER_GROUPS_MANAGEMENT),
    'subTitle' => __(EDIT, $item->id),
]);

$backLink = $this->Html->link(
    __(BACK), ['action' => 'index'], [
        'class' => 'btn btn-white m-b pull-right',
    ]
);

$this->Form->setTemplates(
    [
        'formGroup'           => '<div class="form-group">{{label}}<div class="col-sm-10">{{input}}</div></div>',
        'label'               => '<label class="col-sm-2 control-label" {{attrs}}>{{text}}</label>',
        'submitContainer'     => '<div class="form-group row"><div class="col-sm-2"></div>
                                <div class="col-sm-10">{{content}} ' . $backLink
            . '</div></div>',
        'inputContainerError' => '<div class="input {{type}}{{required}} error">{{content}}</div>',
    ]
);
echo $this->Form->create($item)
?>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab"
                           href="#tab-1"><?php echo __(EDIT_INFO) ?></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <div class="form-horizontal">
                                <div class="col-md-6">
                                    <?php echo $this->Form->control('name', [
                                            'class'       => 'form-control',
                                            'placeholder' => __(NAME),
                                            'autofocus'   => true,
                                        ]
                                    ); ?>
                                </div>

                                <div class="col-md-6">
                                    <?php echo $this->Form->control('status', [
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
                                    ); ?>
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
