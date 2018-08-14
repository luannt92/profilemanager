<?php echo $this->element('Admin/breadcrumb', [
    'title' => __(MENU_MANAGEMENT),
]);
?>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <?php echo $this->element('Admin/boxSearch'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox toggleSpinners">
                <div class="ibox-content">
                    <?php
                    echo $this->Html->link(
                        '<i class="fa fa-plus"></i> ' . __(ADD_NEW),
                        ['action' => 'add'],
                        [
                            'class' => 'btn btn-primary btn-sm m-r-sm',
                            'escapeTitle' => false,
                        ]
                    );
                    ?>
                    <table class="footable table table-stripped toggle-arrow-tiny">
                        <thead>
                        <tr>
                            <th data-hide="all"><?php echo $this->Paginator->sort('id') ?></th>
                            <th data-toggle="true"><?php echo $this->Paginator->sort('name') ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('type') ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('status') ?></th>
                            <th data-hide="all"><?php echo $this->Paginator->sort('created_at') ?></th>
                            <th data-hide="all"><?php echo $this->Paginator->sort('updated_at') ?></th>
                            <th data-sort-ignore="true"
                                class="actions text-right">
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
                                <td><?php echo h($item->created_at) ?></td>
                                <td><?php echo h($item->updated_at) ?></td>
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