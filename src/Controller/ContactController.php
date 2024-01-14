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
        $sql = "SELECT mail.*, contacts.* FROM mail_contacts mail JOIN mail_contact_contacts mee ON mail.id = mee.mail_contact_id JOIN contacts ON mee.mail_contact_id = contacts.id";

        $resultSet = $this->connection->executeQuery($sql);

        $results = $resultSet->fetchAllAssociative();

    
        return $this->render('contact/email.html.twig', [
            'results' => $results,
        ]);
    }

}
