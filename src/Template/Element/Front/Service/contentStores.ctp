<?php
foreach ($stores as $store) {
    $hashTag = null;
    if ($store['categories']) {
        $categories = [];
        foreach ($store['categories'] as $k => $category) {
            if ($k === '_locale') {
                continue;
            }
            if ($category['name']) {
                $categories[] = $category['name'];
            }
            $hashTag .= "<li>{$category['name']}</li>";
        }
    }
    $time_open  = ! empty($store['time_open'])
        ? $store['time_open']->format('H:i') : '';
    $time_close = ! empty($store['time_close'])
        ? $store['time_close']->format('H:i') : '';
    $imgs       = ! empty($store['image']) ? $store['image'] : NO_IMAGE;
    ?>
    <div class="col-sm-4 col-xs-6 col-rest col-area">
        <div class="restaurant-info">
            <?php if (empty($store['store_hours'])) { ?>
                <div class="rest-image">
                    <?php echo $this->Html->link($this->Html->image($imgs,
                            ['alt' => $store['name'], 'class' => 'pending'])
                        . "<span class=\"pending-note\">" . __(TEXT_CLOSE_HOUR)
                        . "</span>",
                        '#',
                        ['escape' => false]); ?>
                </div>

                <div class="col-xs-8 col-sm-6 rest-row text-row">
                    <div class="rest-list pending">
                        <?php echo $this->Html->link('<h3 class="restaurant-pos">'
                            . $store['name'] . '</h3>',
                            '#', [
                                'href'        => '#myNotifi',
                                'data-toggle' => 'modal',
                                'escape'      => false,
                            ]);
                        if ( ! empty($hashTag)) {
                            echo '<ul class="list-hashrest">' . $hashTag
                                . '</ul>';
                        }
                        ?>
                    </div>
                    <p><span class="pending-note">
                            <?php echo __(TEXT_CLOSE_HOUR); ?>
                        </span></p>
                </div>

                <div class="col-xs-12 col-sm-3 rest-row col-row">
                    <p><span class="pending-note">
                            <?php echo $store['note']; ?>
                        </span></p>
                </div>
            <?php } else { ?>
                <?php
                if ($store['status'] == ACTIVE) {
                    $htmlHour = '';
                    foreach ($store['store_hours'] as $store_hours) {
                        $time_open  = ! empty($store_hours['time_open'])
                            ? $store_hours['time_open']->format('H:i') : '';
                        $time_close = ! empty($store_hours['time_close'])
                            ? $store_hours['time_close']->format('H:i') : '';
                        $htmlHour   .= '<br>' . $time_open . ' - '
                            . $time_close;
                    }
                    ?>
                    <div class="rest-image">
                        <?php echo $this->Html->link($this->Html->image($imgs)
                            . "<span class=\"hour\">" . __('Opening times')
                            . ":" . $htmlHour . "</span>",
                            [
                                'controller' => 'stores',
                                'action'     => 'view',
                                $store['slug'],
                            ],
                            ['escape' => false]); ?>
                    </div>

                    <div class="col-xs-8 col-sm-6 rest-row text-row">
                        <div class="rest-list">
                            <?php echo $this->Html->link('<h3 class="restaurant-pos">'
                                . $store['name'] . '</h3>',
                                [
                                    'controller' => 'stores',
                                    'action'     => 'view',
                                    $store['slug'],
                                ], [
                                    'href'        => '#myNotifi',
                                    'data-toggle' => 'modal',
                                    'escape'      => false,
                                ]);
                            if ( ! empty($hashTag)) {
                                echo '<ul class="list-hashrest">' . $hashTag
                                    . '</ul>';
                            }
                            ?>
                        </div>
                        <p><span class="hour">
                            <?php echo __('Opening times') . ': ' . $time_open
                                . ' - '
                                . $time_close; ?>
                        </span></p>
                    </div>

                    <div class="col-xs-12 col-sm-3 rest-row col-row">
                        <p><span class="hour">
                            <?php echo __('Opening times') . ': ' . $time_open
                                . ' - '
                                . $time_close; ?>
                        </span></p>
                    </div>
                <?php } else { ?>
                    <div class="rest-image">
                        <?php echo $this->Html->link($this->Html->image($imgs,
                                ['alt' => $store['name'], 'class' => 'pending'])
                            . "<span class=\"pending-note\">" . $store['note']
                            . "</span>",
                            '#',
                            ['escape' => false]); ?>
                    </div>

                    <div class="col-xs-8 col-sm-6 rest-row text-row">
                        <div class="rest-list pending">
                            <?php echo $this->Html->link('<h3 class="restaurant-pos">'
                                . $store['name'] . '</h3>',
                                '#', [
                                    'href'        => '#myNotifi',
                                    'data-toggle' => 'modal',
                                    'escape'      => false,
                                ]);
                            if ( ! empty($hashTag)) {
                                echo '<ul class="list-hashrest">' . $hashTag
                                    . '</ul>';
                            }
                            ?>
                        </div>
                        <p><span class="pending-note">
                            <?php echo $store['note']; ?>
                        </span></p>
                    </div>

                    <div class="col-xs-12 col-sm-3 rest-row col-row">
                        <p><span class="pending-note">
                            <?php echo $store['note']; ?>
                        </span></p>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
<?php } ?>
