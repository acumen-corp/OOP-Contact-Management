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
	public $user_id;
	
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

	public static function filterIneligibleContacts($contact1_id)
	{
		$relationships  = Relationships::find('contact1_id = ' . $contact1_id);

		// Build an array of existing relationship contact2_ids.
		$ineligibleContactIds = array();
		foreach ( $relationships as  $relationship) {
			array_push($ineligibleContactIds, $relationship->contact2_id);
		}
		
		// Add the current contact
		array_push($ineligibleContactIds, $contact1_id);

		$filter = '';
		// Remove ineligible contacts from the available relationship contacts.
		if (!empty($ineligibleContactIds)) {
			foreach ( $ineligibleContactIds as $relID) {
				if ($filter == '') {
					$filter .= 'id != ' . $relID;
				} else {
					$filter .= ' and id != ' . $relID;
				}
			}
		}		
		
		return $filter;
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
