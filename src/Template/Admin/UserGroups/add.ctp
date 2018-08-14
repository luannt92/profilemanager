<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(USER_GROUPS_MANAGEMENT),
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
                    <li>
                        <a data-toggle="tab"
                           href="#tab-2"><?php echo __('Permission'); ?></a>
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
                                            'required'  => true,
                                        ]
                                    );
                                    echo $this->Form->control('type', [
                                            'class'   => 'form-control',
                                            'options' => $types,
                                            'empty'   => ' ',
                                        ]
                                    );
                                    ?>
                                </div>

                                <div class="col-md-6">
                                    <?php
                                    echo $this->Form->control('status', [
                                            'class'   => 'form-control',
                                            'options' => [
                                                ENABLED  => 'Enabled',
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
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            <div class="form-horizontal">
                                <?php
                                $arrName = [
                                    'index'          => 'List',
                                    'add'            => 'Add new',
                                    'edit'           => 'Edit',
                                    'view'           => 'View',
                                    'delete'         => 'Delete',
                                    'deleteSelected' => 'Update',
                                ];
                                ?>
                                <ul class="checktree">
                                    <?php foreach ($permissions as $key => $val)
                                    { ?>
                                        <li>
                                            <input id="<?php echo $key; ?>"
                                                   type="checkbox"/><label
                                                    for="<?php echo $key; ?>"><?php echo $key; ?></label>
                                            <?php if ( ! empty($val)) { ?>
                                                <ul>
                                                    <?php foreach (
                                                        $val as $action => $code
                                                    ) {
                                                        $txt = !empty($arrName[$action]) ? $arrName[$action] : $action;
                                                        ?>
                                                        <li>
                                                            <?php echo $this->Form->control(
                                                                'access.' . $code,
                                                                [
                                                                    'type'        => 'checkbox',
                                                                    'id'          => $code,
                                                                    'label'       => false,
                                                                    'templates'   => [
                                                                        'inputContainer' => '{{content}}',
                                                                    ],
                                                                ]
                                                            ); ?>
                                                            <label
                                                                    for="<?php echo $code; ?>"><?php echo $txt; ?></label>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            <?php } ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <hr style="width: 100%;">
                                <?php
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
<?php echo $this->Form->end(); ?>
<?php
echo $this->Html->css(
    [
        'admin/plugins/checktree.css',
    ],
    ['block' => true]
);
echo $this->Html->script(
    [
        'admin/plugins/checktree.js',

    ], ['block' => 'scriptBottom']
);
$this->Html->scriptStart(['block' => true]);
?>
    $(document).ready(function () {
        $("ul.checktree").checktree();
    });
<?php $this->Html->scriptEnd(); ?>
