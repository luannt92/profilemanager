<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Class NewsController
 *
 * @property \App\Model\Table\NewsTable $News
 * @package App\Controller
 */
class NewsController extends CommonController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function view($slug)
    {
        $new = $this->News->findBySlug($slug)->contain([
            'Tags',
            'NewCategories',
        ])->first();

        $this->set(compact('new'));
    }
}
