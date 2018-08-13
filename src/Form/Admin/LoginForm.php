<?php

namespace App\Form\Admin;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class LoginForm extends Form
{
    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('username', ['type' => 'string'])
            ->addField(
                'password', ['type' => 'string']
            );
    }

    /**
     * @param Validator $validator
     *
     * @return Validator
     */
    protected function _buildValidator(Validator $validator)
    {
        $validator
            ->notEmpty('username', __(USER_MSG_0004))
            ->add(
                'username', 'validChars', [
                    'rule'    => [$this, 'checkCharacters'],
                    'message' => __(USER_MSG_0003),
                ]
            )->minLength(
                'username', MIN_LENGTH_USERNAME,
                __(USER_MSG_0002, 'Username', MIN_LENGTH_USERNAME)
            );
        $validator
            ->notEmpty('password', __(USER_MSG_0005))
            ->minLength(
                'password', MIN_LENGTH_PASSWORD,
                __(USER_MSG_0002, 'Password', MIN_LENGTH_PASSWORD)
            );

        return $validator;
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

    /**
     * Checking information of username is wrong when username has special characters
     *
     * @param       $username
     * @param array $context
     *
     * @return bool
     */
    public function checkCharacters($username, array $context)
    {
        preg_match("/[a-zA-Z0-9\_\.@]*/", $username, $result);
        if (strlen($username) === strlen($result[0])) {
            return true;
        }

        return false;
    }

}
