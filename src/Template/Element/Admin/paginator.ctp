<div class="paginator pull-right">
    <ul class="pagination">
        <?php echo $this->Paginator->first('<< ') ?>
        <?php echo $this->Paginator->prev('< ') ?>
        <?php echo $this->Paginator->numbers() ?>
        <?php echo $this->Paginator->next(' >') ?>
        <?php echo $this->Paginator->last(' >>') ?>
    </ul>
</div>
<div class="paginator pull-left">
    <ul class="pagination">
        <li><?php echo $this->Paginator->counter([
                'format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total'),
            ]) ?></li>
    </ul>
</div>