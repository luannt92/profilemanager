<?php
$disable = $this->request->action === 'view' ? true : false;

echo $this->Form->control('meta_title', [
        'class'       => 'form-control',
        'type'        => 'text',
        'disabled'    => $disable,
        'placeholder' => __(META_TITLE),
        'label'       => __(META_TITLE),
    ]
);
echo $this->Form->control('meta_keyword', [
        'class'       => 'form-control',
        'type'        => 'text',
        'disabled'    => $disable,
        'placeholder' => __(META_KEYWORD),
        'label'       => __(META_KEYWORD),
    ]
);
echo $this->Form->control('meta_description',
    [
        'class'       => 'form-control',
        'type'        => 'textarea',
        'disabled'    => $disable,
        'placeholder' => __(META_DESCRIPTION),
        'label'       => __(META_DESCRIPTION),
    ]
);
