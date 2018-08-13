<?php

namespace App\Controller\Admin;

use \Cake\Core\Configure;

/**
 * Class UserGroupsController
 *
 * @package App\Controller\Admin
 */
class UserGroupsController extends CommonController
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * @param       $conditions
     * @param array $params
     *
     * @return mixed
     */
    protected function _searchFiltersCondition($conditions, $params = [])
    {
        if ( ! empty($params['keyword'])) {
            $keyword      = trim($params['keyword']);
            $conditions[] = [
                'OR' => [
                    'UserGroups.name LIKE' => '%' . $keyword . '%',
                    'UserGroups.id LIKE'   => $keyword,
                ],
            ];
        }

        if (isset($params['status']) && is_numeric($params['status'])) {
            $conditions['UserGroups.status'] = trim($params['status']);
        }

        return $conditions;
    }

    /**
     * Set variable to view
     */
    protected function _setVarToView()
    {
        $status = Configure::read('system_status');

        $this->set(compact('status'));
    }
}
