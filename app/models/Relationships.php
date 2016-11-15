<?php

class Relationships extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
	public user_id;
	
    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $contact1_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $contact2_id;

    /**
     *
     * @var string
     * @Column(type="string", length=70, nullable=false)
     */
    public $relationship;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'relationships';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Relationships[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Relationships
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
