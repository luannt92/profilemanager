<div class="sk-spinner sk-spinner-wave">
    <div class="sk-rect1"></div>
    <div class="sk-rect2"></div>
    <div class="sk-rect3"></div>
    <div class="sk-rect4"></div>
    <div class="sk-rect5"></div>
</div>
<?php
echo $this->Form->create(null,
    [
        'url'      => ['action' => 'deleteSelected'],
        'id'      => 'frmActionExecute',
    ]);
echo $this->Form->control(
    'selectedAll', [
        'type'  => 'hidden',
        'label' => false,
    ]
);
echo $this->Form->control(
    'statusExc', [
        'type'  => 'hidden',
        'id'  => 'statusExc',
    ]
);

$titleDelete = __(DELETE_SELECTED);
$titleEnable = __(ENABLE_TEXT);

if ((isset($search['status']) && $search['status'] == TRASH )) {
    $titleDelete = __(DELETE_TEXT);
    $titleEnable = __(RESTORE_TEXT);
}
?>
    <div class="input-group-btn pull-left" style="width: 80px;">
        <button data-toggle="dropdown" class="btn btn-sm btn-white dropdown-toggle" type="button" aria-expanded="false">Action <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <li><a href="#" class="actionExc" data-status="<?php echo ENABLED; ?>"><?php echo $titleEnable; ?></a></li>
            <?php if (isset($search['status']) && $search['status'] == TRASH) {
            }else {?>
                <li><a href="#" class="actionExc" data-status="<?php echo DISABLED; ?>">Disable</a></li>
            <?php } ?>
            <li class="divider"></li>
            <li><a href="#" class="actionExc" data-status="<?php echo TRASH; ?>"><?php echo $titleDelete; ?></a></li>
        </ul>
    </div>
<?php
$addAction = isset($action) ? $action . 'Add' : 'add';
if (!isset($doNotDisplayButtonAdd)) {
    echo $this->Html->link(
        '<i class="fa fa-plus"></i> ' . __(ADD_NEW),
        ['action' => $addAction],
        [
            'class' => 'btn btn-primary btn-sm m-r-sm',
            'escapeTitle' => false,
        ]
    );
}

if (isset($updateAll)) {
    echo $this->Html->link(
        '<i class="fa fa-magic"></i> ' . __(UPDATE_ALL),
        ['action' => 'updateAll'],
        [
            'class' => 'btn btn-success btn-sm m-r-sm',
            'escapeTitle' => false,
        ]
    );
}

if (isset($addMultiple)) {
    echo $this->Html->link(
        '<i class="fa fa-magic"></i> ' . __(ADD_MULTIPLE),
        ['action' => 'addMultiple'],
        [
            'class' => 'btn btn-success btn-sm m-r-sm',
            'escapeTitle' => false,
        ]
    );
}

echo $this->Form->end();
?>
<?php echo $this->Html->scriptStart(['block' => true]); ?>
    $(document).ready(function () {
        $('#select_all').on('click', function () {
            if (this.checked) {
                $('.checkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $('.checkbox').each(function () {
                    this.checked = false;
                });
            }
            var favorite = [];
            $.each($(".checkbox:checked"), function () {
                favorite.push($(this).val());
            });
            var output = document.getElementById('selectedall');
            output.value = favorite;
        });

        $('.checkbox').on('click', function () {
            if ($('.checkbox:checked').length == $('.checkbox').length) {
                $('#select_all').prop('checked', true);
            } else {
                $('#select_all').prop('checked', false);
            }

            var favorite = [];
            $.each($(".checkbox:checked"), function () {
                favorite.push($(this).val());
            });
            var output = document.getElementById('selectedall');
            output.value = favorite;
        });

        $('.actionExc').on('click', function(e){
            e.preventDefault();
            $('#statusExc').val($(this).attr('data-status'));
            $('.toggleSpinners').children('.ibox-content').toggleClass('sk-loading');
            $('#frmActionExecute').submit();
        })
});
<?php echo $this->Html->scriptEnd(); ?>