<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

class LinkHelper extends Helper
{

    public $helpers = ['Html'];

    /**
     * @return string
     */
    public function buildLink($menuLinks, $limit = null)
    {
        $html           = null;
        $countMenuLinks = count($menuLinks);
        if (isset($limit) && $countMenuLinks > $limit) {
            $countItemColMenuLinks = round($limit / 2);
        } else {
            $countItemColMenuLinks = round($countMenuLinks / 2);
        }

        foreach ($menuLinks as $key => $menuLink) {
            if ($key == 0) {
                $html .= '<div class="col-xs-6">';
                $html .= "<div>";
            }
            $html .= $this->Html->link($menuLink->name,
                $menuLink->url);

            if ($key == $countItemColMenuLinks - 1) {
                $html .= "</div>";
                $html .= "</div>";
                $html .= '<div class="col-xs-6">';
                $html .= "<div>";
            }
            if ($key == $countMenuLinks - 1) {
                $html .= "</div>";
                $html .= "</div>";
            }
            if (isset($limit) && $key == $limit - 1) {
                break;
            }
        }

        return $html;
    }
}