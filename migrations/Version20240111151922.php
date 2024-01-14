<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240111151922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE educateurs');
        $this->addSql('DROP TABLE licencies');
        $this->addSql('DROP TABLE mail_contact_contacts');
        $this->addSql('DROP TABLE mail_edu_educateurs');
        $this->addSql('ALTER TABLE mail_contact ADD date_envoi VARCHAR(255) NOT NULL, DROP dateEnvoi, CHANGE message message VARCHAR(1000) NOT NULL');
        $this->addSql('ALTER TABLE mail_edu ADD date_envoi VARCHAR(255) NOT NULL, DROP dateEnvoi, CHANGE message message VARCHAR(1000) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, nom VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX code (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE contacts (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, prenom VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, email VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, telephone VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX email (email, telephone), PRIMARY KEY(id)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE educateurs (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, password VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, role TINYINT(1) NOT NULL, licencie_id INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX licencie_id (licencie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE licencies (id INT AUTO_INCREMENT NOT NULL, licence VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, nom VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, prenom VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, categorie_id INT NOT NULL, contact_id INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX contact_id (contact_id), INDEX categorie_id (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE mail_contact_contacts (id INT AUTO_INCREMENT NOT NULL, mail_contact_id INT NOT NULL, contact_id INT NOT NULL, INDEX contact_id (contact_id), INDEX mail_edu_id (mail_contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE mail_edu_educateurs (id INT AUTO_INCREMENT NOT NULL, mail_edu_id INT NOT NULL, educateur_id INT NOT NULL, INDEX educateur_id (educateur_id), INDEX mail_edu_id (mail_edu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('ALTER TABLE mail_contact ADD dateEnvoi DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP date_envoi, CHANGE message message VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE mail_edu ADD dateEnvoi DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP date_envoi, CHANGE message message VARCHAR(255) NOT NULL');
    }
}
