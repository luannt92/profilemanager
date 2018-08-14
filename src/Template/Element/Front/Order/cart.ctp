<?php
foreach ($carts as $k => $cart) {
    $flag = ! empty($cart['product_note']) ? true
        : false; ?>
    <div class="col-xs-12 box-product">
        <div class="row box-cart">
            <div class="col-sm-1 multi">
                <span>x<?php echo $cart['quantity']; ?></span>
            </div>
            <div class="col-xs-4 dish">
                <span><?php echo $cart['name']; ?></span>
            </div>
            <div class="col-xs-3 edit-pro">
                <?php
                echo $this->Html->link($this->Html->image('edit3.png',
                    ['alt' => 'Sub']), '', [
                    'escape'    => false,
                    'data-attr' => $cart['id']
                        . $cart['name_option'],
                    'data-type' => '-1',
                    'class'     => 'updateCart',
                ]);

                echo $this->Html->link($this->Html->image('edit2.png',
                    ['alt' => 'Plus']), '', [
                    'escape'    => false,
                    'data-attr' => $cart['id']
                        . $cart['name_option'],
                    'data-type' => '1',
                    'class'     => 'updateCart',
                ]);
                echo $this->Html->link($this->Html->image('edit1.png',
                    ['alt' => 'Notes']),
                    '#add-notes' . $k,
                    [
                        'escape'      => false,
                        'data-toggle' => 'collapse',
                    ]);
                ?>
            </div>
            <div class="col-xs-2 price">
                <span>
                    <?php
                    echo $this->Number->format(($cart['price']
                            + $cart['total_options'])
                        * $cart['quantity'], [
                        'places' => 0,
                        'after'  => '<u>đ</u>',
                        'escape' => false,
                    ]);
                    ?>
                </span>
            </div>
            <div class="col-xs-2 delete">
                <?php echo $this->Html->link($this->Html->image('del.png',
                    ['alt' => 'Delete']), '', [
                    'data-attr' => $cart['id']
                        . $cart['name_option'],
                    'escape'    => false,
                    'class'     => "removeCart",
                ]); ?>
            </div>
            <div class="col-xs-11 col-xs-offset-1 notes">
                <span>
                    <?php echo $cart['displayOption']; ?>
                    <p><?php echo $cart['promotion']; ?></p>
                </span>
            </div>
        </div>
        <!-- box-cart -->
        <div class="row collapse row-notes"
             id="add-notes<?php echo $k; ?>">
            <div class="col-xs-12 add-note">
                <fieldset>
                    <legend><?php echo $flag
                            ? __(UPDATE_NOTE_CART)
                            : __(ADD_NOTE_CART); ?></legend>
                    <textarea class="form-control"
                              rows="3"
                              placeholder='E.g: "For Thomas" or "Without onions"'><?php echo $cart['product_note']; ?></textarea>
                </fieldset>
                <div class="addorno">
                    <button type="button" class="btn btn-sm btn-cancel">
                        <?php echo __(CART_CANCEL); ?>
                    </button>
                    <button class="btn btn-sm btn-add"
                            data-attr="<?php echo $k; ?>">
                        <?php echo $flag
                            ? __('Save')
                            : __(CART_ADD); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php echo $this->Html->scriptStart(['block' => true]); ?>
<!--<script>-->
    $('#cart-content').on('click', 'button.btn-cancel', function () {
        $(this).closest('.row-notes').removeClass('in');
    });
<?php echo $this->Html->scriptEnd(); ?>
