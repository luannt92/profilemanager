<?php
foreach ($products as $k => $product) {
    $imgUrl = ! empty($product['image']) ? $product['image'] : NO_IMAGE_DEFAULT;

    $imgUrlF = str_replace('thumbs', 'source', $imgUrl);
    if ( ! empty($product['product_discounts'])) {
        $product['price'] = $product['price'] + ($product['commission'] / 100
                * $product['price'])
            - ($product['product_discounts'][0]['percent'] / 100
                * $product['price']);
    } else {
        $product['price'] = $product['price'] + ($product['commission'] / 100
                * $product['price']);
    }
    $price     = $this->Number->format($product['price'], [
        'places' => 0,
        'after'  => ' <u>đ</u>',
        'escape' => false,
    ]);
    $attribute = null;
    $addtocart = 'addToCart';
    $count     = ++$k;
    if ( ! empty($product['product_attributes'])) {
        $attribute
                   = "data-target=\"#addproduct{$count}\" data-toggle=\"collapse\"";
        $addtocart = '';
    }
    $promotion = ! empty($product['promotion'])
        ? $product['promotion']['description'] : '';
    ?>
    <div class="col-sm-6 block" id="<?php echo $count; ?>">
        <div class="block-order row" <?php echo $attribute; ?>>
            <div class="col-xs-7 col-order <?php echo $addtocart; ?>"
                 data-quantity="" data-option=""
                 data-attr="<?php echo $product['id']; ?>">
                <h3><?php echo mb_strtolower($product['name']); ?></h3>
                <p><?php echo $promotion; ?></p>
                <p><?php echo $product['description']; ?></p>
            </div>
            <div class="col-xs-5 col-order">
                <div class="order-img col-xs-12 col-l">
                    <?php
                    if ( ! empty($imgUrl)) {
                        echo $this->Html->link($this->Html->image($imgUrl,
                            ['alt' => $product['name']]),
                            $this->Url->image($imgUrlF),
                            ['class' => 'fancybox', 'escape' => false,]);
                    }
                    ?>
                </div>
                <div class="price-oradd col-xs-12 col-l">
                    <div class="spn-pr">
                        <?php
                        if (empty($product['product_attributes'])) {
                            echo "<button class=\"btn data addToCart\" data-quantity=\"\" data-option=\"\" data-attr="
                                . $product['id'] . "><span>" . $price
                                . "</span></button>";
                        } else {
                            echo "<button data-target=\"#addproduct" . $count
                                . "\" data-toggle=\"collapse\" class=\"btn data\"><span>"
                                . $price
                                . "</span> <i class=\"fa fa-bars\"></i> </button>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ( ! empty($product['product_attributes'])) { ?>
        <div id="addproduct<?php echo $count; ?>"
             class="col-sm-12 col-addoption collapse">
            <div class="block-order row" id="pqd<?php echo $product['id']; ?>">
                <form class="col-sm-12 form-addoption" action="">
                    <span class="caret-span2 caret-top"></span>
                    <h3><?php echo mb_strtolower($product['name']); ?></h3>
                    <?php foreach (
                        $product['product_attributes'] as $i =>
                        $product_attributes
                    ) {
                        if ($product_attributes['type'] == OP_SELECT) { ?>
                            <div class="form-group">
                                <p><?php echo $product_attributes['name']
                                        . ':'; ?></p>
                                <?php
                                $listValues = [];
                                foreach (
                                    $product_attributes['product_attribute_values']
                                    as $j => $product_attribute_values
                                ) {
                                    if ( ! empty($product['product_discounts'])) {
                                        $product_attribute_values['price']
                                            = $product_attribute_values['price']
                                            + ($product['commission'] / 100
                                                * $product_attribute_values['price'])
                                            - ($product['product_discounts'][0]['percent']
                                                / 100
                                                * $product_attribute_values['price']);
                                    } else {
                                        $product_attribute_values['price']
                                            = $product_attribute_values['price']
                                            + ($product['commission'] / 100
                                                * $product_attribute_values['price']);
                                    }
                                    $priceOp
                                        = $this->Number->format($product_attribute_values['price'],
                                        [
                                            'places' => 0,
                                            'after'  => ' đ',
                                            'escape' => false,
                                        ]);
                                    $listValues[$product_attribute_values['id']
                                    . ';' . $product_attribute_values['price']]
                                        = $product_attribute_values['name']
                                        . ' (+' . $priceOp . ')';
                                }
                                echo $this->Form->input('product_attribute_values',
                                    [
                                        'options'  => $listValues,
                                        'label'    => false,
                                        'class'    => 'form-control',
                                        'empty'    => ['0;0' => __('--- Please select ---')],
                                        'type'     => 'select',
                                        'onChange' => 'changeCheckbox('
                                            . $product['id'] . ','
                                            . $product['price'] . ')',
                                    ]);
                                ?>
                            </div>
                        <?php } else { ?>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <p><?php echo $product_attributes['name']
                                            . ':'; ?></p>
                                </div>
                                <?php foreach (
                                    $product_attributes['product_attribute_values']
                                    as $j => $product_attribute_values
                                ) {
                                    if ( ! empty($product['product_discounts'])) {
                                        $product_attribute_values['price']
                                            = $product_attribute_values['price']
                                            + ($product['commission'] / 100
                                                * $product_attribute_values['price'])
                                            - ($product['product_discounts'][0]['percent']
                                                / 100
                                                * $product_attribute_values['price']);
                                    } else {
                                        $product_attribute_values['price']
                                            = $product_attribute_values['price']
                                            + ($product['commission'] / 100
                                                * $product_attribute_values['price']);
                                    }
                                    $priceOp
                                        = $this->Number->format($product_attribute_values['price'],
                                        [
                                            'places' => 0,
                                            'after'  => ' đ',
                                            'escape' => false,
                                        ]);
                                    ?>
                                    <div class="col-sm-6">
                                        <div class="bdr-checkadd">
                                        <span class="checkbox cr-span">
                                            <label class="selectit">
                                              <input type="checkbox"
                                                     class="form-control"
                                                     onclick="changeCheckbox(<?php echo $product['id']; ?>, <?php echo $product['price']; ?>);"
                                                     data-attr="<?php echo $product_attribute_values['price']; ?>"
                                                     value="<?php echo $product_attribute_values['id']; ?>">
                                              <span class="cr"><i
                                                          class="cr-icon fa fa-check"></i></span>
                                                <?php echo $product_attribute_values['name']
                                                    . ' (+' . $priceOp . ')'; ?>
                                            </label>
                                        </span>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <div class="row check-price">
                        <div class="col-sm-6">
                            <a class="subnum"
                               onclick="quantityProduct(<?php echo $product['id']
                                   . ', \'sub\', '
                                   . $product['price']; ?>);"><?php echo $this->Html->image('edit3.png',
                                    ['alt' => 'Sub']); ?></a>
                            <span><input type="number" min="1"
                                         class="inp-numlist"
                                         value="1" size="5" readonly/></span>
                            <a class="addnum"
                               onclick="quantityProduct(<?php echo $product['id']
                                   . ', \'add\', '
                                   . $product['price']; ?>);"><?php echo $this->Html->image('edit2.png',
                                    ['alt' => 'Add']); ?></a>
                        </div>
                        <div class="col-sm-6">
                            <div class="price-oradd">
                                <div class="spn-pr">
                                    <?php echo "<button class=\"btn data addToCart\" data-quantity=\"\" data-option=\"\" data-attr="
                                        . $product['id'] . "><span>" . $price
                                        . "</span></button>"; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- block-order -->
        </div>
    <?php } ?>
<?php } ?>

<?php echo $this->Html->scriptStart(['block' => true]); ?>
<!--<script>-->
    function quantityProduct(a, b, p) {
        var inp = $('#pqd' + a + ' .inp-numlist').val();
        if (b == 'sub') {
            if (inp > 1) {
                inp--;
                $('#pqd' + a + ' .inp-numlist').val(inp);
            }
        } else {
            inp++;
            $('#pqd' + a + ' .inp-numlist').val(inp);
        }
        changeCheckbox(a, p)
    }

    function changeCheckbox(a, p) {
        var sumCheckboxs = 0;
        var sumSelects = 0;
        var idOptionsC = [];
        var idOptionsS = [];
        $('#pqd' + a + ' input:checked').each(function () {
            sumCheckboxs += parseInt($(this).attr('data-attr'));
            idOptionsC.push($(this).val());
        });
        $('#pqd' + a + ' option:selected').each(function () {
            var selects = $(this).val().split(";");
            sumSelects += parseInt(selects[1]);
            if (selects[0] != 0) {
                idOptionsS.push(selects[0]);
            }
        });
        var idOptions = idOptionsC.concat(idOptionsS);

        var quantity = $('#pqd' + a + ' .inp-numlist').val();

        var totalSumOption = (sumCheckboxs + sumSelects + p) * quantity;
        var total = totalSumOption.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.") + ' ₫';
        $('#pqd' + a + ' .addToCart span').text(total);
        $('#pqd' + a + ' .addToCart').attr('data-option', idOptions);
        $('#pqd' + a + ' .addToCart').attr('data-quantity', quantity);
    }
    <?php echo $this->Html->scriptEnd(); ?>
