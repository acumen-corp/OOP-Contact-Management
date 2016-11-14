<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

/**
* ContactsController
*
* Manage CRUD operations for Contacts
*/

class ContactsController extends ControllerBase
{
	public function initialize()
	{
		$this->tag->setTitle('Manage your Contacts');
		parent::initialize();
	}

	/**
	* Shows the index action
	*/
	public function indexAction()
	{
		// TODO: Fix Birthday star.

		$auth = $this->session->get('auth');

		$this->session->conditions = null;
		$this->view->form = new ContactsForm;

		$numberPage = 1;
		if (!$this->request->isPost()) {
			$numberPage = $this->request->getQuery("page", "int");
		}

		$contacts = Contacts::find('user_id = ' . $auth['id']);

		$paginator = new Paginator(array(
		"data"  => $contacts,
		"limit" => 2,
		"page"  => $numberPage
		));

		$this->view->page = $paginator->getPaginate();

		$birthday_check = date("m/d"); 

		$this->view->setVar("birthday_date", $birthday_check);
	}

	/**
	* Search Contacts based on current criteria
	*/
	public function searchAction()
	{
		$auth = $this->session->get('auth');

		// TODO: If the search field is blank, forward to index.
		// TODO: Persist the search value in the search field.

		$numberPage = 1;
		if ($this->request->isPost()) {
			$data = $this->request->getPost();
			$query = Criteria::fromInput($this->di, "contacts", $data);
			$query->andWhere('user_id = ' . $auth['id']);
			$this->persistent->searchParams = $query->getParams();
		} else {
			$numberPage = $this->request->getQuery("page", "int");
		}

		$parameters = array();
		if ($this->persistent->searchParams) {
			$parameters = $this->persistent->searchParams;
		}

		$contacts = Contacts::find($parameters);
		if (count($contacts) == 0) {
			$this->flash->notice("The search did not find any contacts");

			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "index",
			]
			);
		}

		$paginator = new Paginator(array(
		"data"  => $contacts,
		"limit" => 2,
		"page"  => $numberPage
		));

		$this->view->page = $paginator->getPaginate();
		$this->view->contacts = $contacts;


	}

	/**
	* Shows the form to create a new contact
	*/
	public function newAction()
	{
		$auth = $this->session->get('auth');

		// Send the current contact id to the form so we can save it in the relationship table.
		$this->tag->setDefault('user_id', $auth['id']);

		$this->view->form = new ContactsForm(null, array('edit' => true));
	}

	/**
	* Edits a contact based on its id
	*/
	public function editAction($id)
	{

		if (!$this->request->isPost()) {

			$contact = Contacts::findFirstById($id);
			if (!$contact) {
				$this->flash->error("contact was not found");

				return $this->dispatcher->forward(
				[
				"controller" => "contacts",
				"action"     => "index",
				]
				);
			}
			$this->view->form = new ContactsForm($contact, array('edit' => true));
		}
	}


	/**
	* Edits a contact based on its id
	*/
	public function detailsAction($id)
	{
		// echo 'id = ' . $id . '<br/>';

		$contact = Contacts::findFirstById($id);
		$auth = $this->session->get('auth');
		$vRelationships  = vRelationships::find('contact1_id = ' . $id);

		// Prevent error for invalid contact.
		//   This prevents link jumping with a falsified route.
		if (empty($contact)) {
			$this->flash->error('Invalid Contact detail.');

			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "index"
			]
			);
		}
		// Restrict access to contact if it does not belong to the logged in user.
		//   This prevents link jumping with a falsified route.
		if ($contact->user_id != $auth['id']) {
			$this->flash->error('Invalid Contact detail.');

			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "index"
			]
			);
		}

		// Display the relationships on the page and build an array of existing relationship contact2_ids.
		$existingContact2_ids = array();
		foreach ( $vRelationships as  $relationship) {
			array_push($existingContact2_ids, $relationship->contact2_id);
		}

		// Send the current contact id to the form so we can save it in the relationship table.
		$this->tag->setDefault('contact1_id', $id);
		$this->tag->setDefault('user_id', $id);

		// Send contact1_id so we can filter the edited user from the available contacts list for the relationship.
		// Send existingContact2_ids so we can filter the currently related contacts.
		$this->view->form  = new RelationshipForm(null, [
		'details' => true,
		'user_id' => $auth['id'],
		'contact1_id' => $id,
		'existingContact2_ids' => $existingContact2_ids
		]);

		$this->view->contact = $contact;
		$this->view->relationships = $vRelationships;
	}

	/**
	* Creates a new relationship
	*/
	public function createrelationshipAction()
	{
		$auth = $this->session->get('auth');
		$data = $this->request->getPost();


		if (!$this->request->isPost()) {
			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "index",
			]
			);
		}

		$form  = new RelationshipForm(null, [
		'details' => true,
		'user_id' => $auth['id'],
		'contact1_id' => $data['contact1_id']
		// 'existingContact2_ids' => $existingContact2_ids
		]);

		$relationship = new Relationships();

		if (!$form->isValid($data, $relationship)) {
			foreach ($form->getMessages() as $message) {
				$this->flash->error($message);
			}

			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			// "action"     => "index"
			"action"     => "details",
			"params" => [$data['contact1_id']]
			]
			);
		}


		// Send the current contact id to the form so we can save it in the relationship table.
		$this->tag->setDefault('contact1_id', $auth['id']);
		$this->tag->setDefault('user_id',  $auth['id']);

		// Prevent duplicates from Resubmit (browser reload on the form post result page)
		$dupRelationship = Relationships::find('contact1_id = ' . $data['contact1_id'] . ' and contact2_id = ' . $data['contact2_id']);
		if (count($dupRelationship) > 0) {
			$this->flash->error('Relationship already exists.');

			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "details",
			"params" => [$data['contact1_id']]
			]
			);
		}

		if ($relationship->save() == false) {
			foreach ($relationship->getMessages() as $message) {
				$this->flash->error($message);
			}

			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "details",
			"params" => [$data['contact1_id']]
			]
			);
		}

		$form->clear();

		$this->flash->success("Relationship was created successfully");

		return $this->dispatcher->forward(
		[
		"controller" => "contacts",
		"action"     => "details",
		"params" => [$data['contact1_id']]
		]
		);
	}

	public function deleteRelationshipAction($relationshipID, $contact1_id) {
		$relationship  = Relationships::findFirstById($relationshipID);

		if (!empty($relationship)) {
			if (!$relationship->delete()) {
				foreach ($contacts->getMessages() as $message) {
					$this->flash->error($message);
				}
			}
		}
		return $this->dispatcher->forward(
		[
		"controller" => "contacts",
		"action"     => "details",
		"params" => [$contact1_id]
		]
		);
	}

	/**
	* Creates a new contact
	*/
	public function createAction()
	{
		$auth = $this->session->get('auth');

		if (!$this->request->isPost()) {
			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "index",
			]
			);
		}

		$form = new ContactsForm;
		$contact = new Contacts();

		$data = $this->request->getPost();
		if (!$form->isValid($data, $contact)) {
			foreach ($form->getMessages() as $message) {
				$this->flash->error($message);
			}

			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "new",
			]
			);
		}

		// Prevent duplicates from Resubmit (browser reload on the form post result page)
		$dupContact = Contacts::find('user_id = ' . $auth['id'] . ' and name = \'' . $data['name'] . '\'');
		if (count($dupContact) > 0) {
			$this->flash->error('Contact name already exists.');

			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "new",
			]
			);
		}

		if ($contact->save() == false) {
			foreach ($contact->getMessages() as $message) {
				$this->flash->error($message);
			}

			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "new",
			]
			);
		}

		$form->clear();

		$this->flash->success("contact was created successfully");

		return $this->dispatcher->forward(
		[
		"controller" => "contacts",
		"action"     => "index",
		]
		);
	}

	/**
	* Saves current contact in screen
	*
	* @param string $id
	*/
	public function saveAction()
	{

		if (!$this->request->isPost()) {
			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "index",
			]
			);
		}

		$id = $this->request->getPost("id", "int");
		$contact = Contacts::findFirstById($id);
		if (!$contact) {
			$this->flash->error("contact does not exist");

			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "index",
			]
			);
		}

		$form = new ContactsForm;

		$data = $this->request->getPost();
		if (!$form->isValid($data, $contact)) {
			foreach ($form->getMessages() as $message) {
				$this->flash->error($message);
			}

			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "new",
			]
			);
		}

		if ($contact->save() == false) {
			foreach ($contact->getMessages() as $message) {
				$this->flash->error($message);
			}

			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "new",
			]
			);
		}

		$form->clear();

		$this->flash->success("contact was updated successfully");

		return $this->dispatcher->forward(
		[
		"controller" => "contacts",
		"action"     => "index",
		]
		);
	}

	/**
	* Deletes a contact
	*
	* @param string $id
	*/
	public function deleteAction($id)
	{

		$contacts = Contacts::findFirstById($id);
		if (!$contacts) {
			$this->flash->error("contact was not found");

			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "index",
			]
			);
		}

		if (!$contacts->delete()) {
			foreach ($contacts->getMessages() as $message) {
				$this->flash->error($message);
			}

			return $this->dispatcher->forward(
			[
			"controller" => "contacts",
			"action"     => "search",
			]
			);
		}

		$this->flash->success("contact was deleted");

		return $this->dispatcher->forward(
		[
		"controller" => "contacts",
		"action"     => "index",
		]
		);
	}
	/**
	* Saves current relationship in screen
	*
	* @param string $id
	*/
	public function relationshipsaveAction()
	{


	}

}
