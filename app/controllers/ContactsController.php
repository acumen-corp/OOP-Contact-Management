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
        $this->session->conditions = null;
        $this->view->form = new ContactsForm;

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "contacts", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = array();
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $contacts = Contacts::find();

        $paginator = new Paginator(array(
            "data"  => $contacts,
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
        //$this->view->date = date("m/d/y");



        $short_date = date("m/d/Y");
        list($m, $d, $y) = explode('/', $short_date);
        $result = $m;
        $birthday_check = $result;

        $this->view->setVar("birthday_date", $birthday_check);

    }

    /**
     * Search Contacts based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "contacts", $this->request->getPost());
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
            "limit" => 10,
            "page"  => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
        $this->view->contacts = $contacts;


        // $this->view->date = date('Y', strtotime($date));

    }

    /**
     * Shows the form to create a new contact
     */
    public function newAction()
    {
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


         $contacts = Contacts::find($id);
         $relationships  = Relationships::find();


         foreach ( $contacts as  $contact) {
          echo "
                    <h2>Contact Details</h2>
                    <h1>  $contact->name </h1>
                    <p><strong>Email:</strong>  $contact->email  </p>
                    <p><strong>Phone Number:</strong> $contact->telephone </p>
                    <p><strong>Address:</strong> $contact->address </p>
                    <br>
                    <p><strong>Birthday:</strong> $contact->birthday </p>
               ";

         }
          echo "   <h2>Relationships: </h2>";
          foreach ( $relationships as  $relationship) {
              echo "<p><strong> $relationship->name </strong> ($relationship->relationship)  </p>";
            }
            echo "  <br/> <br />";

            echo  " <div class='delete-contact' ><a href='/contacts/delete/$id'  class='btn btn-danger' onclick='return confirm("Confirm Delete")'><i class='glyphicon glyphicon-remove'></i> Delete Contact</a> </div>";

        if (!$this->request->isPost()) {
          //$this->view->contacts->details = RelationshipTypes::findFirstById($id);

          $contact_relationship = Relationships::find($id);
          $add = new Relationships();
          $add->id = $id;
          $add->save();

            if (!$contact_relationship) {
                $this->flash->error("Contact Relationship was not saved");

                return $this->dispatcher->forward(
                    [
                        "controller" => "contacts",
                        "action"     => "index",
                    ]
                );
            }
          $this->view->form  = new RelationshipForm($contact_relationship, array('details' => true));



        }


      }

      /**
       * Creates a new contact
       */
      public function createrelationshipAction()
      {
          if (!$this->request->isPost()) {
              return $this->dispatcher->forward(
                  [
                      "controller" => "contacts",
                      "action"     => "index",
                  ]
              );
          }

          $form = new RelationshipForm;
          $contact = new Relationships();

          $data = $this->request->getPost();
          if (!$form->isValid($data, $contact)) {
              foreach ($form->getMessages() as $message) {
                  $this->flash->error($message);
              }

              return $this->dispatcher->forward(
                  [
                      "controller" => "contacts",
                      "action"     => "details",
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
                      "action"     => "index",
                  ]
              );
          }

          $form->clear();

          $this->flash->success("Relationship was created successfully");

          return $this->dispatcher->forward(
              [
                  "controller" => "contacts",
                  "action"     => "index",
              ]
          );
      }

    /**
     * Creates a new contact
     */
    public function createAction()
    {
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
