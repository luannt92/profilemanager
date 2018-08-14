<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Class CategoriesController
 *
 * @package App\Controller
 */
class CategoriesController extends CommonController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        /* @var \App\Model\Table\ServicesTable $servicesTable */
        $servicesTable = TableRegistry::get('Services');
        $services      = $servicesTable->getAllServices();

        if (!empty($services['meta_title']) && !empty($services['meta_keyword']) &&
            !empty($services['meta_description'])) {
            $meta_title = $services['meta_title'];
            $meta_keyword = $services['meta_keyword'];
            $meta_description = $services['meta_description'];
            $this->set(compact('meta_title', 'meta_keyword', 'meta_description'));
        }

        $this->set(compact('services'));
    }
}
