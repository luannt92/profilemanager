<?php echo $this->element('Admin/breadcrumb', [
    'title' => __(MENU_MANAGEMENT),
]);
?>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="ibox-content m-b-sm border-bottom">
        <?php echo $this->Form->create(null, [
            'type' => 'get',
            'url'  => ['controller' => 'Menus', 'action' => 'index'],
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
                ); ?>
            </div>
            <div class="col-sm-2">
                <?php echo $this->Form->control('status', [
                        'class'   => 'form-control',
                        'value'   => isset($search['status'])
                            ? $search['status'] : '',
                        'empty'   => true,
                        'options' => [
                            ENABLED  => 'Enabled',
                            DISABLED => 'Disabled',
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-2">
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
                        'controller' => 'Menus',
                        'action'     => 'index',
                    ], [
                            'class'       => 'btn btn-white m-b pull-right',
                            'escapeTitle' => false,
                        ]
                    );
                    ?>
                </div>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox toggleSpinners">
                <div class="ibox-content">
                    <table class="footable table table-stripped toggle-arrow-tiny">
                        <thead>
                        <tr>
                            <th data-hide="all"><?php echo $this->Paginator->sort('id') ?></th>
                            <th data-toggle="true"><?php echo $this->Paginator->sort('name') ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('type') ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('status') ?></th>
                            <th data-hide="all"><?php echo $this->Paginator->sort('created_at') ?></th>
                            <th data-sort-ignore="true" class="actions text-right">
                                <?php echo __('Actions') ?>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $item):
                            $statusName = '';
                            $statusClass = '';
                            if ( ! empty($status[$item->status])) {
                                $statusName
                                    = $status[$item->status]['name'];
                                $statusClass
                                    = $status[$item->status]['class'];
                            }
                            $typeName = '';
                            if ( ! empty($typeMenu[$item->type])) {
                                $typeName = $typeMenu[$item->type];
                            }
                            ?>
                            <tr>
                                <td><?php echo $this->Number->format($item->id) ?></td>
                                <td><?php echo h($item->name) ?></td>
                                <td><?php echo $typeName; ?></td>
                                <td>
                                    <span class="label <?php echo $statusClass; ?>"><?php echo $statusName; ?></span>
                                </td>
                                <td><?php echo h(date('d/m/Y h:i:s',
                                        strtotime($item->created_at))) ?></td>
                                <td class="text-right footable-visible footable-last-column tooltip-demo">
                                    <div class="btn-group">
                                        <?php echo $this->Html->link('<i class="fa fa-edit"></i>',
                                            ['action' => 'edit', $item->id],
                                            [
                                                'class'          => 'btn-white btn btn-xs',
                                                'escape'         => false,
                                                'data-toggle'    => "tooltip",
                                                'data-placement' => "top",
                                                'title'          => __(EDIT_TEXT),
                                            ]) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5" class="footable-visible">
                                <?php
                                echo $this->element('Admin/paginator'); ?>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>