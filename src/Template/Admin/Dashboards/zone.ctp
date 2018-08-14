<?php
$export    = $this->Url->build([
    'controller' => 'Dashboards',
    'action'     => 'excelZone',
]);
$heads     = [
    CANCEL     => [
        'title'   => '<span class="label cancel">' . __('Cancel') . '</span>',
        'class'   => 'text-center',
        'colspan' => [
            __('Quantity'),
            __('Revenue'),
        ],
    ],
    PROCESSING => [
        'title'   => '<span class="label processing">' . __('Processing')
            . '</span>',
        'class'   => 'text-center',
        'colspan' => [
            __('Quantity'),
            __('Revenue'),
        ],
    ],
    CONFIRMED  => [
        'title'   => '<span class="label confirmed">' . __('Confirmed')
            . '</span>',
        'class'   => 'text-center',
        'colspan' => [
            __('Quantity'),
            __('Revenue'),
        ],
    ],
    SHIPPED    => [
        'title'   => '<span class="label shipped">' . __('Shipped') . '</span>',
        'class'   => 'text-center',
        'colspan' => [
            __('Quantity'),
            __('Revenue'),
        ],
    ],
    RECEIVED   => [
        'title'   => '<span class="label received">' . __('Received')
            . '</span>',
        'class'   => 'text-center',
        'colspan' => [
            __('Quantity'),
            __('Revenue'),
            __('Profit'),
        ],
    ],
];
$htmlTable = '';

if ( ! empty($items)) {
    $countArray = count($items);
    $lastRow    = 1;
    foreach ($items as $key => $item) {
        $cls       = ($lastRow == $countArray) ? "font-bold" : "";
        $htmlTable .= "<tr class=\"{$cls}\"><td>{$key}</td>";
        foreach ($item as $keyItem => $value) {
            $price     = $this->Utility->formatAndCalcPrice($value['price'] + $value['feeShipping']);
            $priceOrders
                       = $this->Utility->formatAndCalcPrice($value['priceOrders']);
            $profit    = $keyItem == RECEIVED ? "<td>{$price}</td>" : "";
            $htmlTable .= "<td>{$value['quantity']}</td><td>{$priceOrders}</td>{$profit}";
        }
        $lastRow++;
        $htmlTable .= "</tr>";
    }
}

$heads = array_merge([
    -1 => [
        'title'   => __('Time'),
        'class'   => 'text-center',
        'rowspan' => 2,
    ],
], $heads)
?>
<div class="wrapper wrapper-content">
    <div class="row">
    </div>
    <?php echo $this->element('Admin/Report/boxSearch',
        ['export' => $export]); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo __('Orders'); ?></h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="table-responsive">
                            <?php echo $this->Utility->generateTableReport($heads,
                                $htmlTable); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo $this->Html->css(
    [
        'admin/plugins/datetime/datetimepicker.min.css',
        'admin/plugins/datetime/datetimepicker-standalone.css',
    ],
    ['block' => true]
);
echo $this->Html->script(
    [
        'admin/moment.js',
        'admin/plugins/datetime/datetimepicker.min.js',
    ],
    ['block' => 'scriptBottom']
);
?>
<?php echo $this->Html->scriptStart(['block' => true]); ?>
    $(document).ready(function () {
        $('.dtpStart').datetimepicker({
            format: 'YYYY-MM-DD',
        });
        $('.dtpEnd').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD'
        });
        $(".dtpStart").on("dp.change", function (e) {
            $('.dtpEnd').data("DateTimePicker").minDate(e.date);
        });
        $(".dtpEnd").on("dp.change", function (e) {
            $('.dtpStart').data("DateTimePicker").maxDate(e.date);
        });

        $.each($('.btn-s-time'), function (e, k) {
            $(k).on('click', function () {
                var self = $(this);
                var dt = self.attr('data-type');
                var format = 'YYYY-MM-DD', viewMode = 'days';

                self.parent().children().removeClass('active');
                self.addClass('active');
                $('.typeFlot').val(dt);
                $('.dtpEnd').data("DateTimePicker").clear();
                $('.dtpStart').data("DateTimePicker").clear();

                if (dt == 2) {
                    viewMode = 'months';
                    format = 'YYYY-MM';
                } else if (dt == 3) {
                    viewMode = 'years';
                    format = 'YYYY';
                }

                $('.dtpStart').data("DateTimePicker").options({
                    viewMode: viewMode,
                    format: format
                });
                $('.dtpEnd').data("DateTimePicker").options({
                    viewMode: viewMode,
                    format: format
                });
            });

            if ($(k).hasClass('active')) {
                $(k).trigger('click');
            }
        });

        $('.btn-export-excel').on('click', function () {
            var url = $(this).attr('data-url');
            $('.form-search-flot').attr('action', url);
        });

        $('.btn-search-flot').on('click', function () {
            var url = $(this).attr('data-url');
            $('.form-search-flot').attr('action', url);
        });

    });
    <?php echo $this->Html->scriptEnd(); ?>

