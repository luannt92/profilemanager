<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
use Cake\Routing\Router;

/**
 * Class UsersTable
 *
 * @property \App\Model\Table\UserGroupsTable $UserGroups
 * @package App\Model\Table
 */
class UsersTable extends CommonTable
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

        $this->setTable(TABLE_PREFIX . 'users');
        $this->setDisplayField('id');

        $this->belongsTo('UserGroups', [
            'foreignKey' => 'user_group_id',
            'joinType'   => 'INNER',
        ]);

        $this->addAssociations(
            [
                'hasMany' => [
                    'Addresses' => ['foreignKey' => 'user_id'],
                ],
            ]
        );
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

//        $validator
//            ->email('email')
//            ->requirePresence('email', 'create')
//            ->notEmpty('email');

        $validator
            ->scalar('password')
            ->requirePresence('password', 'create')
            ->notEmpty('password', __(USER_MSG_0010), 'create')
            ->minLength('password', MIN_LENGTH_PASSWORD,
                __(USER_MSG_0002, 'Mật khẩu', MIN_LENGTH_PASSWORD));

        $validator
            ->scalar('avatar')
            ->allowEmpty('avatar');

        $validator
            ->scalar('	full_name')
            ->allowEmpty('	full_name');

        $validator
            ->integer('gender')
            ->notEmpty('gender');

        $validator
            ->date('birthday')
            ->allowEmpty('birthday');

        $validator
            ->scalar('address')
            ->allowEmpty('address');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     *
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['user_group_id'], 'UserGroups'));

        return $rules;
    }

    /**
     * login with admin
     *
     * @param \Cake\ORM\Query $query
     * @param array           $options
     *
     * @return \Cake\ORM\Query
     */
    public function findAuthAdmin(Query $query, array $options)
    {
        $query
            ->select([
                'id',
                'password',
                'user_group_id',
                'email',
                'full_name',
                'avatar',
                'usg.id',
                'usg.name',
                'usg.type',
            ])
            ->join([
                'table'      => TABLE_PREFIX . 'user_groups',
                'alias'      => 'usg',
                'type'       => 'INNER',
                'conditions' => 'usg.id = Users.user_group_id',
            ])
            ->where([
                'Users.status' => ENABLED,
                'usg.type IN'  => [ADMIN, SUPER_ADMIN],
            ]);

        return $query;
    }

    /**
     * login with member
     *
     * @param \Cake\ORM\Query $query
     * @param array           $options
     *
     * @return \Cake\ORM\Query
     */
    public function findAuthMember(Query $query, array $options)
    {
        $query
            ->select()
            ->where([
                'status IN'        => [
                    ENABLED,
                    REGISTER_STATUS,
                    DISABLED,
                    TRASH,
                ],
                'user_group_id IN' => [MEMBER],
            ]);

        return $query;
    }

    /**
     * @param array $arrParam
     *
     * @return bool
     */
    public function register($arrParam = [])
    {
        $result     = false;
        $user       = $this->newEntity();
        $userEmail  = $arrParam['email'];
        $confirmKey = md5($userEmail . date('Y-m-d'));
        $data       = array_merge($arrParam, [
                'confirm_key'   => $confirmKey,
                'user_group_id' => MEMBER,
                'status'        => REGISTER_STATUS,
            ]
        );
        $user       = $this->patchEntity($user, $data);
        $this->getConnection()->begin();

        if ($this->save($user)) {
            $confirmLink = Router::url([
                'controller' => 'Users',
                'action'     => 'active',
                '?'          => ['key' => $confirmKey],
            ], true);

            /* @var \App\Model\Table\MailTemplatesTable $mailObj */
            $mailObj = TableRegistry::get('MailTemplates');
            $mail    = $mailObj->getMailTemplate(MAIL_TEMPLATE_REGISTER);
            $pattern = ['/\%user\%/', '/\%link\%/'];
            $replace = [$arrParam['full_name'], $confirmLink];
            $content = preg_replace($pattern, $replace, $mail['content']);
            if ($this->sendMail($mail['subject'], $content, $userEmail)
            ) {
                $result = true;
                $this->getConnection()->commit();
            } else {
                $this->getConnection()->rollback();
            }
        } else {
            $this->getConnection()->rollback();
        }

        return $result;
    }

    public function registerApi($arrParam = [])
    {
        $result     = false;
        $user       = $this->newEntity();
        $userEmail  = $arrParam['email'];
        $confirmKey = mt_rand(1000, 9999);
        $data       = array_merge($arrParam, [
                'confirm_key'   => $confirmKey,
                'user_group_id' => MEMBER,
                'status'        => REGISTER_STATUS,
            ]
        );
        $user       = $this->patchEntity($user, $data);
        $this->getConnection()->begin();

        if ($this->save($user)) {
            /* @var \App\Model\Table\MailTemplatesTable $mailObj */
            $mailObj = TableRegistry::get('MailTemplates');
            $mail    = $mailObj->getMailTemplate(MAIL_TEMPLATE_REGISTER_API);
            $pattern = ['/\%user\%/', '/\%link\%/'];
            $replace = [$arrParam['full_name'], $confirmKey];
            $content = preg_replace($pattern, $replace, $mail['content']);
            if ($this->sendMail($mail['subject'], $content, $userEmail)
            ) {
                $result = true;
                $this->getConnection()->commit();
            } else {
                $this->getConnection()->rollback();
            }
        } else {
            $this->getConnection()->rollback();
        }

        return $result;
    }

    /**
     * @param array $arrParam
     *
     * @return array|bool|\Cake\Datasource\EntityInterface|null
     */
    public function activeAccount($arrParam = [])
    {
        $result     = false;
        $conditions = [
            'confirm_key' => $arrParam['key'],
            'status'      => REGISTER_STATUS,
        ];
        $userInfo   = $this->find()->where($conditions)->first();

        if ( ! empty($userInfo)) {
            $userInfo->status      = ENABLED;
            $userInfo->confirm_at  = date('Y-m-d H:i:s');
            $userInfo->last_access = date('Y-m-d H:i:s');

            $this->getConnection()->begin();

            if ($this->save($userInfo)) {
                $link = Router::url('/', true);

                /* @var \App\Model\Table\MailTemplatesTable $mailObj */
                $mailObj = TableRegistry::get('MailTemplates');
                $mail
                         = $mailObj->getMailTemplate(MAIL_TEMPLATE_REGISTER_SUCCESS);
                $pattern = ['/\%user\%/', '/\%link\%/'];
                $replace = [$userInfo->full_name, $link];
                $content = preg_replace($pattern, $replace, $mail['content']);
                if ($this->sendMail($mail['subject'], $content,
                    $userInfo->email)
                ) {
                    $result = $userInfo;
                    $this->getConnection()->commit();
                } else {
                    $this->getConnection()->rollback();
                }
            } else {
                $this->getConnection()->rollback();
            }
        }

        return $result;
    }

    /**
     * @param array $arrParam
     *
     * @return array|bool|\Cake\Datasource\EntityInterface|null
     */
    public function forgotPassword($arrParam = [])
    {
        $result     = false;
        $conditions = [
            'Users.email'  => $arrParam['email'],
            'Users.status' => ENABLED,
        ];
        $userInfo   = $this->find()->where($conditions)
            ->contain([
                'UserGroups' => [
                    'conditions' => [
                        'UserGroups.type NOT IN' => [ADMIN, SUPER_ADMIN],
                    ],
                ],
            ])->first();
        if ( ! empty($userInfo)) {
            $confirmLink = Router::url([
                'controller' => 'Users',
                'action'     => 'confirmPassword',
                '?'          => [
                    'request' => base64_encode($arrParam['email']),
                    'key'     => md5(date('Ymd') . $arrParam['email']),
                ],
            ], true);
            /* @var \App\Model\Table\MailTemplatesTable $mailObj */
            $mailObj = TableRegistry::get('MailTemplates');
            $mail
                     = $mailObj->getMailTemplate(MAIL_TEMPLATE_FORGOT_PASSWORD);
            $pattern = ['/\%user\%/', '/\%link\%/'];
            $replace = [$userInfo->full_name, $confirmLink];
            $content = preg_replace($pattern, $replace,
                $mail['content']);
            if ($this->sendMail($mail['subject'], $content,
                $arrParam['email'])
            ) {
                $result = true;
            }
        } else {
            return -1;
        }

        return $result;
    }

    public function forgotPasswordApi($arrParam = [])
    {
        $result     = false;
        $conditions = [
            'email'  => $arrParam['email'],
            'status' => ENABLED,
        ];
        $userInfo   = $this->find()->where($conditions)->first();
        if ( ! empty($userInfo)) {
            $confirmKey = mt_rand(1000, 9999);
            $this->updateAll(['confirm_key' => $confirmKey],
                ['id' => $userInfo->id]);
            /* @var \App\Model\Table\MailTemplatesTable $mailObj */
            $mailObj = TableRegistry::get('MailTemplates');
            $mail
                     = $mailObj->getMailTemplate(MAIL_TEMPLATE_FORGOT_PASSWORD_API);
            $pattern = ['/\%user\%/', '/\%key\%/'];
            $replace = [$userInfo->full_name, $confirmKey];
            $content = preg_replace($pattern, $replace,
                $mail['content']);
            if ($this->sendMail($mail['subject'], $content,
                $arrParam['email'])
            ) {
                $result = true;
            }
        } else {
            return -1;
        }

        return $result;
    }

    /**
     * @param $email
     * @param $password
     *
     * @return bool
     */
    public function confirmPassword($email, $password)
    {
        $result     = false;
        $conditions = [
            'email'  => $email,
            'status' => ENABLED,
        ];
        $userInfo   = $this->find()->where($conditions)->first();

        if ( ! empty($userInfo)) {
            /* @var \App\Model\Table\MailTemplatesTable $mailObj */
            $mailObj = TableRegistry::get('MailTemplates');
            $mail
                     = $mailObj->getMailTemplate(MAIL_TEMPLATE_RESET_FORGOT_PASSWORD);
            $pattern = ['/\%user\%/'];
            $replace = [$userInfo->full_name];
            $content = preg_replace($pattern, $replace, $mail['content']);
            if ($this->sendMail($mail['subject'], $content, $email)) {
                $userInfo->password = $password;
                if ($this->save($userInfo)) {
                    $result = true;
                }
            }
        }

        return $result;
    }

    /**
     * @param $profile
     * @param $provider
     *
     * @return bool|\Cake\Datasource\EntityInterface|false|mixed
     */
    public function createMember($profile, $provider)
    {
        $data = [
            'email'         => $profile->email,
            'sns_id'        => $profile->identifier,
            'sns_type'      => $provider,
            'user_type'     => FREE_TYPE,
            'full_name'     => $profile->displayName,
            'note'          => $profile->description,
            'confirm_key'   => md5($profile->email),
            'confirm_at'    => date('Y-m-d'),
            'last_access'   => date('Y-m-d'),
            'user_group_id' => MEMBER,
            'status'        => ENABLED,
        ];

        if ($provider === FB_SOCIAL) {
            $data['avatar']   = __(AVATAR_URL, $profile->identifier);
            $data['gender']   = strtolower($profile->gender) === 'male' ? MALE
                : FEMALE;
            $data['birthday'] = date('Y-m-d', strtotime(
                $profile->birthYear . '-'
                . $profile->birthMonth . '-' . $profile->birthDay
            ));
        }

        $user = $this->newEntity();
        $user = $this->patchEntity($user, $data, [
            'validate' => false,
        ]);

        if ($this->save($user)) {

            /** @var \App\Model\Table\UserLogsTable $userLog */
            $userLog = TableRegistry::get('UserLogs');
            $userLog->updateLoginNumber($user->id);

            return $user;
        }

        return [];
    }

    /**
     * @param $arrParams
     * @param $email
     *
     * @return bool
     */
    public function contact($arrParams, $email)
    {
        $result = false;
        if ( ! empty($arrParams)) {
            /* @var \App\Model\Table\MailTemplatesTable $mailObj */
            $mailObj = TableRegistry::get('MailTemplates');
            $mail
                     = $mailObj->getMailTemplate(MAIL_TEMPLATE_CONTACT);
            $pattern = [
                '/\%email\%/',
                '/\%fullname\%/',
                '/\%title\%/',
                '/\%content\%/',
                '/\%phone\%/',
            ];
            $replace = [
                $arrParams['email'],
                $arrParams['name'],
                $arrParams['subject'],
                $arrParams['message'],
                $arrParams['phone'],
            ];
            $content = preg_replace($pattern, $replace, $mail['content']);
            if ($this->sendMail($mail['subject'], $content, $email)) {
                $result = true;
            }
        }

        return $result;
    }

    /**
     * Get first item when id not send
     *
     * @return array|\Cake\Datasource\EntityInterface
     */
    public function getFirstItems()
    {
        return $this->find()
            ->enableHydration(false)
            ->select(['id', 'full_name', 'email'])
            ->where(['status' => ENABLED, 'user_group_id' => MEMBER])
            ->firstOrFail();
    }

    /**
     * get all user
     *
     * @param array $condition
     * @param bool  $list
     * @param array $fields
     * @param array $order
     * @param null  $limit
     *
     * @return array|\Cake\Datasource\EntityInterface|null
     */
    public function getAllUsers(
        $condition = [],
        $list = false,
        $fields = [],
        $order = [],
        $limit = null
    ) {
        $condition = array_merge($condition, ['status' => ENABLED]);

        $query = $list === false ? $this->find()->select($fields)
            : $this->find('list', $fields);
        $query->where($condition)->enableHydration(false)->order($order);

        if ( ! empty($limit) && $limit !== 1) {
            $query->limit($limit);
        }

        if ($limit === 1) {
            return $query->first();
        }

        return $query->toArray();
    }

    /**
     * check status of user
     *
     * @param $status
     *
     * @return null|string
     */
    public function _checkErrorStatus($status)
    {
        $error = null;
        switch ($status) {
            case REGISTER_STATUS:
                $error = __(USER_MSG_0033);
                break;
            case DISABLED:
                $error = __(USER_MSG_0041);
                break;
            case TRASH:
                $error = __(USER_MSG_0042);
                break;
        }

        return $error;
    }

    /**
     * @param      $profile
     * @param null $provider
     *
     * @return mixed
     */
    public function _findOrCreateUser($profile, $provider)
    {
        if ($profile->email == '') {
            $profile->email = $profile->identifier;
        }
        $mode = isset($profile->mode) ? $profile->mode : 2;
        $user = $this->findByEmail($profile->email)->first();

        if (empty($user)) {
            return $this->createMember($profile, $provider);
        } else {
            if (in_array($user->status,
                array(REGISTER_STATUS, DISABLED, TRASH))
            ) {
                $this->_checkErrorStatus($user->status);
            } else {
                if (empty($user->avatar) && isset($profile->photoURL)) {
                    $user->avatar = $profile->photoURL;
                }

                if (empty($user->full_name) && isset($profile->displayName)) {
                    $user->full_name = $profile->displayName;
                }

                $user->last_access = date('Y-m-d H:i:s');
                if ($this->save($user)) {
                    /** @var \App\Model\Table\UserLogsTable $userLog */
                    $userLog = TableRegistry::get('UserLogs');
                    $userLog->updateLoginNumber($user->id, $mode);
                }

                return $user;
            }
        }
    }

}