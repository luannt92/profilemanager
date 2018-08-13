<?php echo $this->element('Admin/breadcrumb', [
    'title' => __(PAGE_MANAGEMENT),
]);
?>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="ibox-content m-b-sm border-bottom">
        <?php echo $this->Form->create(null, [
            'type' => 'get',
            'url'  => ['controller' => 'Pages', 'action' => 'index'],
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
                            ACTIVE   => 'Active',
                            DEACTIVE => 'Deactive',
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-2">
                <div class="input select">
                    <label for="group-id">&nbsp</label>
                    <?php echo $this->Form->button(
                        __(SEARCH), [
                            'type'  => 'submit',
                            'class' => 'btn btn-primary block m-b',
                        ]
                    );
                    ?>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input select">
                    <label for="group-id">&nbsp</label>
                    <?php echo $this->Html->link(
                        __(RESET), [
                        'controller' => 'Pages',
                        'action'     => 'index',
                    ], ['class' => 'btn btn-white block m-b',]
                    );
                    ?>
                </div>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <?php
                    echo $this->Html->link(
                        __(ADD_NEW),
                        ['action' => 'add'],
                        [
                            'class' => 'btn btn-primary m-b',
                        ]
                    );
                    ?>
                    <table class="footable table table-stripped toggle-arrow-tiny">
                        <thead>
                        <tr>
                            <th data-hide="all"><?php echo $this->Paginator->sort('id') ?></th>
                            <th data-toggle="true"><?php echo $this->Paginator->sort('title') ?></th>
                            <th data-hide="all"><?php echo $this->Paginator->sort('Users.name', 'Author') ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('slug') ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('type') ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('status') ?></th>
                            <th data-hide="all"><?php echo $this->Paginator->sort('created_at') ?></th>
                            <th data-hide="all"><?php echo $this->Paginator->sort('updated_at') ?></th>
                            <th data-sort-ignore="true"
                                class="actions text-right"><?php echo __('Actions') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $item):
                            $statusName = '';
                            $statusClass = '';
                            if ( ! empty($status[$item->status])) {
                                $statusName  = $status[$item->status]['name'];
                                $statusClass = $status[$item->status]['class'];
                            } ?>
                            <tr>
                                <td><?php echo $this->Number->format($item->id) ?></td>
                                <td><?php echo h($item->title) ?></td>
                                <td><?php echo $item->has('user')
                                        ? $this->Html->link($item->user->name,
                                            [
                                                'controller' => 'Users',
                                                'action'     => 'view',
                                                $item->user->id,
                                            ]) : ''
                                    ?></td>
                                <td><?php echo h($item->slug) ?></td>
                                <td><?php echo !empty($types[$item->type]) ? $types[$item->type] : '' ?></td>
                                <td>
                                    <span class="label <?php echo $statusClass; ?>"><?php echo $statusName; ?></span>
                                </td>
                                <td><?php echo h($item->created_at) ?></td>
                                <td><?php echo h($item->updated_at) ?></td>
                                <td class="text-right footable-visible footable-last-column tooltip-demo">
                                    <div class="btn-group">
                                        <?php echo $this->Html->link('<i class="fa fa-eye"></i>',
                                            ['action' => 'view', $item->id],
                                            [
                                                'class'          => 'btn-white btn btn-xs',
                                                'escape'         => false,
                                                'data-toggle'    => "tooltip",
                                                'data-placement' => "top",
                                                'title'          => __(VIEW_TEXT),
                                            ]
                                        ); ?>
                                        <?php echo $this->Html->link('<i class="fa fa-edit"></i>',
                                            ['action' => 'edit', $item->id],
                                            [
                                                'class'          => 'btn-white btn btn-xs',
                                                'escape'         => false,
                                                'data-toggle'    => "tooltip",
                                                'data-placement' => "top",
                                                'title'          => __(EDIT_TEXT),
                                            ]) ?>
                                        <?php echo $this->Form->postLink('<i class="fa fa-times"></i>',
                                            ['action' => 'delete', $item->id],
                                            [
                                                'confirm'        => __(USER_MSG_0011,
                                                    $item->title),
                                                'class'          => 'btn-white btn btn-xs',
                                                'escape'         => false,
                                                'data-toggle'    => "tooltip",
                                                'data-placement' => "top",
                                                'title'          => __(DELETE_TEXT),
                                            ]); ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5" class="footable-visible">
                                <?php echo $this->element('Admin/paginator'); ?>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
