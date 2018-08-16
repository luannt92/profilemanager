<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(PAGE_MANAGEMENT),
    'subTitle' => __(EDIT, $item->id),
]);

$this->Form->setTemplates($this->Utility->customFormTemplate());
$time = time();
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
                                echo '<div class="form-group"><label class = "col-sm-2 control-label">'
                                    . __('Start date')
                                    . '</label><div class="col-sm-10">';
                                echo $this->Form->control('date_start', [
                                        'label'     => __('Start date:'),
                                        'class'     => 'form-control',
                                        'templates' => [
                                            'inputContainer' => '<div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input name="date_start" class = "form-control datepicker" type="text" value="'
                                                . date('Y-m-d', $time) . '">
                                                </div></div></div>',
                                        ],
                                    ]
                                );
                                echo '<div class="form-group"><label class = "col-sm-2 control-label">'
                                    . __('End date')
                                    . '</label><div class="col-sm-10">';
                                echo $this->Form->control('date_end', [
                                        'label'     => __('End date:'),
                                        'class'     => 'form-control',
                                        'templates' => [
                                            'inputContainer' => '<div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input name="date_end" class = "form-control datepicker" type="text" value="'
                                                . date('Y-m-d', $time) . '">
                                                </div></div></div>',
                                        ],
                                    ]
                                );
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
                                                . $key . '.name',
                                                [
                                                    'class'       => 'form-control',
                                                    'placeholder' => __(NAME),
                                                    'label'       => __(NAME),
                                                    'required'    => false,
                                                ]
                                            );

                                            echo $this->Form->control('_translations.'
                                                . $key . '.description',
                                                [
                                                    'class'       => 'form-control',
                                                    'placeholder' => __(DESCRIPTION),
                                                    'label'       => __(DESCRIPTION),
                                                    'required'    => false,
                                                ]
                                            );

                                            echo $this->Form->control('_translations.'
                                                . $key . '.content',
                                                [
                                                    'class'       => 'form-control tinyMceEditor',
                                                    'placeholder' => __(CONTENT_TEXT),
                                                    'label'       => __(CONTENT_TEXT),
                                                    'type'        => 'textarea',
                                                    'required'    => false,
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
echo $this->Html->css(
    [
        'admin/plugins/clockpicker/clockpicker.css',
    ],
    ['block' => true]
);
echo $this->Html->script(
    [
        'admin/plugins/clockpicker/clockpicker.js',
    ],
    ['block' => 'scriptBottom']
);
?>
<?php echo $this->Html->scriptStart(['block' => true]); ?>
<!--    <script>-->
$(document).ready(function () {
$('.datepicker').datepicker({
format: "yyyy-mm-dd",
autoclose: true
});
});
<?php echo $this->Html->scriptEnd();
echo $this->element('Admin/Editor/tinymce');
echo $this->element('Admin/Editor/popup'); ?>
