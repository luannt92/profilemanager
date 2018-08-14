<?php if($this->Paginator->total() > 1 ): ?>
<div class="paginator pull-right">
    <ul class="pagination">
        <?php echo $this->Paginator->first('<< ') ?>
        <?php echo $this->Paginator->prev('< ') ?>
        <?php echo $this->Paginator->numbers() ?>
        <?php echo $this->Paginator->next(' >') ?>
        <?php echo $this->Paginator->last(' >>') ?>
    </ul>
</div>
<?php endif;