<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Criteria;

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

    // public $created_at;
		// Set by mysql

	public static function buildCriteria($search, $user_id, $di)
	{
		$criteria = new Criteria();
		$criteria->setDI = $di;
		$criteria->where('name like \'%' . $search .'%\'');
		$criteria->orWhere('email like \'%' . $search .'%\'');
		$criteria->orWhere('telephone like \'%' . $search .'%\'');
		$criteria->orWhere('address like \'%' . $search .'%\'');
		$criteria->orWhere('birthday like \'%' . $search .'%\'');
		$criteria->andWhere('user_id = ' . $user_id);

		return $criteria;
	}
}
