<?php
$clsTable       = $rowOrder = $clsContainTable = $paginate = "";
$typeTable      = empty($sort) ? false : true;
$attrContainer  = $typeTable ? "id=\"content-list\" class=\"content-list\""
    : "class=\"row\"";
$title          = empty($title) ? "" : $title;

$statusOrder = [
    CANCEL     => [
        "class" => "cancel",
        "name"  => __("Cancel"),
    ],
    PROCESSING => [
        "class" => "processing",
        "name"  => __("Processing"),
    ],
    CONFIRMED  => [
        "class" => "confirmed",
        "name"  => __("Confirmed"),
    ],
    SHIPPED    => [
        "class" => "shipped",
        "name"  => __("Shipped"),
    ],
    RECEIVED   => [
        "class" => "",
        "name"  => __("Completed"),
    ],
];

if ( ! empty($orders)) {
    foreach ($orders as $order) {
        $url         = [
            "controller" => "Orders",
            "action"     => "view",
            $order->tracking_number,
        ];
        $trackingNum = $this->Html->link($order->tracking_number, $url);
        $follow      = $this->Html->link(__("Follow"), $url);
        $price     = $this->Number->format($order->payment_pay, ["after" => CURRENCY_UNIT]);
        $feeShip   = $this->Number->format($order->fee_shipping,
            ["after" => CURRENCY_UNIT]);
        $clsStatus = $statusOrder[$order->status]["class"];
        $status    = $statusOrder[$order->status]["name"];
        $rowOrder
                   .= "<tr><td>{$trackingNum}</td><td>{$order->time->format("d/m/Y H:i:s")}</td>
                <td>{$price}</td><td>{$feeShip}</td><td class=\"{$clsStatus}\">
                {$status}</td><td>{$follow}</td></tr>";
    }
}
?>
<div <?php echo $attrContainer; ?>>
    <?php if ($typeTable):
        $time = date('d/m/Y', time());
        $count = count($orders);
        $count = $count === 0 ? "" : " (" . $count . ")";
        $clsTable = "footable table-stripped toggle-arrow-tiny";
        $clsContainTable = "list_detail";
        $dataFilter = $this->request->getData();
        $start = empty($dataFilter['start']) ? $time : $dataFilter['start'];
        $end = empty($dataFilter['end']) ? $time : $dataFilter['end'];
        $paginate
            = "<tfoot><tr><td colspan=\"6\" class=\"footable-visible\">
                       {$this->element('Front/paginator')}</td></tr></tfoot>";

        echo $this->Html->css(
            [
                'bootstrap-datepicker3.min.css',
                'footable/footable.core.css',
            ],
            ['block' => true]
        );
        echo $this->Html->script(
            [
                'bootstrap-datepicker.min.js',
                'footable/footable.all.min.js',
            ],
            ['block' => 'scriptBottom']
        );
        ?>
        <div class="title_text list_order">
            <div class="text-left"><?php echo $title . $count; ?></div>
            <div class="text_order text-right">
                <form action="" method="post">
                    <div class="input-daterange" id="datepicker">
                        <span><?php echo __("From date"); ?></span>
                        <input type="text" class="form-control" name="start"
                               value="<?php echo $start; ?>"/>
                        <span><?php echo __("To date"); ?></span>
                        <span class="date_to">-</span>
                        <input type="text" class="form-control" name="end"
                               value="<?php echo $end; ?>"/>
                        <button type="submit" class="btn btn_order"><?php echo __('View'); ?></button>
                    </div>
                </form>
            </div>
        </div>
        <?php echo $this->Html->scriptStart(['block' => true]); ?>
        jQuery(function ($) {
        $('.footable').footable({paginate:false});
        $('#datepicker').datepicker({
        format : 'dd/mm/yyyy',
        autoclose: true
        });
        });
        <?php echo $this->Html->scriptEnd(); ?>
    <?php else:?>
        <div class="col-xs-12 col-sm-12">
            <div class="text-header-content">
                <p><?php echo $title; ?></p>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-xs-12 col-sm-12 <?php echo $clsContainTable; ?>">
        <div class="table-responsive">
            <table class="table <?php echo $clsTable; ?>">
                <thead>
                <tr>
                    <th data-sort-ignore="true"><?php echo __("Order code"); ?></th>
                    <th><?php echo __("Order date"); ?></th>
                    <th><?php echo __("Purchase money"); ?></th>
                    <th><?php echo __("Shipping cost"); ?></th>
                    <th><?php echo __("Status"); ?></th>
                    <th data-sort-ignore="true"><?php echo __("View detail"); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php echo $rowOrder; ?>
                </tbody>
                <?php echo $paginate; ?>
            </table>
        </div>
    </div>
</div>