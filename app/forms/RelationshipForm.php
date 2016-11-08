<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Numericality;

class RelationshipForm extends Form
{

    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {

      $this->add(new Hidden("id"));

      $contactname = new Select('name', Contacts::find(), array(
          'using'      => array( 'name', 'name'),
          'useEmpty'   => false,
          'emptyText'  => '...',
          'emptyValue' => 'name'
      ));
      $contactname->setLabel('Choose a Contact');
      $contactname->setFilters(array('striptags', 'string'));
      $contactname->addValidators(array(
          new PresenceOf(array(
              'message' => 'Please Select a Contact'
          ))
      ));
      $this->add($contactname);


      $relationship_type = new Text("relationship");
      $relationship_type->setLabel("Relationship Type");
      // $relationship_type->setFilters(array('striptags', 'string'));
      $relationship_type->addValidators(array(
          new PresenceOf(array(
              'message' => 'Relationship type is required'
          ))
      ));
      $this->add($relationship_type);

    }
}
