<?php
$nameData = '';
foreach ($languages as $keyL => $nameL){
    $nameData .= 'data-'.$keyL. ' ';
}

echo $this->element(
    'Admin/breadcrumb', [
        'title' => __(MENU_MANAGEMENT),
    ]
);
$htmlCategory = null;
$prefix       = $menuCheckType === MENU ? 'Menu' : '';

$categoryElement = [];
if ( ! empty($categories)) {
    foreach ($categories as $item) {
        $categoryElement[$item['id']] = [
            'name' => $item['name'],
            'url'  => $item['slug'],
            'vi'   => $item['name'],
        ];

        $htmlCategory
            .= "<li><input type=\"checkbox\" value=\"{$item['id']}\" name=\"element_category\" class=\"i-checks\"/>
            <span class=\"m-l-xs\">{$item['name']}</span></li>";
    }
}

$htmlNewsCategory    = null;
$newCategoryElement = [];
if ( ! empty($newCategories)) {
    foreach ($newCategories as $item) {
        $newCategoryElement[$item['id']] = [
            'name' => $item['name'],
            'url'  => $item['slug'],
            'vi'   => $item['name'],
        ];

        $htmlNewsCategory
            .= "<li><input type=\"checkbox\" value=\"{$item['id']}\" name=\"element_new_category\" class=\"i-checks\"/>
            <span class=\"m-l-xs\">{$item['name']}</span></li>";
    }
}

$htmlPage    = null;
$pageElement = [];
if ( ! empty($pages)) {
    foreach ($pages as $item) {
        $pageElement[$item['id']] = [
            'name' => $item['title'],
            'url'  => $item['slug'],
            'vi'   => $item['title'],
        ];

        $htmlPage
            .= "<li><input type=\"checkbox\" value=\"{$item['id']}\" name=\"element_page\" class=\"i-checks\"/>
            <span class=\"m-l-xs\">{$item['title']}</span></li>";
    }
}

$htmlTag    = null;
$tagElement = [];
if ( ! empty($tags)) {
    foreach ($tags as $item) {
        $tagElement[$item['id']] = [
            'name' => $item['name'],
            'url'  => $item['slug'],
            'vi'   => $item['name'],
        ];

        $htmlTag
            .= "<li><input type=\"checkbox\" value=\"{$item['id']}\" name=\"element_tag_00{$item['id']}\" class=\"i-checks\"/>
            <span class=\"m-l-xs\">{$item['name']}</span></li>";
    }
}

$htmlMenu = "<ol class=\"dd-list\">";
if ( ! empty($menuTab)) {
    foreach ($menuTab as $menu) {
        $nameDataT = '';
        if ( ! empty($menu['_i18n'])) {
            foreach ($menu['_i18n'] as $tranMenu) {
                $nameInfo = ! empty($tranMenu['content']) ? ' = "'
                    . $tranMenu['content'] . '"' : '';
                $nameDataT .= 'data-' . $tranMenu['locale'] . '' . $nameInfo
                    . ' ';
            }
        }

        $check    = $menu['obj_id'] . '-' . $menu['position'] . '-' . $menu['type'];
        $htmlMenu .= "<li class=\"dd-item\" data-check=\"{$check}\" data-id=\"{$menu['obj_id']}\" data-name=\"{$menu['name']}\" " . $nameDataT . " data-url=\"{$menu['url']}\" data-type=\"{$menu['type']}\">";
        $name     = $menu['name'];
        $data     = json_encode($menu);
        $id       = $menu['obj_id'];
        $htmlMenu .= $this->element('Admin/Menu/nestedList',
            compact('name', 'id', 'data', 'check'));
        if ( ! empty($menu['children'])) {
            $htmlMenu .= "<ol class=\"dd-list\">";
            foreach ($menu['children'] as $child) {
                $nameDataC = '';
                if ( ! empty($child['_i18n'])) {
                    foreach ($child['_i18n'] as $tranMenuC) {
                        $nameInfoC = ! empty($tranMenuC['content']) ? ' = "'
                            . $tranMenuC['content'] . '"' : '';
                        $nameDataC .= 'data-' . $tranMenuC['locale'] . '' . $nameInfoC
                            . ' ';
                    }
                }
                $check    = $child['obj_id'] . '-' . $child['position'] . '-' . $child['type'];
                $name     = $child['name'];
                $id       = $child['obj_id'];
                $isHeader = $menuCheck->type == MENU_HEADER ? 1 : 0;
                $icon     = ! empty($child['icon']) ? $child['icon'] : "";
                $htmlMenu .= "<li class=\"dd-item\" data-check=\"{$check}\" data-id=\"{$child['obj_id']}\" data-name=\"{$child['name']}\" " .$nameDataC . " data-url=\"{$child['url']}\" data-type=\"{$child['type']}\" data-icon=\"{$icon}\">";
                $htmlMenu .= $this->element('Admin/Menu/nestedList',
                    compact('name', 'id', 'check', 'isHeader'));
                $htmlMenu .= "</li>";
            }
            $htmlMenu .= "</ol>";
        }
    }
}
$htmlMenu .= "</ol>";
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="tabs-container">
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="wrapper wrapper-content">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="panel-group float-e-margins"
                                     id="accordion">
                                    <div class="panel panel-default">
                                        <div class="ibox-title">
                                            <h5><a data-toggle="collapse"
                                                   data-parent="#accordion"
                                                   href="#collapseOneT">News
                                                    Categories</a>
                                            </h5>
                                        </div>

                                        <div id="collapseOneT"
                                             class="ibox-content panel-collapse collapse in">
                                            <div class="scroll_content">
                                                <ul class="todo-list small-list todo-list-new-category">
                                                    <?php echo $htmlNewsCategory; ?>
                                                </ul>
                                            </div>
                                            <div style="height: 40px;">
                                                <button style="float: right"
                                                        id="menu-add-news-category"
                                                        class="btn btn-info m-t-sm"
                                                        type="button">Thêm vào
                                                    menu
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="ibox-title">
                                            <h5><a data-toggle="collapse"
                                                   data-parent="#accordion"
                                                   href="#collapseOne">Categories</a>
                                            </h5>
                                        </div>

                                        <div id="collapseOne"
                                             class="ibox-content panel-collapse collapse">
                                            <div class="scroll_content">
                                                <ul class="todo-list small-list todo-list-category">
                                                    <?php echo $htmlCategory; ?>
                                                </ul>
                                            </div>
                                            <div style="height: 40px;">
                                                <button style="float: right"
                                                        id="menu-add-category"
                                                        class="btn btn-info m-t-sm"
                                                        type="button">Thêm vào
                                                    menu
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="ibox-title">
                                            <h5><a data-toggle="collapse"
                                                   data-parent="#accordion"
                                                   href="#collapsePage">Pages</a>
                                            </h5>
                                        </div>

                                        <div id="collapsePage"
                                             class="ibox-content panel-collapse collapse">
                                            <div class="scroll_content">
                                                <ul class="todo-list small-list todo-list-page">
                                                    <?php echo $htmlPage; ?>
                                                </ul>
                                            </div>
                                            <div style="height: 40px;">
                                                <button style="float: right"
                                                        id="menu-add-page"
                                                        class="btn btn-info m-t-sm"
                                                        type="button">Thêm vào
                                                    menu
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="ibox-title">
                                            <h5><a data-toggle="collapse"
                                                   data-parent="#accordion"
                                                   href="#collapseTwo">Tags</a>
                                            </h5>
                                        </div>

                                        <div id="collapseTwo"
                                             class="ibox-content panel-collapse collapse">
                                            <div class="scroll_content">
                                                <ul class="todo-list small-list todo-list-tag">
                                                    <?php echo $htmlTag; ?>
                                                </ul>
                                            </div>
                                            <div style="height: 40px;">
                                                <button style="float: right"
                                                        id="menu-add-tag"
                                                        class="btn btn-info m-t-sm"
                                                        type="button">Thêm vào
                                                    menu
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="ibox-title">
                                            <h5><a data-toggle="collapse"
                                                   data-parent="#accordion"
                                                   href="#collapseFive">Liên
                                                    kết
                                                    tùy chỉnh</a></h5>
                                        </div>

                                        <div id="collapseFive"
                                             class="ibox-content panel-collapse collapse">
                                            <div class="form-group">
                                                <label>URL:</label>
                                                <input id="urlText"
                                                       type="text"
                                                       placeholder="URL"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Tên:</label>
                                                <input id="nameText"
                                                       type="text"
                                                       placeholder="Tên"
                                                       class="form-control">
                                            </div>
                                            <div style="height: 40px;">
                                                <button style="float: right"
                                                        id="menu-add-link"
                                                        class="btn btn-info m-t-sm"
                                                        type="button">Thêm vào
                                                    menu
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Tên Menu: <?php echo $menuCheck->name; ?></h5>
                                    </div>
                                    <div class="ibox-content">

                                        <div class="dd" id="nestable2">
                                            <?php
                                            echo $htmlMenu;
                                            ?>
                                        </div>
                                        <?php echo $this->Form->create(null, [
                                            'url' => [
                                                'controller' => 'Menus',
                                                'action'     => 'edit',
                                                $menuId,
                                            ],
                                        ]);
                                        echo $this->Form->control(
                                            'menu', [
                                                'class' => 'form-control',
                                                'type'  => 'textarea',
                                                'rows'  => '15',
                                                'style' => 'display:none',
                                                'id'    => 'nestable2-output',
                                                'label' => false,
                                            ]
                                        );
                                        echo $this->Html->link(
                                            __(BACK), ['action' => 'index'], [
                                                'class' => 'btn btn-white m-b m-t pull-right',
                                            ]
                                        );
                                        echo $this->Form->control(
                                            __(SAVE_CHANGE), [
                                                'class' => 'btn m-t btn-primary m-b',
                                                'type'  => 'submit',
                                            ]
                                        );
                                        echo $this->Form->end(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->element('Admin/Menu/modal'); ?>

<?php
echo $this->Html->css(
    [
        'admin/nestable.css',
    ],
    ['block' => true]
);

echo $this->Html->script(
    [
        'admin/plugins/nestable/jquery.nestable.js',
        'admin/plugins/iCheck/icheck.min.js',
        'admin/jquery.fancybox.min.js',

    ], ['block' => 'scriptBottom']
);
$this->Html->scriptStart(['block' => true]);
?>
//<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        var tagsArr = <?php echo json_encode($tagElement); ?>;
        var categoriesArr = <?php echo json_encode($categoryElement); ?>;
        var newCategoriesArr = <?php echo json_encode($newCategoryElement); ?>;
        var pagesArr = <?php echo json_encode($pageElement); ?>;
        var nestableList = $("#nestable2 > .dd-list");
        var editButton = $("#editButton");
        var editInputName = $("#editInputName");
        var editInputIcon = $("#icon");
        var editInputUrl = $("#url");
        var menuEditor = $("#editModal");

        menuEditor.on('show.bs.modal', function (e) {
           var btn =  $(e.relatedTarget);
           var isHeader = btn.attr('data-header');
           if(isHeader == 1) {
               $('.form-input-icon').removeClass('hidden');
           }
        });
        menuEditor.on('hidden.bs.modal', function (e) {
            $('.form-input-icon').addClass('hidden');
        });

        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        $('#nestable2').nestable({
            group: 1,
            maxDepth: 2
        }).on('change', updateOutput);

        updateOutput($('#nestable2').data('output', $('#nestable2-output')));

        // load input value when click edit link
        $(document).on("click", '.edit_toggle', function (e) {
            e.preventDefault();
            var targetId = $(this).data('owner-id');
            var target = $('[data-check="' + targetId + '"]');
            editButton.data("owner-id", targetId);
            var type = $(this).parents('li.dd-item').attr('data-type');

            if (type != <?php echo TYPE_LINK; ?>) {
                $('.show_url').css('display', 'none');
                $('#url').attr('disabled', 'disabled');
            } else {
                $('.show_url').css('display', 'block');
                $('#url').attr('disabled', false);
            }
            var parentsL = $(this).parents('li.dd-item');
            var lang = '<?php echo json_encode($languages) ?>';
            var langAr = $.parseJSON(lang);
            $('.check-modal').remove();
            $.each(langAr, function (index, value) {
                var valueL = parentsL.data(index);
                $('<div class="form-group check-modal">' +
                    '<label for="title" class="col-lg-2 control-label">' + value + '</label>' +
                    '<div class="col-lg-10">' +
                    '<input type="text" id="' + index + 'EditName" name="' + index + '" value="'+valueL+'" class="form-control">' +
                    '</div>' +
                    '</div>').insertAfter('.modal-body .form-input-name');
            });
            var menu = {
                'id': target.data("id"),
                'name': $(this).parents('li.dd-item').attr('data-name'),
                'icon': $(this).parents('li.dd-item').attr('data-icon'),
                'url': $(this).parents('li.dd-item').attr('data-url'),
                'type': type
            };

            $.each(menu, function (key, value) {
                $('#editModal').find('input[type!=checkbox][name=' + key + ']').val(value);
                $('#editModal').find('select[name=' + key + ']').val(value);
            });
        });

        $(document).on("click", '.delete_toggle', function (e) {
            e.preventDefault();
            var targetId = $(this).data('owner-id');
            var target = $('[data-check="' + targetId + '"]');

            var result = confirm("Delete " + target.data('name') + " and all its subitems ?");
            if (!result) {
                return;
            }

            // Remove children (if any)
            target.find("li").each(function () {
                deleteFromMenuHelper($(this));
            });

            // Remove parent
            deleteFromMenuHelper(target);

            // update JSON
            updateOutput($('#nestable2').data('output', $('#nestable2-output')));
        });

        var deleteFromMenuHelper = function (target) {
            target.fadeOut(function () {
                target.remove();
                updateOutput($('#nestable2').data('output', $('#nestable2-output')));
            });
        };

        $('#editButton').click(function (e) {
            e.preventDefault();
            var targetId = $(this).data('owner-id');
            var target = $('[data-check="' + targetId + '"]');
            var newName = editInputName.val();
            var newIcon = editInputIcon.val();
            var newSlug = editInputUrl.val();

            target.data("name", newName);
            target.data("icon", newIcon);
            target.data("url", newSlug);

            var lang = '<?php echo json_encode($languages) ?>';
            var langAr = $.parseJSON(lang);
            $.each(langAr, function (index, value) {
                target.data(index, $("#" + index + "EditName").val());
                target.attr("data-" + index + "", $("#" + index + "EditName").val());
            });

            target.attr("data-name", newName);
            target.attr("data-icon", newIcon);
            target.attr("data-url", newSlug);
            target.find("> .nested-list-content .content").html(newName);

            menuEditor.modal('hide');

            // update JSON
            updateOutput($('#nestable2').data('output', $('#nestable2-output')));
        });

        var newIdCount = 1;
        $("#menu-add-link").click(function (e) {
            e.preventDefault();
            var newId = new Date().getTime();
            var newUrl = $('#urlText').val();
            var newName = $('#nameText').val();
            var type = <?php echo TYPE_LINK; ?>;
            if (newUrl == '' || newName == '') {
                alert('Vui lòng nhập dữ liệu');
            } else {
                addToMenu(newId, newName, newUrl, type);
                $('#urlText').val('');
                $('#nameText').val('');
            }
        });

        $("#menu-add-tag").click(function (e) {
            e.preventDefault();
            var checkedValues = $('.todo-list-tag .i-checks:checked').map(function () {
                if (this.value != '') {
                    var newId = this.value;
                    var newUrl = tagsArr[this.value].url;
                    var newName = tagsArr[this.value].name;
                    var type = <?php echo TYPE_TAG; ?>;
                    addToMenu(newId, newName, newUrl, type);
                }

                return this.value;
            }).get();

            if (checkedValues == '') {
                alert('Vui lòng chọn dữ liệu');
            } else {
                $('.i-checks').iCheck('uncheck');
            }
        });

        $("#menu-add-category").click(function (e) {
            e.preventDefault();
            var checkedValues = $('.todo-list-category .i-checks:checked').map(function () {
                if (this.value != '') {
                    var newId = this.value;
                    var newUrl = categoriesArr[this.value].url;
                    var newName = categoriesArr[this.value].name;
                    var type = <?php echo TYPE_CATEGORY; ?>;
                    addToMenu(newId, newName, newUrl, type);
                }

                return this.value;
            }).get();

            if (checkedValues == '') {
                alert('Vui lòng chọn dữ liệu');
            } else {
                $('.i-checks').iCheck('uncheck');
            }
        });

        $("#menu-add-news-category").click(function (e) {
            e.preventDefault();
            var checkedValues = $('.todo-list-new-category .i-checks:checked').map(function () {
                if (this.value != '') {
                    var newId = this.value;
                    var newUrl = newCategoriesArr[this.value].url;
                    var newName = newCategoriesArr[this.value].name;
                    var type = <?php echo TYPE_NEW_CATEGORY; ?>;
                    addToMenu(newId, newName, newUrl, type);
                }

                return this.value;
            }).get();

            if (checkedValues == '') {
                alert('Vui lòng chọn dữ liệu');
            } else {
                $('.i-checks').iCheck('uncheck');
            }
        });

        $("#menu-add-page").click(function (e) {
            e.preventDefault();
            var checkedValues = $('.todo-list-page .i-checks:checked').map(function () {
                if (this.value != '') {
                    var newId = this.value;
                    var newUrl = pagesArr[this.value].url;
                    var newName = pagesArr[this.value].name;
                    var type = <?php echo TYPE_PAGE; ?>;
                    addToMenu(newId, newName, newUrl, type);
                }

                return this.value;
            }).get();

            if (checkedValues == '') {
                alert('Vui lòng chọn dữ liệu');
            } else {
                $('.i-checks').iCheck('uncheck');
            }
        });

        var addToMenu = function (newId, newName, newUrl, type) {
            var check = newId + '-' + type;
            nestableList.append(
                '<li class="dd-item" data-id="' + newId + '" data-check="' + check + '" data-name="' + newName + '" <?php echo $nameData; ?> data-url="' + newUrl + '" data-type="' + type + '" data-icon="">' +
                '<div class="fa dd-handle nested-list-handle"></div>' +
                '<div class="nested-list-content">' +
                '<span class="content">' + newName + '</span>' +
                '<span class="tip-msg"></span>' +
                '<div class="pull-right">' +
                '<span class="tip-hide"></span>' +
                '<a href="#editModal" class="button-edit edit_toggle" data-owner-id="' + check + '" data-toggle="modal">Edit</a> |' +
                '<a href="#deleteModal" data-owner-id="' + check + '" class="button-delete delete_toggle">Delete</a>' +
                '</div>' +
                '</div>' +
                '</li>'
            );

            newIdCount++;

            // update JSON
            updateOutput($('#nestable2').data('output', $('#nestable2-output')));
        };
    });
    <?php $this->Html->scriptEnd(); ?>
