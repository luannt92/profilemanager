<?php

namespace App\Form\Admin;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * Users Form.
 */
class UsersForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     *
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('username', 'string')
            ->addField('email', ['type' => 'string'])
            ->addField('fullname', ['type' => 'string'])
            ->addField('password', ['type' => 'string'])
            ->addField('phone', ['type' => 'string'])
            ->addField('address', ['type' => 'string'])
            ->addField('fb_id', ['type' => 'string'])
            ->addField('ssn', ['type' => 'string'])
            ->addField('group_id', ['type' => 'integer'])
            ->addField('birthday', ['type' => 'date'])
            ->addField('gender', ['type' => 'integer']);
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     *
     * @return \Cake\Validation\Validator
     */
    protected function _buildValidator(Validator $validator)
    {
        return $validator
            ->add('group_id', 'required', ['rule' => 'notBlank'])
            ->add('username', 'required', ['rule' => 'notBlank'])
            ->add('password', 'required', ['rule' => 'notBlank'])
            ->add('gender', 'required', ['rule' => 'notBlank'])
            ->add('username', 'length', [
                'rule'    => ['minLength', MIN_LENGTH_USERNAME],
                'message' => __(USER_MSG_0002, 'Username', MIN_LENGTH_USERNAME),
            ])
            ->add('password', 'length', [
                'rule'    => ['minLength', MIN_LENGTH_PASSWORD],
                'message' => __(USER_MSG_0002, 'Password', MIN_LENGTH_PASSWORD),
            ]);
    }

    /**
     * Defines what to execute once the From is being processed
     *
     * @param array $data Form data.
     *
     * @return bool
     */
    protected function _execute(array $data)
    {
        return true;
    }
}
