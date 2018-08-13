<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(USER_GROUPS_MANAGEMENT),
    'subTitle' => __(VIEW_TEXT, $item->id),
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
echo $this->Form->create($item, [
    'type' => 'get',
    'url'  => ['action' => 'edit', $item->id],
]); ?>
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
                                        <?php echo $this->Form->control('name',
                                            [
                                                'class'       => 'form-control',
                                                'placeholder' => __(NAME),
                                                'disabled'    => true,
                                            ]
                                        );
                                        echo '<div class="form-group"><label class = "col-sm-2 control-label">Created At</label><div class="col-sm-10">';
                                        echo $this->Form->control(
                                            'created_at', [
                                                'label'     => false,
                                                'templates' => [
                                                    'inputContainer' => '<div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input name="created_at" class = "form-control datetimepicker4" type="text" value="'
                                                        . date('Y/m/d',
                                                            strtotime($item->created_at))
                                                        . '" disabled>
                                            </div></div></div>',
                                                ],
                                            ]
                                        );
                                        echo '<div class="form-group"><label class = "col-sm-2 control-label">Updated At</label><div class="col-sm-10">';
                                        echo $this->Form->control(
                                            'updated_at', [
                                                'label'     => false,
                                                'templates' => [
                                                    'inputContainer' => '<div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input name="updated_at" class = "form-control datetimepicker4" type="text" value="'
                                                        . date('Y/m/d',
                                                            strtotime($item->updated_at))
                                                        . '" disabled>
                                            </div></div></div>',
                                                ],
                                            ]
                                        ); ?>
                                    </div>

                                    <div class="col-md-6">
                                        <?php
                                        echo $this->Form->control('status', [
                                                'class'    => 'form-control',
                                                'options'  => [
                                                    ENABLED   => 'Enabled',
                                                    DISABLED => 'Disabled',
                                                ],
                                                'disabled' => true,
                                            ]
                                        );
                                        echo $this->Form->control(
                                            __(GO_TO_EDIT), [
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