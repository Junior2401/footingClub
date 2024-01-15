<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends AbstractController
{

    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    #[Route('/contacts', name: 'contacts')]

    public function index(Connection $connection, Request $request): Response
    {

        $id = $request->query->get('id');

        $categories = $connection->fetchAllAssociative('SELECT * FROM categories');

        $sql = '
            SELECT * FROM contacts
            WHERE EXISTS (
                SELECT * 
                FROM licencies 
                WHERE contacts.id = licencies.contact_id
            )
            ORDER BY contacts.id DESC
        ';
        $contacts = $connection->fetchAllAssociative($sql);

        $req = 0;      

        if($id != null){
            $sql = '
            SELECT * FROM contacts
            WHERE EXISTS (
                SELECT * 
                FROM licencies 
                WHERE contacts.id = licencies.contact_id
                AND licencies.categorie_id = :id
            )
            ORDER BY contacts.id DESC
        ';

        $resultSet = $connection->executeQuery($sql, ['id' => $id]);

        $contacts = $resultSet->fetchAllAssociative();

        $req = $id; 
        }
        

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
            'categories' => $categories,
            'req' => $req,
        ]);
    }
    


    #[Route('/contacts/email', name: 'email_contacts')]
    public function email(): Response
    {
        $sql = "SELECT mail_contact_contacts.id AS id, contacts.nom AS nom, contacts.prenom AS prenom, mail_contacts.objet AS objet, mail_contacts.message AS message, mail_contacts.dateEnvoi AS dateEnvoi, contacts.email AS email
                FROM mail_contact_contacts
                JOIN mail_contacts ON mail_contact_contacts.mail_contact_id = mail_contacts.id
                JOIN contacts ON mail_contact_contacts.contact_id = contacts.id
                ORDER BY mail_contacts.dateEnvoi DESC";

        $results = $this->connection->executeQuery($sql)->fetchAllAssociative();
    
        return $this->render('contact/email.html.twig', [
            'results' => $results,
        ]);
    }


    #[Route('/contacts/create', name: 'manage_email_contact', methods: ['GET','POST'])]
    public function create(Request $request): Response
    {

        if ($request->isMethod('POST')) {
            // Récupérer les données du formulaire
            $objet = $request->request->get('objet');
            $message = $request->request->get('message');
            $contactIds = $request->get('contactIds');

            // Insérer le mailEdu dans la table mail_contact
            $sql = 'INSERT INTO mail_contacts (objet, message) VALUES (?, ?)';
            $this->connection->executeUpdate($sql, [$objet, $message]);

            // Récupérer l'ID du dernier enregistrement inséré
            $sql = 'SELECT * FROM mail_contacts ORDER BY id DESC LIMIT 1';
            $mailContactId = $this->connection->executeQuery($sql)->fetchAssociative();

            // Insérer les relations dans la table mail_contact_contact
            foreach ($contactIds as $contact) {
                $sql = 'INSERT INTO mail_contact_contacts (mail_contact_id, contact_id) VALUES (?, ?)';
                $contactr = $this->connection->executeUpdate($sql, [$mailContactId['id'], $contact]);
            }

            $this->addFlash('message', 'Votre message a été envoyé au contacts avec succès.');
            // Redirection ou autre logique après l'insertion
            return $this->redirectToRoute('email_contacts');

        }        
        $sql = "SELECT * 
                FROM contacts";

        $results = $this->connection->executeQuery($sql)->fetchAllAssociative();
        
        return $this->render('contact/create.html.twig', [
            'results' => $results,
        ]);
    }


    #[Route('/contacts/email/show/{id}', name: 'manage_email_show', methods: ['GET'])]
    public function show($id): Response
    {

        $sql = "SELECT mail_contact_contacts.id AS id, contacts.nom AS nom, contacts.prenom AS prenom, mail_contacts.objet AS objet, mail_contacts.message AS message, mail_contacts.dateEnvoi AS dateEnvoi, contacts.email AS email
                FROM mail_contact_contacts
                JOIN mail_contacts ON mail_contact_contacts.mail_contact_id = mail_contacts.id
                JOIN contacts ON mail_contact_contacts.contact_id = contacts.id
                WHERE mail_contact_contacts.id = :id
                ORDER BY mail_contacts.dateEnvoi DESC";

        $params = ['id' => $id];

        $result = $this->connection->executeQuery($sql, $params)->fetchAssociative();
        
        return $this->render('contact/show.html.twig', [
            'result' => $result,
        ]);
    }


    #[Route('/contacts/email/delete/{id}', name: 'manage_email_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, $id): Response
    {
        if ($request->isMethod('POST')) {
            // Récupérer les données du formulaire

            $sql = 'DELETE FROM mail_contact_contacts WHERE id = :id';
            
            $params = ['id'=>$id];
        
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);

            $this->addFlash('message', 'Votre message a été supprimé au contact avec succès.');
            // Redirection ou autre logique après l'insertion
            return $this->redirectToRoute('email_contacts');

        } 

        $sql = "SELECT mail_contact_contacts.id AS id, contacts.nom AS nom, contacts.prenom AS prenom, mail_contacts.objet AS objet, mail_contacts.message AS message, mail_contacts.dateEnvoi AS dateEnvoi, contacts.email AS email
                FROM mail_contact_contacts
                JOIN mail_contacts ON mail_contact_contacts.mail_contact_id = mail_contacts.id
                JOIN contacts ON mail_contact_contacts.contact_id = contacts.id
                WHERE mail_contact_contacts.id = :id
                ORDER BY mail_contacts.dateEnvoi DESC";

        $params = ['id' => $id];

        $result = $this->connection->executeQuery($sql, $params)->fetchAssociative();
        
        return $this->render('contact/delete.html.twig', [
            'result' => $result,
        ]);
    } 
}
