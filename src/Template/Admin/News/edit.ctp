<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(NEWS_MANAGEMENT),
    'subTitle' => __(EDIT, $new->id),
]);

$image    = empty($new->image) ? NO_IMAGE : $new->image;
$img = $this->Html->image(
    $image, [
        'id'    => 'previewImg',
        'style' => ['max-width: 200px; max-height :100px;']
    ]
);

$this->Form->setTemplates($this->Utility->customFormTemplate());
echo $this->Form->create($new, ['id' => 'newID']);
?>

<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#tab-1">
                            <?php echo __(EDIT_DATA) ?>
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
                                        'label'       => __(TITLE),
                                        'class'       => 'form-control',
                                        'placeholder' => __(TITLE),
                                        'autofocus'   => true,
                                    ]
                                );
                                echo $this->Form->control('description', [
                                        'label'       => __(DESCRIPTION),
                                        'class'       => 'form-control',
                                        'placeholder' => __(DESCRIPTION),
                                        'type'        => 'textarea',
                                    ]
                                );

                                echo $this->element('Admin/Meta/frmMeta');

                                echo $this->Form->control('content', [
                                        'id'          => 'content',
                                        'label'       => __(CONTENT_TEXT),
                                        'class'       => 'form-control tinyMceEditor',
                                        'placeholder' => __(CONTENT_TEXT),
                                        'type'        => 'textarea',
                                    ]
                                );
                                echo '<div class="form-group"><label class = "col-sm-2 control-label">'
                                    . __(PUBLISH_DATE)
                                    . '</label><div class="col-sm-10">';
                                echo $this->Form->control('publish_date', [
                                        'label'     => false,
                                        'templates' => [
                                            'inputContainer' => '<div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input name="publish_date" class = "form-control datetimepicker4" type="text" value="'
                                                . date('Y-m-d',
                                                    strtotime($new->publish_date))
                                                . '">
                                                </div></div></div>',
                                        ],
                                    ]
                                );
                                ?>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo __(IMAGE) ?></label>
                                    <div class="col-sm-6">
                                        <?php echo $img; ?>
                                    </div>
                                </div>
                                <div class="form-group"><label
                                            class="col-sm-2 control-label"></label>
                                    <div class="col-sm-7">
                                        <?php echo $this->Form->control('image',
                                            [
                                                'class'       => 'form-control',
                                                'type'        => 'text',
                                                'id'          => 'Image',
                                                'label'       => false,
                                                'placeholder' => __(IMAGE_URL),
                                                'templates'   => [
                                                    'formGroup' => '{{input}}',
                                                ],
                                            ]); ?>
                                    </div>
                                    <div class="col-sm-3 text-right">
                                        <a href="/filemanager/dialog.php?type=0&field_id=Image&relative_url=1&akey=<?php echo FILE_ACCESS_KEY; ?>"
                                           class="btn btn-success iframe-btn"
                                           type="button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Image...</span>
                                        </a>
                                    </div>
                                </div>
                                <?php
                                echo $this->Form->control('status', [
                                        'label'   => __(STATUS_TEXT),
                                        'class'   => 'form-control',
                                        'options' => [
                                            ENABLED  => 'Enabled',
                                            DISABLED => 'Disabled',
                                        ],
                                    ]
                                );
                                echo $this->Form->control('new_category_id', [
                                        'label'    => __(CATEGORY),
                                        'class'    => 'form-control tags select2',
                                        'options'  => $listCategories,
                                        'id'       => 'txtListCat',
                                    ]
                                );
                                echo $this->Form->control('tags._ids', [
                                        'label'    => __(TAG),
                                        'class'    => 'form-control tags select2',
                                        'id'       => 'txtListTag',
                                        'options'  => $listTags,
                                        'value'    => array_keys($tags),
                                        'multiple' => true,
                                    ]
                                );
                                ?>
                            </fieldset>
                            <?php
                            echo $this->Form->control(__(SAVE_CHANGE), [
                                    'class' => 'btn btn-info m-b',
                                    'type'  => 'submit',
                                ]
                            );
                            ?>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            <fieldset class="form-horizontal">
                                <?php
                                $block        = 1;
                                foreach ($languages as $key => $value) {
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
                                                <h5><?php echo $value ?></h5>
                                                <div class="ibox-tools">
                                                    <i class="<?php echo $iClass ?>"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="ibox-content"
                                             style="<?php echo $boxStyle ?>">
                                            <?php
                                            echo $this->Form->control('_translations.'. $key .'.title', [
                                                    'label'    => __('title'),
                                                    'class'    => 'form-control',
                                                    'required' => false,
                                                ]
                                            );
                                            echo $this->Form->control('_translations.'. $key .'.description',
                                                [
                                                    'label'    => __('description'),
                                                    'class'    => 'form-control',
                                                    'required' => false,
                                                ]
                                            );

                                            echo $this->element('Admin/Meta/frmMetaTranslate', compact('key'));

                                            echo $this->Form->control('_translations.'. $key .'.content',
                                                [
                                                    'label'    => __('content'),
                                                    'id'       => 'content',
                                                    'class'    => 'form-control tinyMceEditor',
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
<?php echo $this->Form->end(); ?>

<?php echo $this->Html->scriptStart(['block' => true]); ?>
$(document).ready(function () {

$(".select2").select2({
placeholder: "Select a value",
allowClear: true,
tags: true,
tokenSeparators: [","],
createTag: function (tag) {
return {
id: tag.term,
text: tag.term,
isNew: true
};
}
});

$('.datetimepicker4').datepicker({
format: "yyyy-mm-dd",
autoclose: true
});

});
<?php echo $this->Html->scriptEnd();
echo $this->element('Admin/Editor/tinymce');
echo $this->element('Admin/Editor/popup');
?>
