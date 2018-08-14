<?php
$htmlMenus    = "";
$name         = empty($user->full_name) ? "" : $user->full_name;
$avatar       = empty($user->avatar) ? NO_IMAGE : $user->avatar;
$avatar       = $this->Html->image($avatar);
$activeAction = [
    'controller' => $this->request->getParam('controller'),
    'action'     => $this->request->getParam('action'),
];
$arrMenus     = [
    [
        "name" => __("Account management"),
        "url"  => ["controller" => "Users", "action" => "account"],
    ],
    [
        "name" => __("Order list"),
        "url"  => ["controller" => "Orders", "action" => "index"],
    ],
    [
        "name" => __("Change the password"),
        "url"  => ["controller" => "Users", "action" => "changePassword"],
    ],
    [
        "name" => __("Logout"),
        "url"  => ["controller" => "Users", "action" => "logout"],
    ],
];

foreach ($arrMenus as $menu) {
    $active    = $activeAction === $menu["url"] ? "active" : "";
    $link      = $this->Html->link($menu["name"], $menu["url"]);
    $htmlMenus .= "<li class=\"{$active}\">{$link}</li>";
}
?>
<div class="col-xs-12 col-md-3">
    <div class="text-header">
        <p><?php echo __("Hello !"); ?>
            <span><?php echo $name; ?></span></p>
    </div>
    <div class="menu-info-account">
        <div class="img-account">
            <?php echo $avatar; ?>
        </div>
        <ul class="category-list menu-account">
            <?php echo $htmlMenus; ?>
        </ul>
    </div>
</div>