<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class ContactForm extends Form
{
    public $captcha = '';

    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('name', ['type' => 'string'])
            ->addField('email', ['type' => 'string'])
            ->addField('phone', ['type' => 'string'])
            ->addField('subject', ['type' => 'string'])
            ->addField('message', ['type' => 'string'])
            ->addField('captcha', ['type' => 'string']);
    }

    /**
     * @param Validator $validator
     *
     * @return Validator
     */
    protected function _buildValidator(Validator $validator)
    {
        $validator
            ->notEmpty('name', __(USER_MSG_0013, 'name'));

        $validator
            ->notEmpty('phone', __(USER_MSG_0013, 'phone number'));

        $validator
            ->notEmpty('email', __(USER_MSG_0013, 'email'))
            ->add(
                'email', 'validEmail', [
                    'rule'    => [$this, 'checkEmail'],
                    'message' => __(USER_MSG_0012),
                ]
            );

        $validator
            ->notEmpty('subject', __(USER_MSG_0013, SUBJECT));

        $validator
            ->notEmpty('message', __(USER_MSG_0013, CONTENT_TEXT));

        $validator
            ->notEmpty('captcha', __(USER_MSG_0013, 'captcha'))
            ->add(
                'captcha', 'validCaptcha', [
                    'rule'    => [$this, 'matchCaptcha'],
                    'message' => __(USER_MSG_0014, 'captcha'),
                ]
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

    /**
     * @param $captcha
     *
     * @return bool
     */
    public function matchCaptcha($captcha)
    {
        //return true or false after comparing submitted value with set value of captcha
        return $captcha == $this->getCaptcha();
    }

    /**
     * @param $value
     */
    public function setCaptcha($value)
    {
        $this->captcha = $value;
    }

    /**
     * @return string
     */
    public function getCaptcha()
    {
        return $this->captcha;
    }
}
