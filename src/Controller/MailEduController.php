<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailEduController extends AbstractController
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    #[Route('/mail/edu', name: 'mail_educateur')]
    public function index(): Response
    {

        $sql = "SELECT mail.*, educateur.* 
                FROM mail_edu mail
                JOIN mail_edu_educateur mee ON mail.id = mee.mail_id
                JOIN educateur ON mee.educateur_id = educateur.id";

        $results = $this->connection->executeQuery($sql)->fetchAllAssociative();

        return $this->render('mail_edu/index.html.twig', [
            'results' => $results,
        ]);
    }


    public function show($id)
    {
        $sql = "SELECT e.id, e.nom, e.prenom FROM email_edu e 
                INNER JOIN mail_edu_educateurs mee ON e.id = mee.educateur_id 
                WHERE mee.mail_id = ?";
        
        $educateurs = $this->connection->executeQuery($sql, [$id])->fetchAll();

        // Faire quelque chose avec les éducateurs récupérés
        // ...

        return $educateurs;
    }

    public function getMailsForEducateur($educateurId)
    {
        $sql = "SELECT m.id, m.date_envoi, m.objet FROM mail_edu m 
                INNER JOIN mail_edu_educateur mee ON m.id = mee.mail_id 
                WHERE mee.educateur_id = ?";
        
        $mails = $this->connection->executeQuery($sql, [$educateurId])->fetchAll();

        // Faire quelque chose avec les mails récupérés
        // ...

        return $mails;
    }

    // Autres méthodes pour gérer la relation

    public function addEducateurToMail($educateurId, $mailId)
    {
        $sql = "INSERT INTO mail_edu_educateur (mail_id, educateur_id) VALUES (?, ?)";
        $this->connection->executeUpdate($sql, [$mailId, $educateurId]);

        // Gérer les cas d'erreur ou d'autres actions après l'ajout
    }

    public function removeEducateurFromMail($educateurId, $mailId)
    {
        $sql = "DELETE FROM mail_edu_educateur WHERE mail_id = ? AND educateur_id = ?";
        $this->connection->executeUpdate($sql, [$mailId, $educateurId]);

        // Gérer les cas d'erreur ou d'autres actions après la suppression
    }
}
