<?php
$disable = $this->request->action === 'view' ? true : false;

echo $this->Form->control('_translations.' . $key . '.meta_title',
    [
        'class'       => 'form-control',
        'disabled'    => $disable,
        'required'    => false,
        'type'        => 'text',
        'label'       => __(META_TITLE),
        'placeholder' => __(META_TITLE),
    ]
);
echo $this->Form->control('_translations.' . $key . '.meta_keyword',
    [
        'class'       => 'form-control',
        'disabled'    => $disable,
        'required'    => false,
        'type'        => 'text',
        'label'       => __(META_KEYWORD),
        'placeholder' => __(META_KEYWORD),
    ]
);
echo $this->Form->control('_translations.' . $key . '.meta_description',
    [
        'class'       => 'form-control',
        'type'        => 'textarea',
        'required'    => false,
        'disabled'    => $disable,
        'placeholder' => __(META_DESCRIPTION),
        'label'       => __(META_DESCRIPTION),
    ]
);
