<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(PAGE_MANAGEMENT),
    'subTitle' => __(VIEW, $item->id),
]);

$backLink   = $this->Html->link(
    __(BACK), ['action' => 'index'], [
        'class' => 'btn btn-white m-b pull-right',
    ]
);
$optionType = \Cake\Core\Configure::read('type_pages');
$avatar     = empty($item->image) ? NO_IMAGE : $item->image;
$avatarImg  = $this->Html->image(
    $avatar, [
        'id'    => 'previewImg',
        'style' => ['max-width: 200px; max-height :100px;'],
    ]
);

$this->Form->setTemplates(
    [
        'label'               => '<label class="col-sm-2 control-label">{{text}}</label>',
        'formGroup'           => '<div class="form-group">{{label}}<div class="col-sm-10">{{input}}{{error}}</div></div>',
        'submitContainer'     => '<div class="form-group row"><div class="col-sm-2"></div>
                                <div class="col-sm-10">{{content}} ' . $backLink
            . '</div></div>',
        'inputContainerError' => '<div class="input {{type}}{{required}} error">{{content}}</div>',
    ]
);
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
                                <?php echo $this->Form->create($item, [
                                    'type' => 'get',
                                    'url'  => ['action' => 'edit', $item->id],
                                ]);
                                echo $this->Form->control('title', [
                                        'class'    => 'form-control',
                                        'disabled' => true,
                                    ]
                                );
                                echo $this->Form->control('slug', [
                                        'class'    => 'form-control',
                                        'disabled' => true,
                                    ]
                                );
                                echo $this->Form->control('description', [
                                        'class'    => 'form-control',
                                        'disabled' => true,
                                        'type'     => 'textarea',
                                    ]
                                );
                                echo $this->Form->control('content', [
                                        'class'    => 'form-control tinyMceEditor',
                                        'disabled' => true,
                                        'type'     => 'textarea',
                                    ]
                                );
                                echo $this->Form->control(
                                    __('type'), [
                                        'options'  => $optionType,
                                        'class'    => 'form-control',
                                        'disabled' => true,
                                    ]
                                );
                                echo '<div class="form-group">
                                            <label class="col-sm-2 control-label">
                                                ' . __(IMAGE) .
                                    '</label><div class="col-sm-6">'
                                    . $avatarImg . '</div></div>';
                                echo $this->Form->control(
                                    __('status'), [
                                        'options'  => [
                                            ACTIVE   => 'Active',
                                            DEACTIVE => 'DeActive',
                                        ],
                                        'class'    => 'form-control',
                                        'disabled' => true,
                                    ]
                                );
                                echo '<div class="form-group"><label class = "col-sm-2 control-label">Created At</label><div class="col-sm-10">';
                                echo $this->Form->control('created_at', [
                                        'label'     => false,
                                        'templates' => [
                                            'inputContainer' => '<div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input name="start_date" class = "form-control datetimepicker4" type="text" value="'
                                                . $item->created_at . '" disabled>
                                                </div></div></div>',
                                        ],
                                    ]
                                );
                                echo '<div class="form-group"><label class = "col-sm-2 control-label">Updated At</label><div class="col-sm-10">';
                                echo $this->Form->control('updated_at', [
                                        'label'     => false,
                                        'templates' => [
                                            'inputContainer' => '<div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input name="start_date" class = "form-control datetimepicker4" type="text" value="'
                                                . $item->updated_at . '" disabled>
                                                </div></div></div>',
                                        ],
                                    ]
                                );
                                echo $this->Form->control(
                                    __(GO_TO_EDIT), [
                                        'class' => 'btn btn-info m-b',
                                        'type'  => 'submit',
                                    ]
                                );
                                echo $this->Form->end();
                                ?>
                            </fieldset>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            <fieldset class="form-horizontal">
                                <?php
                                $listLanguage = LANGUAGE;
                                $block        = 1;
                                foreach ($listLanguage as $lang => $value) {
                                    $result
                                               = ! empty($item->_translations[$lang])
                                        ? $item->_translations[$lang] : '';
                                    $iboxClass = "ibox float-e-margins";
                                    $iClass    = "fa fa-chevron-down";
                                    $boxStyle  = "display: none;";
                                    if ($block === 1) {
                                        $iboxClass
                                                  = "ibox float-e-margins border-bottom";
                                        $iClass   = "fa fa-chevron-up";
                                        $boxStyle = "";
                                    }
                                    if ( ! empty($result)) {
                                        ?>
                                        <div class="<?php echo $iboxClass ?>">
                                            <a class="collapse-link">
                                                <div class="ibox-title navy-bg">
                                                    <h5><?php echo $value ?></h5>
                                                    <div class="ibox-tools">
                                                        <i class="<?php echo $iClass ?>"></i>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="ibox-content"
                                                 style="<?php echo $boxStyle ?>">
                                                <?php
                                                echo $this->Form->control(__('title'),
                                                    [
                                                        'class'    => 'form-control',
                                                        'value'    => $result->title,
                                                        'disabled' => true,
                                                    ]
                                                );
                                                echo $this->Form->control(__('description'),
                                                    [
                                                        'class'    => 'form-control',
                                                        'type'     => 'textarea',
                                                        'value'    => $result->description,
                                                        'disabled' => true,
                                                    ]
                                                );
                                                echo $this->Form->control(__('content'),
                                                    [
                                                        'class'    => 'form-control tinyMceEditor',
                                                        'type'     => 'textarea',
                                                        'value'    => $result->content,
                                                        'disabled' => true,
                                                    ]
                                                );
                                                echo $this->Form->control(__('seo_title'),
                                                    [
                                                        'label'    => __(SEO_TITLE),
                                                        'class'    => 'form-control',
                                                        'value'    => $result->seo_title,
                                                        'disabled' => true,
                                                    ]
                                                );
                                                echo $this->Form->control(__('seo_description'),
                                                    [
                                                        'label'    => __(SEO_DESCRIPTION),
                                                        'class'    => 'form-control',
                                                        'type'     => 'textarea',
                                                        'value'    => $result->seo_description,
                                                        'disabled' => true,
                                                    ]
                                                );
                                                echo $this->Form->control(__('seo_keyword'),
                                                    [
                                                        'label'    => __(SEO_KEYWORD),
                                                        'class'    => 'form-control',
                                                        'value'    => $result->seo_keyword,
                                                        'disabled' => true,
                                                    ]
                                                );
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                        $block++;
                                    }
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