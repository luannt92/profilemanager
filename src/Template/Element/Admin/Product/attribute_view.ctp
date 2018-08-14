<?php
$templates = [
    'formGroup' => '<div class="form-group"><div class="col-sm-12">{{input}}{{error}}</div></div>',
];
?>
<table id="table-product-attribute"
       class="table table-stripped table-bordered productType<?php echo PRODUCT_TYPE_EXTRA; ?>">
    <thead>
    <tr>
        <th class="col-md-2">
            <?php echo __(NAME); ?>
        </th>
        <th class="col-md-2">
            <?php echo __(MSG_POSITION); ?>
        </th>
        <th class="col-md-8">
            <?php echo __(MSG_ATTRIBUTE_TYPE); ?>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ( ! empty($item->product_attributes)) {
    foreach ($item->product_attributes as $key => $attribute) {
        ?>
    <tr class="row-attr-<?php echo $key; ?>"
        data-attr-index="<?php echo $key; ?>">
        <td>
            <?php
            echo $this->Form->control('product_attribute[' . $key . '][name]',
                [
                    'class'       => 'form-control productType'
                        . PRODUCT_TYPE_EXTRA,
                    'label'       => false,
                    'placeHolder' => 'English',
                    'templates'   => $templates,
                    'value'       => $attribute->name,
                    'disabled' => true,
                ]
            );
            echo $this->Form->control('product_attribute[' . $key
                . '][vi_name]',
                [
                    'class'       => 'form-control productType'
                        . PRODUCT_TYPE_EXTRA,
                    'label'       => false,
                    'placeHolder' => 'Vietnamese',
                    'templates'   => $templates,
                    'value'       => $attribute->translation('vi')->name,
                    'disabled' => true,
                ]
            );
            ?>
        </td>
        <td>
            <?php
            echo $this->Form->control('product_attribute[' . $key
                . '][position]',
                [
                    'class'       => 'form-control productType'
                        . PRODUCT_TYPE_EXTRA,
                    'label'       => false,
                    'type'        => 'number',
                    'placeHolder' => __(MSG_POSITION),
                    'templates'   => $templates,
                    'value'       => $attribute->position,
                    'disabled' => true,
                ]
            );
            ?>
        </td>
        <td>
        <div class="input select">
            <div class="form-group">
                <div class="col-sm-10">
                    <?php
                    echo $this->Form->select('product_attribute[' . $key
                        . '][type]',
                        $productOptionTypes,
                        [
                            'class'           => 'form-control product_attribute_type productType'
                                . PRODUCT_TYPE_EXTRA,
                            'value'           => $attribute->type,
                            'attribute-index' => $key,
                            'disabled' => true,
                        ]
                    ); ?>
                </div>
            </div>
        </div>
        <?php
        if (! empty($attribute->product_attribute_values)) {
            ?>
            <table class="table-product-attribute-value table table-stripped table-bordered">
                <thead>
                <tr>
                    <th>
                        <?php echo __(NAME); ?>
                    </th>
                    <th>
                        <?php echo __(MSG_PRICE); ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($attribute->product_attribute_values as $index => $extra) {
                ?>
                <tr class="" data-extra-index="<?php echo $index; ?>">
                    <td>
                        <?php
                        echo $this->Form->control('product_attribute['.$key.'][extras]['.$index.'][name]',
                            [
                                'class'       => 'form-control productType'
                                    . PRODUCT_TYPE_EXTRA,
                                'label'       => false,
                                'placeHolder' => 'English',
                                'templates'   => $templates,
                                'value'       => $extra->name,
                                'disabled' => true,
                            ]
                        );
                        echo $this->Form->control('product_attribute['.$key.'][extras]['.$index.'][vi_name]',
                            [
                                'class'       => 'form-control productType'
                                    . PRODUCT_TYPE_EXTRA,
                                'label'       => false,
                                'placeHolder' => 'Vietnamese',
                                'templates'   => $templates,
                                'value'       => $extra->translation('vi')->name,
                                'disabled' => true,
                            ]
                        );
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $this->Form->control('product_attribute['.$key.'][extras]['.$index.'][price]',
                            [
                                'class'       => 'form-control productType'
                                    . PRODUCT_TYPE_EXTRA,
                                'label'       => false,
                                'type'        => 'number',
                                'placeHolder' => __(MSG_PRICE),
                                'templates'   => $templates,
                                'value'       => $extra->price,
                                'disabled' => true,
                            ]
                        );
                        ?>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php } ?>
            </td>
            </tr>
        <?php }
    }
    ?>
    </tbody>
</table>