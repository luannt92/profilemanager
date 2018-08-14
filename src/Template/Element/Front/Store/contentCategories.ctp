<?php
foreach ($categories as $k => $category) {
    $imgs = ! empty($category['image']) ? $category['image'] : NO_IMAGE;
    ?>
    <div class="col-sm-4 col-xs-6 col-rest col-area">
        <div class="restaurant-info check-category">
            <div class="rest-image">
                <?php echo $this->Html->link($this->Html->image($imgs), '',
                    [
                        'data-attr'   => $category['slug'],
                        'data-store'  => $store->id,
                        'data-number' => $k,
                        'escape'      => false,
                    ]); ?>
            </div>

            <div class="col-xs-8 col-sm-6 rest-row text-row">
                <div class="rest-list">
                    <?php echo $this->Html->link('<h3 class="restaurant-pos">'
                        . $category['name'] . '</h3>', '', [
                        'data-attr'  => $category['slug'],
                        'data-store' => $store->id,
                        'escape'     => false,
                    ]);
                    if ( ! empty($category['description'])) {
                        echo '<ul class="list-hashrest">'
                            . $category['description'] . '</ul>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>