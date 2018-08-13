<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

class UtilityHelper extends Helper
{

    public $helpers = ['Html'];

    // initialize() hook is available since 3.2. For prior versions you can
    // override the constructor if required.
    public function initialize(array $config)
    {
    }

    /**
     * @param $url
     *
     * @return int
     */
    public function isValidURL($url)
    {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i',
            $url);
    }

    /**
     * @param $action
     *
     * @return int
     */
    public function getTypeCareer($action)
    {
        $type = LIBRARY_CAREER;
        if ($action == 'job') {
            $type = LIBRARY_JOB;
        } else if ($action == 'skill') {
            $type = LIBRARY_SKILL;
        } else if ($action == 'knowledge') {
            $type = LIBRARY_KNOWLEDGE;
        }

        return $type;
    }

    /**
     * Build menu admin with one level
     *
     * @param $arrMenus
     * @param $activeAction
     *
     * @return null|string
     */
    public function buildMenuAdmin($arrMenus, $activeAction)
    {
        $html = null;

        foreach ($arrMenus as $menu) {
            $url       = ! empty($menu['url']) ? $menu['url'] : [];
            $active    = $activeAction === $url ? 'active' : '';
            $subActive = '';

            // with case click submenu then parent class is active
            if ( ! empty($menu['child'])) {
                foreach ($menu['child'] as $child) {
                    if ($activeAction === $child['url']) {
                        $subActive = 'active';
                        break;
                    }
                }
            }

            $html .= '<li class="' . $active . ' ' . $subActive . '">';
            $html .= $this->Html->link(
                '<i class="' . $menu['icon'] . '"></i><span class="nav-label">'
                . $menu['title'] . '</span>', $url, ['escapeTitle' => false]
            );

            if ( ! empty($menu['child'])) {
                // only support build menu level 1
                $colIn = ! empty($subActive) ? 'in' : '';
                $html  .= '<ul class="nav nav-second-level collapse ' . $colIn
                    . '">';

                foreach ($menu['child'] as $child) {
                    $menuActive = $activeAction === $child['url'] ? 'active'
                        : '';

                    $subLink = $this->Html->link($child['title'],
                        $child['url']);
                    $html    .= '<li class="' . $menuActive . '">' . $subLink
                        . '</li>';
                }
                $html .= '</ul>';
            }
            $html .= '</li>';
        }

        return $html;
    }

    /**
     * @param $treeElement
     * @param $libList
     *
     * @return string
     */
    public function buildTreeCareer($treeElement, $libList)
    {
        $html = "<ul>";
        foreach ($treeElement as $key => $item) {
            if ( ! empty($libList[$item['library_id']])) {
                $class = $key === 0 ? 'target' : 'node';
                $html
                       .= "<li>
                 <a id=\"node-{$item['library_id']}\" data-level=\"0\" class=\"{$class}\" href=\"#\">{$libList[$item['library_id']]}</a>";
                if ( ! empty($item['children'])) {
                    $html .= $this->buildChildTree($item['children'], $libList, 0);
                }
                $html .= "</li>";
            }
        }
        $html .= "</ul>";

        return $html;
    }

    /**
     * @param $childTree
     * @param $libList
     * @param $level
     *
     * @return string
     */
    public function buildChildTree($childTree, $libList, $level)
    {
        ++ $level;
        $html = "<ul>";
        foreach ($childTree as $item) {
            if ( ! empty($libList[$item['library_id']])) {
                $html
                    .= "<li>
                 <a id=\"node-{$item['library_id']}\" data-level=\"{$level}\" class=\"node\" href=\"#\">{$libList[$item['library_id']]}</a>";
                if ( ! empty($item['children'])) {
                    $html .= $this->buildChildTree($item['children'], $libList, $level);
                }
                $html .= "</li>";
            }
        }
        $html .= "</ul>";

        return $html;
    }

    /**
     * item menu for front page
     * @return array
     */
    public function menuItem()
    {
        return [
            [
                'title' => 'Giới Thiệu',
                'url'   => ['controller' => 'Users', 'action' => 'about'],
            ],
            [
                'title' => 'Thư Viện',
                'url'   => ['controller' => 'Libraries', 'action' => 'index'],
            ],
            [
                'title' => 'Kế Hoạch Của Tôi',
                'url'   => ['controller' => 'Users', 'action' => 'plan'],
            ],
            [
                'title' => 'Diễn Đàn',
                'url'   => ['controller' => 'Users', 'action' => 'forum'],
            ],
            [
                'title' => 'Bài Viết',
                'url'   => '//blog.'. $_SERVER['HTTP_HOST']
            ],
            [
                'title' => 'Liên Hệ',
                'url'   => ['controller' => 'Users', 'action' => 'contact'],
            ],
        ];
    }

}