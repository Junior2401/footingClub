<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;

class DashboardController extends AbstractController
{
    #[Route('/dashboard/{id?}', name: 'dashboard')]
    public function index(Connection $connection): Response
    {

        $sql1 = '
            SELECT COUNT(*) AS licence_count FROM licencies ORDER BY id DESC
        ';
        $licencies = $connection->fetchAssociative($sql1);
        //$licencies = $licencies['count'];

        $sql2 = "SELECT COUNT(mail_edu_educateurs.id) AS mail_educateur_count
                    FROM mail_edu_educateurs
                    JOIN mail_edu ON mail_edu_educateurs.mail_edu_id = mail_edu.id
                    JOIN educateurs ON mail_edu_educateurs.educateur_id = educateurs.id
                    JOIN licencies ON educateurs.licencie_id = licencies.id
                    ORDER BY mail_edu.dateEnvoi DESC";

        $emaileducateurs = $connection->fetchAssociative($sql2);


        $sql3 = '
            SELECT COUNT(*)  AS contact_count FROM contacts
            WHERE EXISTS (
                SELECT * 
                FROM licencies 
                WHERE contacts.id = licencies.contact_id
            )
            ORDER BY contacts.id DESC
        ';
        $contacts = $connection->fetchAssociative($sql3);


        $sql4 = "SELECT COUNT(mail_contact_contacts.id) AS mail_contact_count
                FROM mail_contact_contacts
                JOIN mail_contacts ON mail_contact_contacts.mail_contact_id = mail_contacts.id
                JOIN contacts ON mail_contact_contacts.contact_id = contacts.id
                ORDER BY mail_contacts.dateEnvoi DESC";

        $emailcontacts = $connection->fetchAssociative($sql4);        
                
        return $this->render('dashboard/index.html.twig', [
            'licencies' => $licencies,
            'emaileducateurs' => $emaileducateurs,
            'contacts' => $contacts,
            'emailcontacts' => $emailcontacts,
        ]);
    }
}
