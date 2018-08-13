<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\Behavior\Translate\TranslateTrait;

/**
 * Class User
 *
 * @package App\Model\Entity
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible
        = [
            '*'  => true,
            'id' => false,
        ];

    use TranslateTrait;

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden
        = [
            'password',
        ];

    /**
     * Set password with md5
     *
     * @param $password
     *
     * @return string
     */
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return md5($password);
        }
    }
}
