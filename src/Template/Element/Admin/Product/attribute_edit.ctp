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
        <th class="col-md-7">
            <?php echo __(MSG_ATTRIBUTE_TYPE); ?>
        </th>
        <th class="col-md-1">
            <button value="Submit"
                    class="btn btn-success tr_clone_add"
                    type="button"><span
                        class="glyphicon glyphicon-plus"
                        aria-hidden="true"></span>
            </button>
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
                ]
            );
            echo $this->Form->control('product_attribute[' . $key
                . '][vi_name]',
                [
                    'class'       => 'form-control productType'
                        . PRODUCT_TYPE_EXTRA,
                    'label'       => false,
                    'placeHolder' => 'Vietnamese',
                    'value'       => $attribute->translation('vi')->name,
                    'templates'   => $templates,
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
                    <th class="col-md-1">
                            <button class="btn btn-xs btn-primary tr_clone_extra_add"
                                    attribute-index="<?php echo $key; ?>"
                                    attribute-extra-index = "<?php echo count($attribute->product_attribute_values); ?>">
                                <span class="glyphicon glyphicon-plus"
                                      aria-hidden="true"></span>
                            </button>
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
                            ]
                        );
                        echo $this->Form->control('product_attribute['.$key.'][extras]['.$index.'][vi_name]',
                            [
                                'class'       => 'form-control productType'
                                    . PRODUCT_TYPE_EXTRA,
                                'label'       => false,
                                'placeHolder' => 'Vietnamese',
                                'value'       => $extra->translation('vi')->name,
                                'templates'   => $templates,
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
                            ]
                        );
                        ?>
                    </td>
                    <td>
                        <button class="btn btn-xs btn-danger tr_extra_remove_row">
                            <span class="glyphicon glyphicon-minus"
                                  aria-hidden="true"></span>
                        </button>
                    </td>
                </tr>
                <?php } ?>
                <tr class="hide" id="extraTemplate<?php echo $key; ?>">
                    <td>
                        <?php
                        echo $this->Form->control('extra_name',
                            [
                                'class'       => 'form-control productType'
                                    . PRODUCT_TYPE_EXTRA,
                                'label'       => false,
                                'placeHolder' => 'English',
                                'templates'   => $templates,
                            ]
                        );
                        echo $this->Form->control('extra_vi_name',
                            [
                                'class'       => 'form-control productType'
                                    . PRODUCT_TYPE_EXTRA,
                                'label'       => false,
                                'placeHolder' => 'Vietnamese',
                                'templates'   => $templates,
                            ]
                        );
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $this->Form->control('extra_price',
                            [
                                'class'       => 'form-control productType'
                                    . PRODUCT_TYPE_EXTRA,
                                'label'       => false,
                                'type'        => 'number',
                                'placeHolder' => __(MSG_PRICE),
                                'templates'   => $templates,
                            ]
                        );
                        ?>
                    </td>
                    <td>
                        <button class="btn btn-xs btn-danger tr_extra_remove_row">
                        <span class="glyphicon glyphicon-minus"
                              aria-hidden="true"></span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
            <?php } ?>
            </td>
            <td>
                <button value="Submit" class="btn btn-danger tr_remove_row"
                        type="button">
                    <span class="glyphicon glyphicon-minus"
                          aria-hidden="true"></span>
                </button>
            </td>
            </tr>
        <?php }
    }
    ?>
    <tr class="hide" id="attributeTemplate">
        <td>
            <?php
            echo $this->Form->control('attribute_name',
                [
                    'class'       => 'form-control productType'
                        . PRODUCT_TYPE_EXTRA,
                    'label'       => false,
                    'placeHolder' => 'English',
                    'templates'   => $templates,
                ]
            );
            echo $this->Form->control('attribute_vi_name',
                [
                    'class'       => 'form-control productType'
                        . PRODUCT_TYPE_EXTRA,
                    'label'       => false,
                    'placeHolder' => 'Vietnamese',
                    'templates'   => $templates,
                ]
            );
            ?>
        </td>
        <td>
            <?php
            echo $this->Form->control('attribute_position',
                [
                    'class'       => 'form-control productType'
                        . PRODUCT_TYPE_EXTRA,
                    'label'       => false,
                    'type'        => 'number',
                    'placeHolder' => __(MSG_POSITION),
                    'templates'   => $templates,
                ]
            );
            ?>
        </td>
        <td>
            <div class="input select">
                <div class="form-group">
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->select('attribute_type',
                            $productOptionTypes,
                            [
                                'class' => 'form-control product_attribute_type productType'
                                    . PRODUCT_TYPE_EXTRA,
                            ]
                        ); ?>
                    </div>
                </div>
            </div>
            <table class="table-product-attribute-value table table-stripped table-bordered">
                <thead>
                <tr>
                    <th>
                        <?php echo __(NAME); ?>
                    </th>
                    <th>
                        <?php echo __(MSG_PRICE); ?>
                    </th>
                    <th class="col-md-1">
                        <button class="btn btn-xs btn-primary tr_clone_extra_add">
                            <span
                                    class="glyphicon glyphicon-plus"
                                    aria-hidden="true"></span>
                        </button>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="hide" id="extraTemplate">
                    <td>
                        <?php
                        echo $this->Form->control('extra_name',
                            [
                                'class'       => 'form-control productType'
                                    . PRODUCT_TYPE_EXTRA,
                                'label'       => false,
                                'placeHolder' => 'English',
                                'templates'   => $templates,
                            ]
                        );
                        echo $this->Form->control('extra_vi_name',
                            [
                                'class'       => 'form-control productType'
                                    . PRODUCT_TYPE_EXTRA,
                                'label'       => false,
                                'placeHolder' => 'Vietnamese',
                                'templates'   => $templates,
                            ]
                        );
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $this->Form->control('extra_price',
                            [
                                'class'       => 'form-control productType'
                                    . PRODUCT_TYPE_EXTRA,
                                'label'       => false,
                                'type'        => 'number',
                                'placeHolder' => __(MSG_PRICE),
                                'templates'   => $templates,
                            ]
                        );
                        ?>
                    </td>
                    <td>
                        <button class="btn btn-xs btn-danger tr_extra_remove_row">
                            <span class="glyphicon glyphicon-minus"
                                  aria-hidden="true"></span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
        <td>
            <button value="Submit"
                    class="btn btn-danger tr_remove_row"
                    type="button"><span
                        class="glyphicon glyphicon-minus"
                        aria-hidden="true"></span>
            </button>
        </td>
    </tr>
    </tbody>
</table>