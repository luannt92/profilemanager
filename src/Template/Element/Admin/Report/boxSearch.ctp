<?php
$url          = ['action' => 'flotAjax'];
$typeTimeHtml = $selectZones = $exportHtml = "";
$startDate    = $endDate = "";
$dataUrl      = $selectShippers = "";

if (isset($typeTime)) {
    $types = [
        FLOT_DAY    => 'Daily',
        FLOT_MONTH  => 'Monthly',
        FLOT_ANNUAL => 'Annual',
    ];
    $typeTimeHtml
           = '<div class="col-sm-3"><label for="">&nbsp</label><div class="btn-group input-group">';
    foreach ($types as $key => $type) {
        $active       = ($typeTime == $key) ? 'active' : '';
        $typeTimeHtml .= $this->Form->button(__($type), [
            'class'     => 'btn btn-white btn-s-time ' . $active,
            'type'      => 'button',
            'data-type' => $key,
        ]);
    }
    $typeTimeHtml .= '</div></div>';

    if ( ! empty($search['start_date'])) {
        $startDate = $search['start_date'];
        if ($typeTime == FLOT_MONTH) {
            $startDate = $startDate . '-01';
        } elseif ($typeTime == FLOT_ANNUAL) {
            $startDate = $startDate . '-01-01';
        }

    }
    if ( ! empty($search['end_date'])) {
        $endDate = $search['end_date'];
        if ($typeTime == FLOT_MONTH) {
            $endDate = $endDate . '-01';
        } elseif ($typeTime == FLOT_ANNUAL) {
            $endDate = $endDate . '-01-01';
        }
    }
}

if (isset($zones)) {
    $url         = ['action' => 'zone'];
    $dataUrl     = $this->Url->build($url);
    $selectZones = '<div class="col-sm-2"><label for="">' . __('Zones')
        . '</label>';
    $zones[-1] = 'Unassigned Area';
    $selectZones .= $this->Form->control('zone', [
        'label'   => false,
        'options' => $zones,
        'class'   => 'form-control',
        'empty'   => 'Total',
        'value'   => isset($search['zone'])
            ? $search['zone'] : '',
    ]);
    $selectZones .= '</div>';
}

if (isset($export)) {
    $exportHtml .= $this->Form->button('<i class="fa fa-file-excel-o"></i> '
        . __('Excel'), [
        'class'    => 'btn btn-primary btn-export-excel',
        'escape'   => false,
        'data-url' => $export,
        'type'     => 'submit',
    ]);
}

$statusOptions = [
    CANCEL     => 'Cancel',
    PROCESSING => 'Processing',
    CONFIRMED  => 'Confirmed',
    SHIPPED    => 'Shipped',
    RECEIVED   => 'Received',
];

if (isset($shippers)) {
    $url            = ['action' => 'shipper'];
    $dataUrl        = $this->Url->build($url);
    $selectShippers = '<div class="col-sm-2"><label for="">' . __('Shippers')
        . '</label>';
    $selectShippers .= $this->Form->control('shipper', [
        'label'   => false,
        'options' => $shippers,
        'empty'   => __('-- Select shipper --'),
        'class'   => 'form-control',
        'value'   => isset($search['shipper'])
            ? $search['shipper'] : '',
    ]);
    $selectShippers .= '</div>';
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row">
                    <?php echo $this->Form->create(null, [
                        'type'  => 'post',
                        'class' => 'form-search-flot',
                        'url'   => $url,
                    ]); ?>
                    <?php
                    if (isset($isCustomer)):
                        ?>
                        <div class="col-sm-4">
                            <label for="group-id">Users</label>
                            <div class="input-daterange input-group">
                                <?php
                                echo $this->Form->control('uid', [
                                        'class'   => 'form-control',
                                        'label'   => false,
                                        'options' => $users,
                                        'empty'   => '-- Select users --',
                                        'value'   => isset($search['start_date'])
                                            ? $search['start_date'] : '',
                                    ]
                                );
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php
                    echo $selectShippers;
                    echo $selectZones;
                    echo $typeTimeHtml;
                    ?>
                    <div class="col-sm-4">
                        <label for="group-id">Time</label>
                        <div class="input-daterange input-group">
                            <?php
                            echo $this->Form->control('start_date', [
                                    'class'                  => 'form-control dtpStart',
                                    'label'                  => false,
                                    'empty'                  => true,
                                    'data-date-default-date' => $startDate,
                                ]
                            );
                            ?>
                            <span class="input-group-addon">-</span>
                            <?php echo $this->Form->control('end_date', [
                                    'class'                  => 'form-control dtpEnd',
                                    'label'                  => false,
                                    'empty'                  => true,
                                    'data-date-default-date' => $endDate,
                                ]
                            ); ?>
                        </div>
                    </div>
                    <?php
                    if ( ! empty($isReportOrder)) {
                        echo "<div class=\"col-sm-2\">";
                        echo $this->Form->control('status', [
                                'class'   => 'form-control',
                                'value'   => isset($search['status'])
                                    ? $search['status'] : '',
                                'empty'   => __(ALL),
                                'options' => $statusOptions,
                            ]
                        );
                        echo "</div>";
                    } ?>
                    <div class="col-sm-3">
                        <label for="group-id">&nbsp</label>
                        <div class="input select block">
                            <?php echo $this->Form->button(
                                '<i class="fa fa-search"></i> ' . __(SEARCH), [
                                    'type'     => 'submit',
                                    'class'    => 'btn btn-primary m-b btn-search-flot',
                                    'data-url' => $dataUrl,
                                    'escape'   => false,
                                ]
                            );
                            echo $this->Form->input('type', [
                                    'class' => 'typeFlot',
                                    'type'  => 'hidden',
                                    'value' => FLOT_DAY,
                                ]
                            );
                            ?>
                            <?php echo $exportHtml; ?>
                            <?php echo $this->Html->link(
                                '<i class="fa fa-refresh"></i>',
                                $this->Url->build(),
                                [
                                    'class'       => 'btn btn-white m-b m-l-sm',
                                    'escapeTitle' => false,
                                ]
                            );
                            ?>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>