<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class ContactForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('name', ['type' => 'string'])
            ->addField('email', ['type' => 'string'])
            ->addField('subject', ['type' => 'string'])
            ->addField('message', ['type' => 'string']);
    }

    /**
     * @param Validator $validator
     *
     * @return Validator
     */
    protected function _buildValidator(Validator $validator)
    {
        $validator
            ->notEmpty('name', __(USER_MSG_0013, 'Tên của bạn'))
            ->minLength(
                'name', MIN_LENGTH_USERNAME,
                __(USER_MSG_0002, 'Tên của bạn', MIN_LENGTH_USERNAME)
            );
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
            ->notEmpty('subject', __(USER_MSG_0013, 'Tiêu đề'))
            ->minLength(
                'subject', MIN_LENGTH_USERNAME,
                __(USER_MSG_0002, 'Your name', MIN_LENGTH_USERNAME)
            );
        ;
        $validator
            ->notEmpty('message', __(USER_MSG_0013, 'Nội dung'))
            ->minLength(
                'message', MIN_LENGTH_USERNAME,
                __(USER_MSG_0002, 'Your name', MIN_LENGTH_USERNAME)
            );
        ;

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
     * @param       $email
     * @param array $context
     *
     * @return bool
     */
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
