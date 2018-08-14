<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class ConfirmPasswordForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('oldPassword', ['type' => 'string'])
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
            ->add('oldPassword', 'custom', [
                'rule'    => function ($value, $context) {
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        if ((new DefaultPasswordHasher)->check($value,
                            $user->password)
                        ) {
                            return true;
                        }
                    }

                    return false;
                },
                'message' => 'The old password does not match the current password!',
            ])
            ->notEmpty('oldPassword');
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
}
