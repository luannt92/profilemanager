<?php
$htmlTag = $htmlCate = "";
if ( ! empty($new->new_category)) {
    $htmlCate = "<div class=\"new-cate\"><div class=\"new-cate-title\">"
        . __('Category :')
        . "</div><div class=\"cate-title\">{$new->new_category->name}</div></div>";
}
if ( ! empty($new->tags)) {
    $htmlTag .= "<div class=\"new-tag\"><div class=\"tag-title\">"
        . __('Tags :') . "</div><ul class=\"list-inline\">";
    foreach ($new->tags as $tag) {
        $htmlTag .= "<li class=\"\">{$tag->name}</li>";
    }
    $htmlTag .= "</ul></div>";
}
?>
<div class="content">
    <div class="blockmenu-content-1">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="block-title text-center"><?php echo $new->title; ?></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- blockmenu-content -->
    <div class="block-content p-d-t">
        <div class="container">
            <div class="news-content-wrapper">
                <?php echo $htmlCate ?>
                <div class="new-content">
                    <?php echo $new->content; ?>
                </div>
                <?php echo $htmlTag; ?>
            </div>
        </div>
    </div>
    <!-- block-content -->
</div>