<?php
$tabsFlot  = [
    [
        'title' => 'Today',
        'type'  => FLOT_DAY,
    ],
    [
        'title' => 'Monthly',
        'type'  => FLOT_MONTH,
    ],
    [
        'title' => 'Annual',
        'type'  => FLOT_ANNUAL,
    ],
];
$tabOrders = [
    'order-current',
    'order-last',
    'month-income',
];

$blocks      = [
    [
        'title'     => 'Revenue',
        'title1'    => 'Total revenue',
        'spanText'  => 'Monthly',
        'spanClass' => 'label-success',
        'textClass' => 'text-success',
        'number'    => empty($totalIncome) ? 0 : $totalIncome,
        'percent'   => empty($perIncome) ? 0 : $perIncome,
    ],
    [
        'title'     => 'Orders',
        'title1'    => 'New orders',
        'spanText'  => 'Today',
        'spanClass' => 'label-warning',
        'textClass' => 'text-warning',
        'number'    => empty($orderNumber) ? 0 : $orderNumber,
        'percent'   => empty($perOrder) ? 0 : $perOrder,
    ],
    [
        'title'     => 'Visits',
        'title1'    => 'New visits',
        'spanText'  => 'Today',
        'spanClass' => 'label-primary',
        'textClass' => 'text-navy',
        'number'    => $userLog,
        'percent'   => $perUserLog,
    ],
    [
        'title'     => 'User activity',
        'title1'    => 'Order',
        'spanText'  => 'Today',
        'spanClass' => 'label-danger',
        'textClass' => 'text-danger',
        'number'    => 0,
        'percent'   => 0,
        'activity'  => $userTracking,
    ],
];
$htmlFlotTab = $htmlBlock = $htmlTabOrder = "";
foreach ($tabsFlot as $tab) {
    $class       = $tab['type'] === FLOT_DAY ? "active" : "";
    $htmlFlotTab .= $this->Form->button($tab['title'], [
        'type'      => 'button',
        'class'     => "btn btn-xs btn-white btn-flot {$class}",
        'data-url'  => $this->Url->build(['action' => 'flotAjax']),
        'data-type' => $tab['type'],
    ]);
}
foreach ($blocks as $block) {
    $number      = $this->Number->format($block['number']);
    $percent     = $this->Number->format($block['percent'], ['after' => '%']);
    $iconPercent = $this->Utility->checkPercent($block['percent']);

    if (isset($block['activity'])) {
        $checkout = 0;
        foreach ($block['activity'] as $action) {
            if ($action['action'] == TRACKING_ORDER_TXT) {
                $number = $action['count'];
                continue;
            }
            $checkout = ($action['action'] == TRACKING_CHECKOUT_TXT)
                ? $action['count']
                : $checkout;
        }
        $iboxContent
            = "<div class=\"ibox-content row m-n text-center\"><div class=\"col-xs-6\">
            <h1 class=\"no-margins\">{$number}</h1><small>{$block['title1']}</small></div>
            <div class=\"col-xs-6\"><h1 class=\"no-margins\">{$checkout}</h1><small>Checkout</small></div></div>";
    } else {
        $iboxContent
            = "<div class=\"ibox-content\"><h1 class=\"no-margins\">{$number}</h1>
        <div class=\"stat-percent font-bold {$block['textClass']} \">{$percent}
        {$iconPercent}</div><small>{$block['title1']}</small></div>";
    }

    $htmlBlock
        .= "<div class=\"col-lg-3\"><div class=\"ibox float-e-margins\">
        <div class=\"ibox-title\"><span class=\"label {$block['spanClass']} pull-right\">
        {$block['spanText']}</span><h5>{$block['title']}</h5></div>{$iboxContent}</div></div>";
}

foreach ($tabOrders as $tab) {
    $htmlTabOrder
        .= "<li class=\"{$tab}\"><h2 class=\"no-margins\"></h2>
         <small></small><div class=\"stat-percent\"></div>
         <div class=\"progress progress-mini\"><div class=\"progress-bar\"></div>
         </div></li>";
}
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <?php echo $htmlBlock; ?>
    </div>
    <?php echo $this->element('Admin/Report/boxSearch'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins toggleSpinners">
                <div class="ibox-title">
                    <h5>Orders</h5>
                    <div class="pull-right">
                        <div class="btn-group">
                            <?php echo $htmlFlotTab; ?>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="flot-chart">
                                <div class="flot-chart-content"
                                     id="flot-dashboard-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <ul class="stat-list">
                                <?php echo $htmlTabOrder; ?>
                            </ul>
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
        'admin/plugins/flot/jquery.flot.js',
        'admin/plugins/flot/jquery.flot.axislabels.js',
        'admin/plugins/flot/jquery.flot.tooltip.min.js',
        'admin/plugins/flot/jquery.flot.spline.js',
        'admin/plugins/flot/jquery.flot.resize.js',
        'admin/plugins/flot/jquery.flot.pie.js',
        'admin/plugins/flot/jquery.flot.symbol.js',
        'admin/plugins/flot/jquery.flot.time.js',
        'admin/plugins/peity/jquery.peity.min.js',
        'admin/demo/peity-demo.js',
        'admin/moment.js',
        'admin/plugins/datetime/datetimepicker.min.js',
    ],
    ['block' => 'scriptBottom']
);
?>
<?php
echo $this->Html->script(
    [
        'admin/plugins/jquery-ui/jquery-ui.min.js',
        /* 'admin/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js',
         'admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',*/
        'admin/plugins/easypiechart/jquery.easypiechart.js',
        'admin/plugins/sparkline/jquery.sparkline.min.js',
        'admin/demo/sparkline-demo.js',
    ],
    ['block' => true]
);
?>

<?php echo $this->Html->scriptStart(['block' => true]); ?>
    $(document).ready(function () {
        function sendMessageError(mess) {
            setTimeout(function () {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    preventDuplicates: true,
                    showMethod: 'slideDown',
                    timeOut: 2000
                };
                toastr.error(mess, 'Message');
            }, 500);
        }

        $('.btn-search-flot').on('click', function (e) {
            e.preventDefault();
            var form = $('.form-search-flot');
            var url = form.attr('action');
            var data = form.serializeArray();
            data.push({name: 'profit', value: 0});
            var dt = form.find('#type').val();
            $('.toggleSpinners').children('.ibox-content').toggleClass('sk-loading');
            $.ajax({
                type: 'post',
                url: url,
                data: data,
                success: function (result) {
                    $('.toggleSpinners').children('.ibox-content').toggleClass('sk-loading');
                    var rlt = JSON.parse(result);
                    if (rlt.error == null) {
                        pushDataForFlotChart(rlt, dt);
                    } else {
                        sendMessageError(rlt.error);
                    }
                }
            });

        });

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

        $.each($('.btn-flot'), function (e, k) {
            $(k).on('click', function () {
                var self = $(this);
                var url = self.attr('data-url');
                var dt = self.attr('data-type');
                var format = 'YYYY-MM-DD', viewMode = 'days';

                self.parent().children().removeClass('active');
                self.addClass('active');
                $('.typeFlot').val(dt);
                $('.dtpEnd').data("DateTimePicker").clear();
                $('.dtpStart').data("DateTimePicker").clear();

                $('.dtpEnd').attr('disabled', true);
                if (dt != 1) {
                    $('.dtpEnd').attr('disabled', false);
                    if (dt == 2) {
                        viewMode = 'months';
                        format = 'YYYY-MM';
                    } else if (dt == 3) {
                        viewMode = 'years';
                        format = 'YYYY';
                    }
                }
                $('.dtpStart').data("DateTimePicker").options({
                    viewMode: viewMode,
                    format: format
                });
                $('.dtpEnd').data("DateTimePicker").options({
                    viewMode: viewMode,
                    format: format
                });
                $('.toggleSpinners').children('.ibox-content').toggleClass('sk-loading');

                $.ajax({
                    type: 'post',
                    url: url,
                    data: {type: dt, profit : 0},
                    success: function (result) {
                        $('.toggleSpinners').children('.ibox-content').toggleClass('sk-loading');
                        var rlt = JSON.parse(result);
                        pushDataForFlotChart(rlt, dt);
                    }
                });
            });

            if ($(k).hasClass('active')) {
                $(k).trigger('click');
            }
        });

        function pushDataForFlotChart(rlt, type) {
            var title1 = 'Total orders in period',
                title2 = 'Orders in yesterday',
                title3 = 'Today revenue from orders';

            if (type == 2) {
                title1 = 'Total orders in period';
                title2 = 'Orders in last month';
                title3 = 'Monthly revenue from orders';
            } else if (type == 3) {
                title1 = 'Total orders in period';
                title2 = 'Orders in last year';
                title3 = 'Annual revenue from orders';
            }

            generateFlotDashboards(rlt.data, type);
            blockPercent('.order-current', rlt.perOrderLast, rlt.orderCurrent, title1);
            blockPercent('.order-last', rlt.perOrderLast2, rlt.orderLast, title2);
            blockPercent('.month-income', rlt.perIncome, rlt.income, title3);
        }

        function generateFlotDashboards(data, type) {
            var dataX = [], dataY = [], tickSize = [1, "hour"];
            var barWidth = 60 * 60 * 600, format = "%H:%M";
            if (type == 3) {
                tickSize = [1, "year"];
                barWidth *= 24 * 365;
                format = "%Y";
            } else if (type == 2) {
                tickSize = [1, "month"];
                barWidth *= 24 * 30;
                format = "%d %Y";
            }

            $.each(data, function (k, v) {
                var d = new Date(), y = d.getFullYear(),
                    m = d.getMonth() + 1, day = d.getDay() - 1;
                var vt = type != 2 ? parseInt(v.times, 10) : v.times.toString().split('-');

                if (type == 3) {
                    y = vt;
                } else if (type == 2) {
                    y = parseInt(vt[0], 10);
                    m = parseInt(vt[1], 10);
                }
                var timestamp = type == 1 ? gh(y, m, day, vt) : gd(y, m, 1);
                dataX[k] = [timestamp, v.quantity];
                dataY[k] = [timestamp, v.price];
            });
            dataX = dataX.sort(function (a, b) {
                return a[0] - b[0];
            });
            dataY = dataY.sort(function (a, b) {
                return a[0] - b[0];
            });

            var dataset = [
                {
                    label: "Number of orders",
                    data: dataX,
                    format: format,
                    color: "#1ab394",
                    bars: {
                        show: true,
                        align: "center",
                        barWidth: barWidth,
                        lineWidth: 0
                    }
                }, {
                    label: "Payments",
                    data: dataY,
                    yaxis: 2,
                    color: "#1C84C6",
                    lines: {
                        lineWidth: 1,
                        show: true,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.2
                            }, {
                                opacity: 0.4
                            }]
                        }
                    },
                    splines: {
                        show: false,
                        tension: 0.6,
                        lineWidth: 1,
                        fill: 0.1
                    },
                }
            ];

            var options = {
                xaxis: {
                    mode: "time",
                    tickSize: tickSize,
                    tickLength: 0,
                    axisLabel: "Date",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Arial',
                    axisLabelPadding: 10,
                    color: "#d5d5d5"
                },
                yaxes: [{
                    position: "left",
                    color: "#d5d5d5",
                    tickDecimals: 0,
                    axisLabel: '(Quantity)',
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Arial',
                    axisLabelPadding: 10
                }, {
                    position: "right",
                    color: "#d5d5d5",
                    axisLabel: '(VNĐ)',
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: ' Arial',
                    axisLabelPadding: 5
                }
                ],
                legend: {
                    noColumns: 1,
                    labelBoxBorderColor: "#000000",
                    position: "nw"
                },
                grid: {
                    hoverable: false,
                    borderWidth: 0
                }
            };

            $.plot($("#flot-dashboard-chart"), dataset, options);
        }

        $('.chart').easyPieChart({
            barColor: '#f8ac59',
//                scaleColor: false,
            scaleLength: 5,
            lineWidth: 4,
            size: 80
        });

        $('.chart2').easyPieChart({
            barColor: '#1c84c6',
//                scaleColor: false,
            scaleLength: 5,
            lineWidth: 4,
            size: 80
        });

        function gd(year, month, day) {
            return new Date(year, month - 1, day).getTime();
        }

        function gh(year, month, day, hour) {
            var d = new Date(year, month, day, hour, 0, 0);
            var utc = (7 * 60 * 60 * 1000);
            return d.getTime() + utc;
        }

        function blockPercent(cls, number, value, title) {
            var percent = '<i class="fa fa-bolt  text-navy"></i>';
            if (number > 0) {
                percent = '<i class="fa fa-level-up text-navy"></i>';
            } else if (number < 0) {
                percent = '<i class="fa fa-level-down text-navy"></i>';
            }
            var num = number + '%';
            var val = parseFloat(value.toString().replace(/,/g, "")).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            $(cls).children('h2').html(val);
            $(cls).children('small').html(title);
            $(cls).children('.stat-percent').html(percent);
            $(cls).children('.progress').children('.progress-bar').attr('style', 'width:' + num);
        }

        var previousPoint = null, previousLabel = null;


        var mapData = {
            "US": 298,
            "SA": 200,
            "DE": 220,
            "FR": 540,
            "CN": 120,
            "AU": 760,
            "BR": 550,
            "IN": 200,
            "GB": 120,
        };

        /*$('#world-map').vectorMap({
            map: 'world_mill_en',
            backgroundColor: "transparent",
            regionStyle: {
                initial: {
                    fill: '#e4e4e4',
                    "fill-opacity": 0.9,
                    stroke: 'none',
                    "stroke-width": 0,
                    "stroke-opacity": 0
                }
            },

            series: {
                regions: [{
                    values: mapData,
                    scale: ["#1ab394", "#22d6b1"],
                    normalizeFunction: 'polynomial'
                }]
            },
        });*/
    });
<?php echo $this->Html->scriptEnd(); ?>

