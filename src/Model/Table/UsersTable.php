<?php

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;

/**
 * Class UsersTable
 *
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

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

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
            ])
            ->where([
                'status'           => ENABLED,
                'user_group_id IN' => [ADMIN, SUPER_ADMIN],
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
            ];
            $replace = [
                $arrParams['email'],
                $arrParams['name'],
                $arrParams['subject'],
                $arrParams['message'],
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
}