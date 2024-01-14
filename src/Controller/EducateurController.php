<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class EducateurController extends AbstractController
{

    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    #[Route('/educateurs', name: 'educateurs')]
    public function index(): Response
    {
        $sql = "SELECT mail_edu_educateurs.id AS id, licencies.nom AS nom, licencies.prenom AS prenom, mail_edu.objet AS objet, mail_edu.message AS message, mail_edu.dateEnvoi AS dateEnvoi
                FROM mail_edu_educateurs
                JOIN mail_edu ON mail_edu_educateurs.mail_edu_id = mail_edu.id
                JOIN educateurs ON mail_edu_educateurs.educateur_id = educateurs.id
                JOIN licencies ON educateurs.licencie_id = licencies.id
                ORDER BY mail_edu.dateEnvoi DESC";

        $results = $this->connection->executeQuery($sql)->fetchAllAssociative();
    
        return $this->render('educateur/index.html.twig', [
            'results' => $results,
        ]);
    }


    #[Route('/educateurs/create', name: 'manage_email_educateur', methods: ['GET','POST'])]
    public function create(Request $request): Response
    {

        if ($request->isMethod('POST')) {
            // Récupérer les données du formulaire
            $objet = $request->request->get('objet');
            $message = $request->request->get('message');
            $educateurIds = $request->get('educateurIds');

            // Insérer le mailEdu dans la table mail_edu
            $sql = 'INSERT INTO mail_edu (objet, message) VALUES (?, ?)';
            $this->connection->executeUpdate($sql, [$objet, $message]);

            // Récupérer l'ID du dernier enregistrement inséré
            $sql = 'SELECT * FROM mail_edu ORDER BY id DESC LIMIT 1';
            $mailEduId = $this->connection->executeQuery($sql)->fetchAssociative();

            // Insérer les relations dans la table mail_edu_educateur
            foreach ($educateurIds as $educateur) {
                $sql = 'INSERT INTO mail_edu_educateurs (mail_edu_id, educateur_id) VALUES (?, ?)';
                $educateur = $this->connection->executeUpdate($sql, [$mailEduId['id'], $educateur]);
            }

            $this->addFlash('message', 'Votre message a été envoyé avec succès.');
            // Redirection ou autre logique après l'insertion
            return $this->redirectToRoute('educateurs');

        }        
        $sql = "SELECT * 
                FROM educateurs
                JOIN licencies ON licencies.id = educateurs.licencie_id";

        $results = $this->connection->executeQuery($sql)->fetchAllAssociative();
        
        return $this->render('educateur/create.html.twig', [
            'results' => $results,
        ]);
    }


    #[Route('/educateurs/email/show/{id}', name: 'educateurs_email_show', methods: ['GET'])]
    public function show($id): Response
    {

        $sql = "SELECT *
                FROM mail_edu_educateurs
                JOIN mail_edu ON mail_edu_educateurs.mail_edu_id = mail_edu.id
                JOIN educateurs ON mail_edu_educateurs.educateur_id = educateurs.id
                JOIN licencies ON educateurs.licencie_id = licencies.id
                WHERE mail_edu_educateurs.id = :id
                ORDER BY mail_edu.dateEnvoi DESC";

        $params = ['id' => $id];

        $result = $this->connection->executeQuery($sql, $params)->fetchAssociative();
        
        return $this->render('educateur/show.html.twig', [
            'result' => $result,
        ]);
    }


    #[Route('/educateurs/email/delete/{id}', name: 'educateurs_email_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, $id): Response
    {
        if ($request->isMethod('POST')) {
            // Récupérer les données du formulaire

            $sql = 'DELETE FROM mail_edu_educateurs WHERE id = :id';
            
            $params = ['id'=>$id];
        
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);

            $this->addFlash('message', 'Votre message a été supprimé avec succès.');
            // Redirection ou autre logique après l'insertion
            return $this->redirectToRoute('educateurs');

        } 

        $sql = "SELECT mail_edu_educateurs.id AS id, licencies.nom AS nom, licencies.prenom AS prenom, mail_edu.objet AS objet, mail_edu.message AS message, mail_edu.dateEnvoi AS dateEnvoi, educateurs.email AS email
                FROM mail_edu_educateurs
                JOIN mail_edu ON mail_edu_educateurs.mail_edu_id = mail_edu.id
                JOIN educateurs ON mail_edu_educateurs.educateur_id = educateurs.id
                JOIN licencies ON educateurs.licencie_id = licencies.id
                ORDER BY mail_edu.dateEnvoi DESC";

        $params = ['id' => $id];

        $result = $this->connection->executeQuery($sql, $params)->fetchAssociative();
        
        return $this->render('educateur/delete.html.twig', [
            'result' => $result,
        ]);
    }    



}
