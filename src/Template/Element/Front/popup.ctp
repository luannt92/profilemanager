<?php
$content = empty($link)
    ? $this->Html->image($banner)
    : $this->Html->link($this->Html->image($banner), $link,
        ['class' => 'tracking-popup', 'escape' => false]);
?>
    <div class="modal fade myshowload" id="modalshowLoad" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>
<?php echo $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
    $(document).ready(function ($) {
    $('#modalshowLoad').modal('show');

    $('#modalshowLoad').on('shown.bs.modal', function(){
    var modal  = $(this);
    var link = modal.find('.tracking-popup');
    if(link.length == 1) {
    $(link).on('click', function(e){<?php echo $tracking; ?>});
    }
    });
    });
<?php echo $this->Html->scriptEnd();