<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Cake\Mailer\Email;
use Cake\Database\Exception;
use Cake\Cache\Cache;
use Cake\ORM\Query;

/**
 * Class CommonTable
 *
 * @package App\Model\Table
 */
class CommonTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new',
                    'updated_at' => 'always',
                ],
            ],
        ]);
    }

    /**
     * Check value already exist in table
     *
     * @param        $value
     * @param string $field
     *
     * @return bool
     */
    public function valueExistInTable($value, $field = 'id')
    {
        $modelAlias = $this->_alias;
        $conditions = array(
            $modelAlias . '.' . $field => $value,
        );

        return (bool)$this->find()->where($conditions)->count();
    }

    /**
     * Get list data from table
     *
     * @param string $field
     * @param array  $conditions
     * @param string $keyField
     *
     * @return array
     */
    public function getObjectList(
        $field = 'name',
        $conditions = [],
        $keyField = 'id'
    ) {
        return $this->find('list', [
            'keyField'   => $keyField,
            'valueField' => $field,
        ])->enableHydration(false)
            ->where($conditions)->toArray();
    }

    /**
     * Execute query with conditions
     *
     * @param $select
     * @param $conditions
     * @param $orderBy
     * @param $limit
     * @param $contain
     *
     * @return array
     */
    public function execute(
        $select,
        $conditions,
        $orderBy,
        $limit,
        $contain = []
    ) {
        return $this->find()
            ->select($select)
            ->enableHydration(false)
            ->where($conditions)
            ->contain($contain)
            ->order($orderBy)
            ->limit($limit)->toArray();
    }

    /**
     * convert to slug
     *
     * @param $slug
     *
     * @return string
     */
    public function convertToSlug($slug)
    {
        return Text::slug(mb_strtolower($slug, 'UTF-8'));
    }

    /**
     * this is function send email with options
     * sendMail method
     *
     * @param        $subject
     * @param        $body
     * @param        $to
     * @param array  $viewVarsOption
     * @param string $config
     * @param null   $attachedFile
     * @param string $format
     * @param string $template
     *
     * @return bool
     */
    public function sendMail(
        $subject,
        $body,
        $to,
        $viewVarsOption = [],
        $format = 'html',
        $config = 'gmail',
        $attachedFile = null,
        $template = 'default',
        $layout = 'default',
        $cc = []
    ) {
        $isSendMail = false;
        try {
            $viewVarsOption = array_merge(array(
                'user'        => $to,
                'title'       => $subject,
                'settingInfo' => $this->_getConfigs(),
            ), $viewVarsOption);

            $email = new Email($config);
            $email->setTemplate($template)
                ->setEmailFormat($format)
                ->setTo($to)
                ->setSubject($subject)
                ->setViewVars($viewVarsOption)
                ->setLayout($layout);
            if ( ! empty($cc)) {
                $email->addCc($cc);
            }
            if ( ! empty($attachedFile)) {
                $email->addAttachments($attachedFile);
            }
            if ($email->send($body)) {
                $isSendMail = true;
            }
        } catch (Exception $ex) {
            $isSendMail = false;
        }

        return $isSendMail;
    }

    /**
     * Get config from setting
     */
    private function _getConfigs()
    {
        $key = KEY_COMMON_CACHE;

        if (($settingInfo = Cache::read($key)) === false) {
            /* @var \App\Model\Table\SettingsTable $settingTbl */
            $settingTbl  = TableRegistry::getTableLocator()->get('Settings');
            $conditions  = [
                'OR' => [
                    [
                        'name IN' => [
                            'site_mail',
                            'site_facebook',
                            'site_linked',
                            'site_tag',
                            'site_banner_popup',
                        ],
                    ],
                    ['name LIKE' => 'meta_%'],
                ],
            ];
            $settingInfo = $settingTbl->getListSetting([], $conditions);
            Cache::write($key, $settingInfo);
        }

        return $settingInfo;
    }

    /**
     * @param       $value
     * @param array $context
     *
     * @return bool
     */
    public function checkStartDateWithEndDate($value, array $context)
    {
        $startDate = ! empty($value) ? strtotime($value) : 0;
        $endDate   = ! empty($context['data']['end_date'])
            ? strtotime($context['data']['end_date']) : 0;
        if ($startDate > $endDate) {
            return false;
        }

        return true;
    }

}
