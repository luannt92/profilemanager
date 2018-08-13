<?php

namespace App\Controller\Admin;

/**
 * Class MailTemplatesController
 *
 * @property \App\Model\Table\MailTemplatesTable $MailTemplates
 * @package App\Controller\Admin
 */
class MailTemplatesController extends CommonController
{
    /**
     * Using for access with action
     *
     * @var array
     */
    protected $_allowAction = ['index', 'add', 'edit', 'view'];

    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Index method
     *
     * @param array $conditions
     */
    public function index($conditions = [])
    {
        $mailTemplates = $this->MailTemplates->find()->toArray();
        $this->set(compact('mailTemplates'));
    }

    /**
     * View email template in admin
     *
     * @param null $id
     *
     * @return \Cake\Http\Response
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('Email/html/default');

        $item = $this->MailTemplates->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('item'));

        return $this->render('view_job');
    }
}
