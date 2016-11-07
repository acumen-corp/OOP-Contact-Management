<?php

use Phalcon\Mvc\Model;

class Contacts extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $telephone;

    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $birthday;

    public $email;

    public $created_at;

/*
    public function beforeCreate()
    {
      $this->created_at = new RawValue('now()');
    }
*/
}
