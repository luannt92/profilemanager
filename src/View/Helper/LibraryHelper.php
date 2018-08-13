<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

class LibraryHelper extends Helper
{

    public $helpers = ['Html'];

    /**
     * @param $treeElement
     * @param $libList
     *
     * @return string
     */
    public function buildLibraryTree($treeElement, $libList)
    {
        $html  = "<ul class=\"list-group collapse in\" id='library-tree-left'>";
        $jsArr = [];
        foreach ($treeElement as $key => $item) {
            if ( ! empty($libList[$item['library_id']])) {
                $id     = $item['library_id'] . "-0_{$key}";
                $idHtml = "submenu{$id}";
                $jsArr  = [
                    'id'      => $id,
                    'name'    => $libList[$item['library_id']],
                    'level'   => 0,
                    'lib'   => $item['library_id'],
                    'display' => true,
                    'active'  => true,
                ];
                $html
                        .= "<li class=\"nav-item\">
                        <a href=\"#{$idHtml}\" class=\"list-group-item topmenu iconmenu1 active collapsed toggleClick\" data-toggle=\"collapse\" aria-expanded=\"true\" data-id=\"{$id}\" data-level=\"0\">
                            <span>{$libList[$item['library_id']]}</span>
                        </a>";
                if ( ! empty($item['children'])) {
                    $child             = $this->buildChildTree($item['children'],
                        $libList,
                        0, $idHtml, $jsArr);
                    $html              .= $child['html'];
                    $jsArr['children'] = $child['js'];
                }
                $html .= "</li>";
            }
        }
        $html .= "</ul>";

        return [
            'html' => $html,
            'js'   => $jsArr,
        ];
    }

    /**
     * @param $childTree
     * @param $libList
     * @param $level
     * @param $idHtml
     * @param $arrTmpJs
     *
     * @return string
     */
    public function buildChildTree(
        $childTree,
        $libList,
        $level,
        $idHtml,
        $arrTmpJs
    ) {
        ++$level;
        $class   = $level == 1 ? 'menu-item' : '';
        $clsCollapse   = ($arrTmpJs['active'] != true) ? 'collapse' : 'collapse in';
        $html    = "<ul class=\"submenu {$class} {$clsCollapse}\" id=\"{$idHtml}\">";
        $jsChild = [];
        foreach ($childTree as $index => $item) {
            if ( ! empty($libList[$item['library_id']])) {
                $id      = $item['library_id'] . "-{$level}_{$index}_{$arrTmpJs['id']}";
                $idHtml  = "submenu{$id}";
                $display = $arrTmpJs['active'];
                $active  = ($arrTmpJs['active'] == true && $index == 0
                    && $level < 3) ? true : false;
                $arrTmp  = [
                    'id'      => $id,
                    'name'    => $libList[$item['library_id']],
                    'level'   => $level,
                    'lib'   => $item['library_id'],
                    'display' => $display,
                    'active'  => $active,
                ];

                $activeClass = $active ? 'active iconmenu2' : '';
                $html
                         .= "<li class=\"nav-item\">
                <a href=\"#{$idHtml}\" class=\"list-group-item toggleClick iconmenu1 {$activeClass}\" data-toggle=\"collapse\" aria-expanded=\"true\" data-id=\"{$id}\" data-level=\"{$level}\">
                    <span>{$libList[$item['library_id']]}</span>
                </a>";
                if ( ! empty($item['children'])) {
                    $child              = $this->buildChildTree($item['children'],
                        $libList,
                        $level, $idHtml, $arrTmp);
                    $html               .= $child['html'];
                    $arrTmp['children'] = $child['js'];
                }
                $html      .= "</li>";
                $jsChild[] = $arrTmp;
            }
        }
        $html .= "</ul>";

        return [
            'html' => $html,
            'js'   => $jsChild,
        ];
    }
}