<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
 use Phalcon\Validation\Validator\StringLength as StringLength;
use Phalcon\Validation\Validator\Regex as Phonereg;


class ContactsForm extends Form
{

    /**
     * Initialize the Contacts form
     */
    public function initialize($entity = null, $options = array())
    {
		// Post the user_id of the current user. This will use the value tagged in the controller.
        $this->add(new Hidden('user_id', $this->session->get('auth')['id'] ));

        if (!isset($options['edit'])) {
            $element = new Text("id");
            $this->add($element->setLabel("Id"));
        } else {
            $this->add(new Hidden("id"));
        }

        $name = new Text("name");
        $name->setLabel("Name");
        $name->setFilters(array('striptags', 'string'));
        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'Name is required'
            ))
        ));
        $this->add($name);

        // Email
        $email = new Text('email');
        $email->setLabel('E-Mail');
        $email->setFilters('email');
        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'E-mail is required'
            )),
            new Email(array(
                'message' => 'E-mail is not valid'
            ))
        ));
        $this->add($email);

        $telephone = new Text("telephone");
        $telephone->setLabel("Phone Number");
        $telephone->setFilters(array('striptags', 'string'));
        $telephone->addValidators(array(
            new Phonereg(array(
				  'pattern' => '/^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/',
                  'message' => 'Phone Number is not valid',
                  'allowEmpty' => true
              ))
        ));
        $this->add($telephone);

        $address = new Text("address");
        $address->setLabel("Address");
        $address->setFilters(array('striptags', 'string'));
        $address->addValidators(array(
            new PresenceOf(array(
                'message' => 'Address is required'
            ))
        ));
        $this->add($address);

        $birthday = new Text("birthday");
        $birthday->setLabel("Birthday");
        $birthday->setFilters(array('striptags', 'string'));
        $birthday->addValidators(array(
            new PresenceOf(array(
                'message' => 'Birthday Date is required'
            ))
        ));
        $this->add($birthday);



    }

}
