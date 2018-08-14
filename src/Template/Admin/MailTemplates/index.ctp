<?php echo $this->element('Admin/breadcrumb', [
    'title'    => __(MAIL_TEMPLATE_MANAGEMENT),
]);
$content = null;
?>
<div class="fh-breadcrumb">

    <div class="fh-column">
        <div class="full-height-scroll">
            <ul class="list-group elements-list">
                <?php foreach($mailTemplates as $key => $template) {
                    $active = ($key === 0) ? 'active' : null;
                    $updated = h($template->updated_at);
                    $urlEdit = $this->Html->link(
                        '<i class="fa fa-edit"></i>', ['action' => 'edit', $template->id], [
                            'class' => 'btn btn-white btn-xs',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'left',
                            'title' => 'Edit this template',
                            'escapeTitle' => false
                        ]
                    );
                    $url = $this->Url->build(['action' => 'view', $template->id]);
                    $content .= "
                    <div id=\"tab-{$template->id}\" class=\"tab-pane {$active}\">
                        <div class=\"pull-right\">
                            <div class=\"tooltip-demo\">{$urlEdit}</div>
                        </div>
                        <div class=\"small text-muted\">
                            <i class=\"fa fa-clock-o\"></i> {$updated}
                        </div>
                        <h2>{$template->subject}</h2>
                        <iframe style='width: 100%;height: 400px;border: none;' src=\"{$url}\" ></iframe>
                    </div>";
                    ?>
                <li class="list-group-item <?php echo $active; ?>">
                    <a data-toggle="tab" href="#tab-<?php echo $template->id; ?>">
                        <small class="pull-right text-muted"><?php echo h($template->created_at); ?></small>
                        <strong>Code: <?php echo $template->code; ?></strong>
                        <div class="small m-t-xs">
                            <p>
                                <?php echo $template->subject; ?>
                            </p>
                            <p class="m-b-none">
                                <i class="fa fa-clock-o"></i> Updated: <?php echo $updated; ?>
                            </p>
                        </div>
                    </a>
                </li>
                <?php } ?>
            </ul>

        </div>
    </div>

    <div class="full-height">
        <div class="full-height-scroll white-bg border-left">
            <div class="element-detail-box">
                <div class="tab-content">
                    <?php echo $content; ?>
                </div>
            </div>

        </div>
    </div>
</div>