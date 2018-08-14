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
        <th class="col-md-7 ">
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