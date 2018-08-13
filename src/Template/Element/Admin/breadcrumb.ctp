<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo $title; ?></h2>
        <ol class="breadcrumb">
            <li>
                <?php echo $this->Html->link(
                    'Dashboard', ['controller' => 'Users', 'dashboard'],
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
    </div>
</div>