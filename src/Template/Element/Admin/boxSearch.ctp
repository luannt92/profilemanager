<?php
$statusOptions = [
    ENABLED  => 'Enabled',
    DISABLED => 'Disabled',
];

if (isset($isOrder) || isset($isStore)) {
    if (isset($status)) {
        $statusItems = [];
        foreach ($status as $key => $stt) {
            $statusItems[$key] = $stt['name'];
        }
        $statusOptions = $statusItems;
    }
}
$discount_id = $this->request->getQuery('discount_id');
?>
<div class="ibox-content m-b-sm border-bottom">
    <?php echo $this->Form->create(null, [
        'type' => 'get',
        'url'  => ['action' => 'index'],
    ]); ?>
    <div class="row">
        <div class="col-sm-4">
            <?php echo $this->Form->control('keyword', [
                    'class'       => 'form-control',
                    'placeholder' => __(SEARCH_KEYWORD),
                    'type'        => 'text',
                    'value'       => isset($search['keyword'])
                        ? $search['keyword'] : '',
                ]
            );
            if (!empty($discount_id)) {
                echo $this->Form->control('discount_id', [
                        'type'        => 'hidden',
                        'value'       => isset($search['discount_id'])
                            ? $search['discount_id'] : '',
                    ]
                );
            }
            ?>
        </div>
        <?php
        if (isset($isProduct)) { ?>
            <div class="col-sm-2">
                <?php echo $this->Form->control('store', [
                        'class'   => 'form-control',
                        'value'   => isset($search['store'])
                            ? $search['store'] : '',
                        'empty'   => __(ALL),
                        'options' => $listStores,
                    ]
                ); ?>
            </div>
        <?php } ?>
        <?php
        if (isset($isOrder) || isset($isVoucher)) {
            ?>
            <div class="col-sm-3">
                <?php echo $this->Form->control('date', [
                        'class'    => 'form-control daterange',
                        'value'    => isset($search['date'])
                            ? $search['date'] : '',
                        'readonly' => true,
                    ]
                ); ?>
            </div>
        <?php } ?>
        <div class="col-sm-2">
            <?php
            if ( ! isset($isLog)) {
                echo $this->Form->control('status', [
                        'class'   => 'form-control',
                        'value'   => isset($search['status'])
                            ? $search['status'] : '',
                        'empty'   => __(ALL),
                        'options' => $statusOptions,
                    ]
                );
            } ?>
        </div>
        <div class="col-sm-3">
            <label for="group-id">&nbsp</label>
            <div class="input select block">
                <?php echo $this->Form->button(
                    '<i class="fa fa-search"></i> ' . __(SEARCH), [
                        'type'   => 'submit',
                        'class'  => 'btn btn-primary m-b',
                        'escape' => false,
                    ]
                );
                ?>
                <?php echo $this->Html->link(
                    '<i class="fa fa-refresh"></i>', [
                    'action' => 'index',
                ], [
                        'class'       => 'btn btn-white m-b m-l-sm',
                        'escapeTitle' => false,
                    ]
                );
                ?>
            </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>