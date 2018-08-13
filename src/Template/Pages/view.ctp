<?php
$title = $page->title;
?>
<div id="content" class="wrapper">
    <?php echo $this->element('Front/breadcrumb',compact('title')); ?>
    <div class="wrapper">
        <div class="title"><h3 class="title"><?php echo $title ?></h3></div>
        <?php echo !empty($page->content) ? $page->content : ''; ?>
    </div>
</div>
