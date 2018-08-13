<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class RegisterForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('name', ['type' => 'string'])
            ->addField('email', ['type' => 'string'])
            ->addField('password', ['type' => 'string'])
            ->addField('confirmPass', ['type' => 'string']);
    }

    /**
     * @param Validator $validator
     *
     * @return Validator
     */
    protected function _buildValidator(Validator $validator)
    {
        $validator
            ->notEmpty('name', __(USER_MSG_0013, 'name'))
//            ->add(
//                'name', 'validChars', [
//                    'rule'    => [$this, 'checkCharacters'],
//                    'message' => __(USER_MSG_0003),
//                ]
//            )
        ;
        $validator
            ->notEmpty('email', __(USER_MSG_0013, 'email'))
            ->add(
                'email', 'validEmail', [
                    'rule'    => [$this, 'checkEmail'],
                    'message' => __(USER_MSG_0012),
                ]
            );
        $validator
            ->notEmpty('password', __(USER_MSG_0013, 'password'))
            ->minLength(
                'password', MIN_LENGTH_PASSWORD,
                __(USER_MSG_0002, 'Password', MIN_LENGTH_PASSWORD)
            );
        $validator
            ->notEmpty('confirmPass', __(USER_MSG_0013, 'password'))
            ->minLength(
                'confirmPass', MIN_LENGTH_PASSWORD,
                __(USER_MSG_0002, 'Password', MIN_LENGTH_PASSWORD)
            )->sameAs('confirmPass', 'password', __(USER_MSG_0014, 'password'));

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
        preg_match("/[a-zA-Z0-9\s]*/", $username, $result);
        if (strlen($username) === strlen($result[0])) {
            return true;
        }

        return false;
    }

    public function checkEmail($email, array $context)
    {
        preg_match(
            '/^[a-zA-z0-9_\.]+@[a-zA-Z0-9]+\.+[a-zA-Z]{2,}$/',
            $email, $result
        );
        if ( ! empty($result)) {
            return true;
        }

        return false;
    }
}
