<?php

class vRelationships extends \Phalcon\Mvc\Model
{

	public $user_id;
	public $contact1_id;
	public $contact2_id;
    public $name;
    public $relationship;

    public function getSource()
    {
        return 'vRelationships';
    }

    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
