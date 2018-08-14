<?php
$htmlAddress  = "";
$linkEditU    = $this->Html->link(__('Edit'), [
    'controller' => 'Users',
    'action'     => 'edit',
]);
$htmlUser     = implode('<br/>', [
    __('Name: ') . $user->full_name,
    'Email: ' . $user->email,
    __('Phone: ') . $user->phone_code . $user->phone_number,
]);
$arrayInfoAdd = [
    [
        'title'        => __('Shipping address'),
        'address'      => $addressRec,
        'hotel'        => $hotel,
        'prefix'       => RECIPIENT_ADDRESS,
    ],
];
$htmlAddress
              .= "<div class=\"col-xs-12 col-md-6 col-sm-6\"><div class=\"account-info\">
                <div class=\"row\"><div class=\"col-xs-7 col-sm-7\"><div class=\"account-info-text-header\">
                %title%</div></div><div class=\"col-xs-5 col-sm-5\">
                %link%</div></div><div class=\"row\"><div class=\"col-xs-12 col-sm-12\">
                <div class=\"account-info-text-content\">%htmlAdd%</div>
                 </div></div></div></div>";
$htmlAddress  = $this->Utility->generateAddress($arrayInfoAdd, $htmlAddress,
    false, [
        'link' => [
            'url'   => ['controller' => 'Addresses'],
            'title' => __('Edit'),
        ],
    ]);
?>
<div class="content" id="content">
    <div class="container">
        <div class="row content-account">
            <?php echo $this->element('Front/Users/menuAccount'); ?>
            <div class="col-xs-12 col-md-9">
                <div class="row address_order">
                    <div class="col-xs-12 col-sm-12">
                        <div class="text-header-content">
                            <p><?php echo __("User information"); ?></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <div class="row">
                            <div class="col-xs-12 col-md-6 col-sm-6">
                                <div class="account-info">
                                    <div class="row">
                                        <div class="col-xs-7 col-sm-7">
                                            <div class="account-info-text-header">
                                                <?php echo __('Personal information') ?>
                                            </div>
                                        </div>
                                        <div class="col-xs-5 col-sm-5">
                                            <?php echo $linkEditU; ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12">
                                            <div class="account-info-text-content">
                                                <?php echo $htmlUser; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo $htmlAddress; ?>
                        </div>
                    </div>
                </div>
                <?php echo $this->element('Front/Order/table',
                    ['title' => __('Recent orders')]); ?>
            </div>
        </div>
        <!-- main-content -->
    </div>
</div>
