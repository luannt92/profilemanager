<?php echo $this->element('Admin/breadcrumb', [
    'title' => __(USERS_MANAGEMENT),
]);
?>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="ibox-content m-b-sm border-bottom">
        <?php echo $this->Form->create(null, [
            'type' => 'get',
            'url'  => ['controller' => 'Users', 'action' => 'index'],
        ]); ?>
        <div class="row">
            <div class="col-sm-2">
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
                <?php echo $this->Form->control('user_group_id', [
                        'class'   => 'form-control',
                        'options' => $groups,
                        'empty'   => true,
                        'value'   => isset($search['user_group_id'])
                            ? $search['user_group_id'] : '',
                    ]
                ); ?>
            </div>
            <div class="col-sm-3">
                <label for="group-id">Created</label>
                <div class="input-daterange input-group" id="datepicker">
                    <?php echo $this->Form->control('start_date', [
                        'class'   => 'form-control datetimepicker6',
                        'label' => false,
                        'readOnly' => true,
                        'empty'   => true,
                        'value'   => isset($search['start_date']) ? $search['start_date'] : '',
                    ]
                    ); ?>
                    <span class="input-group-addon">-</span>
                    <?php echo $this->Form->control('end_date', [
                            'class'   => 'form-control datetimepicker7',
                            'label' => false,
                            'readOnly' => true,
                            'empty'   => true,
                            'value'   => isset($search['end_date']) ? $search['end_date'] : '',
                        ]
                    ); ?>
                </div>
            </div>
            <div class="col-sm-2">
                <?php echo $this->Form->control('status', [
                        'class'   => 'form-control',
                        'value'   => isset($search['status'])
                            ? $search['status'] : '',
                        'empty'   => true,
                        'options' => [
                            ENABLED   => 'Enabled',
                            DISABLED => 'Disabled',
                            TRASH   => 'Trash',
                            REGISTER_STATUS => 'Register',
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-3">
                <label for="group-id">&nbsp</label>
                <div class="input select block">
                    <?php echo $this->Form->button(
                        '<i class="fa fa-search"></i> ' . __(SEARCH), [
                            'type'  => 'submit',
                            'class' => 'btn btn-primary m-b',
                            'escape' => false
                        ]
                    );
                    ?>
                    <?php echo $this->Html->link(
                        '<i class="fa fa-refresh"></i>', [
                        'controller' => 'Users',
                        'action'     => 'index',
                    ], ['class' => 'btn btn-white m-b m-l-sm', 'escapeTitle' => false]
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
                    <?php echo $this->element('Admin/selectedAll', compact('search')); ?>
                    <table class="footable table table-stripped toggle-arrow-tiny">
                        <thead>
                        <tr>
                            <th data-sort-ignore="true"><input type="checkbox" name="select_all" id="select_all" value=""/></th>
                            <th data-hide="all"><?php echo $this->Paginator->sort('id') ?></th>
                            <th data-toggle="true"><?php echo $this->Paginator->sort('email') ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('name') ?></th>
                            <th data-hide="all"><?php echo $this->Paginator->sort('gender') ?></th>
                            <th data-hide="all"><?php echo $this->Paginator->sort('birthday') ?></th>
                            <th data-hide="all"><?php echo $this->Paginator->sort('group_id') ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('status') ?></th>
                            <th data-hide="all"><?php echo $this->Paginator->sort('created_at') ?></th>
                            <th data-sort-ignore="true"
                                class="actions text-right"><?php echo __('Actions') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user):
                            $statusName = '';
                            $statusClass = '';
                            if ( ! empty($status[$user->status])) {
                                $statusName  = $status[$user->status]['name'];
                                $statusClass = $status[$user->status]['class'];
                            } ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="checked_id[]"
                                           class="checkbox"
                                           value="<?php echo $user->id; ?>"/>
                                </td>
                                <td><?php echo $this->Number->format($user->id) ?></td>
                                <td><?php echo h($user->email) ?></td>
                                <td><?php echo h($user->name) ?></td>
                                <td><?php echo ! empty($genders[$user->gender])
                                        ? $genders[$user->gender]
                                        : '' ?></td>
                                <td><?php echo h($user->birthday) ?></td>
                                <td><?php echo h($user->user_group->name) ?></td>
                                <td>
                                    <span class="label <?php echo $statusClass; ?>"><?php echo $statusName; ?></span>
                                </td>
                                <td><?php echo h($user->created_at) ?></td>
                                <td class="text-right footable-visible footable-last-column tooltip-demo">
                                    <div class="btn-group">
                                        <?php echo $this->Html->link('<i class="fa fa-eye"></i>',
                                            ['action' => 'view', $user->id],
                                            [
                                                'class'          => 'btn-white btn btn-xs',
                                                'escape'         => false,
                                                'data-toggle'    => "tooltip",
                                                'data-placement' => "top",
                                                'title'          => __(VIEW_TEXT),
                                            ]
                                        ); ?>
                                        <?php echo $this->Html->link('<i class="fa fa-edit"></i>',
                                            ['action' => 'edit', $user->id],
                                            [
                                                'class'          => 'btn-white btn btn-xs',
                                                'escape'         => false,
                                                'data-toggle'    => "tooltip",
                                                'data-placement' => "top",
                                                'title'          => __(EDIT_TEXT),
                                            ]) ?>
                                        <?php echo $this->Form->postLink('<i class="fa fa-times"></i>',
                                            ['action' => 'delete', $user->id],
                                            [
                                                'confirm'        => __(USER_MSG_0011,
                                                    $user->name),
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
<?php echo $this->Html->scriptStart(['block' => true]); ?>
    $(document).ready(function () {
        $(function () {
            $('.datetimepicker6').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true
            });
            $('.datetimepicker7').datepicker({
                useCurrent: false,
                format: "yyyy-mm-dd",
                autoclose: true
            });
            $(".datetimepicker6").on("dp.change", function (e) {
                $('.datetimepicker7').data("DateTimePicker").minDate(e.date);
            });
            $(".datetimepicker7").on("dp.change", function (e) {
                $('.datetimepicker6').data("DateTimePicker").maxDate(e.date);
            });
        });
    });
<?php echo $this->Html->scriptEnd(); ?>