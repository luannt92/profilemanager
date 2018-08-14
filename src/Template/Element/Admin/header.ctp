<?php
$logoutLink = $this->Html->link(
    '<i class="fa fa-sign-out"></i> Log out',
    ['controller' => 'Users', 'action' => 'logout'],
    ['escapeTitle' => false]
);
$homepage   = $this->Html->link(
    '<i class="fa fa-home"></i> Homepage',
    '/',
    ['target' => '_blank', 'escapeTitle' => false]
);
?>
<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation"
         style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary "
               href="#"><i class="fa fa-bars"></i> </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">
                    <?php echo $homepage; ?>
                </span>
            </li>
            <li>
                <?php echo $logoutLink; ?>
            </li>
        </ul>
    </nav>
</div>