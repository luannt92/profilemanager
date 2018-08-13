<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(PAGE_MANAGEMENT),
    'subTitle' => __(EDIT, $item->id),
]);

$optionType = \Cake\Core\Configure::read('type_pages');
$backLink   = $this->Html->link(
    __(BACK), ['action' => 'index'], [
        'class' => 'btn btn-white m-b pull-right',
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
                                        'placeholder' => __(TITLE),
                                        'autofocus'   => true,
                                    ]
                                );
                                echo $this->Form->control('slug', [
                                        'class'       => 'form-control',
                                        'placeholder' => __(SLUG),
                                    ]
                                );
                                echo $this->Form->control('description', [
                                        'class'       => 'form-control',
                                        'placeholder' => __(DESCRIPTION),
                                        'type'        => 'textarea',
                                    ]
                                );
                                echo $this->Form->control(
                                    __('content'), [
                                        'id'          => 'content',
                                        'class'       => 'form-control tinyMceEditor',
                                        'placeholder' => __(CONTENT_TEXT),
                                        'type'        => 'textarea',
                                    ]
                                );
                                echo $this->Form->control(
                                    __('type'), [
                                        'options' => $optionType,
                                        'class'   => 'form-control',
                                    ]
                                ); ?>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo __(IMAGE) ?></label>
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
                                        <a href="/filemanager/dialog.php?type=0&field_id=Image&relative_url=1"
                                           class="btn btn-success iframe-btn"
                                           type="button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Photo...</span>
                                        </a>
                                    </div>
                                </div>
                                <?php echo $this->Form->control(
                                    __('status'), [
                                        'options' => [
                                            ACTIVE   => 'Active',
                                            DEACTIVE => 'DeActive',
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
                                $listLanguage = LANGUAGE;
                                $block        = 1;
                                foreach ($listLanguage as $key => $value) {
                                    $result
                                               = ! empty($item->_translations[$key])
                                        ? $item->_translations[$key] : '';
                                    $iboxClass = "ibox float-e-margins";
                                    $iClass    = "fa fa-chevron-down";
                                    $boxStyle  = "display: none;";
                                    if ($block === 1) {
                                        $iboxClass
                                                  = "ibox float-e-margins border-bottom";
                                        $iClass   = "fa fa-chevron-up";
                                        $boxStyle = "";
                                    }
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
                                                    'value'    => ! empty($result->title)
                                                        ? $result->title : '',
                                                    'name'     => $key
                                                        . '[title]',
                                                    'required' => false,
                                                ]
                                            );
                                            echo $this->Form->control(__('description'),
                                                [
                                                    'label'    => __(DESCRIPTION),
                                                    'class'    => 'form-control',
                                                    'type'     => 'textarea',
                                                    'value'    => ! empty($result->description)
                                                        ? $result->description
                                                        : '',
                                                    'name'     => $key
                                                        . '[description]',
                                                    'required' => false,
                                                ]
                                            );
                                            echo $this->Form->control(__('content'),
                                                [
                                                    'label'    => __(CONTENT_TEXT),
                                                    'class'    => 'form-control tinyMceEditor',
                                                    'type'     => 'textarea',
                                                    'value'    => ! empty($result->content)
                                                        ? $result->content
                                                        : '',
                                                    'name'     => $key
                                                        . '[content]',
                                                    'required' => false,
                                                ]
                                            );
                                            echo $this->Form->control(__('seo_title'),
                                                [
                                                    'label'    => __(SEO_TITLE),
                                                    'class'    => 'form-control',
                                                    'value'    => ! empty($result->seo_title)
                                                        ? $result->seo_title
                                                        : '',
                                                    'name'     => $key
                                                        . '[seo_title]',
                                                    'required' => false,
                                                ]
                                            );
                                            echo $this->Form->control(__('seo_description'),
                                                [
                                                    'label'    => __(SEO_DESCRIPTION),
                                                    'class'    => 'form-control',
                                                    'type'     => 'textarea',
                                                    'value'    => ! empty($result->seo_description)
                                                        ? $result->seo_description
                                                        : '',
                                                    'name'     => $key
                                                        . '[seo_description]',
                                                    'required' => false,
                                                ]
                                            );
                                            echo $this->Form->control(__('seo_keyword'),
                                                [
                                                    'label'    => __(SEO_KEYWORD),
                                                    'class'    => 'form-control',
                                                    'value'    => ! empty($result->seo_keyword)
                                                        ? $result->seo_keyword
                                                        : '',
                                                    'name'     => $key
                                                        . '[seo_keyword]',
                                                    'required' => false,
                                                ]
                                            );
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                    $block++;

                                }
                                echo $this->Form->control(__(SAVE_CHANGE), [
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
<?php echo $this->element('Admin/Editor/tinymce'); ?>
<?php echo $this->element('Admin/Editor/popup');
echo $this->Form->end();
?>
