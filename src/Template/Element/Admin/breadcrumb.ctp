<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo $title; ?></h2>
        <ol class="breadcrumb">
            <li>
                <?php echo $this->Html->link(
                    'Dashboard',
                    ['controller' => 'Dashboards', 'action' => 'summary'],
                    ['fullBase' => true]
                ); ?>
            </li>
            <?php if (isset($subTitle)) {
                echo '<li>' . $title . '</li>';
            } ?>
            <li class="active">
                <strong><?php echo isset($subTitle) ? $subTitle
                        : $title; ?> </strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <?php if (isset($print)) {
            $link = $this->Html->link('<i class="fa fa-print"></i>'
                . __('Print'),
                $print,
                ['escape' => false, 'class' => 'btn btn-primary',]);
            echo "<div class=\"title-action\">{$link}</div>";
        } ?>
    </div>
</div>