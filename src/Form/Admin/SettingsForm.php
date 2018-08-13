<?php

namespace App\Form\Admin;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * Settings Form.
 */
class SettingsForm extends Form
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
        return $schema->addField('site_mail_hostname', 'string')
            ->addField('site_mail_username', ['type' => 'string'])
            ->addField('site_mail_password', ['type' => 'string'])
            ->addField('site_mail_port', ['type' => 'integer'])
            ->addField('site_mail_timeout', ['type' => 'integer'])
            ->addField('site_mail_number', ['type' => 'integer'])
            ->addField('site_name', ['type' => 'string'])
            ->addField('site_mail', ['type' => 'string'])
            ->addField('site_slogan', ['type' => 'string'])
            ->addField('site_description', ['type' => 'text'])
            ->addField('site_language', ['type' => 'integer'])
            ->addField('site_image_allow', ['type' => 'string']);
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
            ->add('site_mail_hostname', 'required', ['rule' => 'notBlank'])
            ->add('site_mail_username', 'required', ['rule' => 'notBlank'])
            ->add('site_mail_password', 'required', ['rule' => 'notBlank'])
            ->add('site_mail_timeout', 'required', ['rule' => 'notBlank'])
            ->add('site_mail_port', 'required', ['rule' => 'notBlank'])
            ->add('site_mail_number', 'required', ['rule' => 'notBlank'])
            ->add('site_name', 'required', ['rule' => 'notBlank'])
            ->add('site_mail', 'required', ['rule' => 'notBlank'])
            ->add('site_slogan', 'required', ['rule' => 'notBlank'])
            ->add('site_language', 'required', ['rule' => 'notBlank']);
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
