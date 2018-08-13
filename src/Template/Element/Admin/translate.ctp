<?php
$languages = LANGUAGE;
$block     = 1;
foreach ($languages as $key => $language) {
    $iboxClass = "ibox float-e-margins";
    $iClass    = "fa fa-chevron-down";
    $boxStyle  = "display: none;";
    if ($block === 1) {
        $iboxClass = "ibox float-e-margins border-bottom";
        $iClass    = "fa fa-chevron-up";
        $boxStyle  = "";
    }
    ?>
    <div class="<?php echo $iboxClass ?>">
        <a class="collapse-link">
            <div class="ibox-title navy-bg">
                <h5><?php echo $language ?></h5>
                <div class="ibox-tools">
                    <i class="<?php echo $iClass ?>"></i>
                </div>
            </div>
        </a>
        <div class="ibox-content" style="<?php echo $boxStyle ?>">
            <?php
            echo $this->Form->control(__('title'), [
                    'class'       => 'form-control',
                    'placeholder' => __(TITLE),
                    'name'        => $key . '[title]',
                    'required'    => false
                ]
            );
            echo $this->Form->control(__('description'), [
                    'class'       => 'form-control tinyMceEditor',
                    'name'        => $key . '[description]',
                    'placeholder' => __(DESCRIPTION),
                    'type'        => 'textarea',
                    'required'    => false
                ]
            );
            echo $this->Form->control(__('note'), [
                    'class'       => 'form-control tinyMceEditor',
                    'name'        => $key . '[note]',
                    'placeholder' => __(NOTE),
                    'type'        => 'textarea',
                ]
            );
            echo $this->Form->control(__('time'), [
                    'class'       => 'form-control',
                    'name'        => $key . '[time]',
                    'placeholder' => __(TIME),
                    'required'    => false
                ]
            );
            echo $this->Form->control(__('seo_title'), [
                    'label'       => __(SEO_TITLE),
                    'class'       => 'form-control',
                    'name'        => $key . '[seo_title]',
                    'placeholder' => __(SEO_TITLE),
                    'required'    => false
                ]
            );
            echo $this->Form->control(__('seo_description'),
                [
                    'label'       => __(SEO_DESCRIPTION),
                    'class'       => 'form-control',
                    'name'        => $key . '[seo_description]',
                    'type'        => 'textarea',
                    'placeholder' => __(SEO_DESCRIPTION),
                    'required'    => false
                ]
            );
            echo $this->Form->control(__('seo_keyword'), [
                    'label'       => __(SEO_KEYWORD),
                    'class'       => 'form-control',
                    'name'        => $key . '[seo_keyword]',
                    'placeholder' => __(SEO_KEYWORD),
                    'required'    => false
                ]
            );
            ?>
        </div>
    </div>
    <?php
    $block++;
}
?>
