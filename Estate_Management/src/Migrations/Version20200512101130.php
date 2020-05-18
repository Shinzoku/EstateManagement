<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200512101130 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, biens_id INT NOT NULL, emails VARCHAR(255) NOT NULL, objets VARCHAR(255) NOT NULL, demandes TEXT(1000) NOT NULL, activate TINYINT(1) NOT NULL, date_add DATETIME NOT NULL, date_update DATETIME NOT NULL, date_delete DATETIME DEFAULT NULL, INDEX IDX_DB021E967773350C (biens_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E967773350C FOREIGN KEY (biens_id) REFERENCES biens (id)');
        $this->addSql('ALTER TABLE adresses CHANGE date_delete date_delete DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE locataires CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE date_delete date_delete DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE biens CHANGE locataires_id locataires_id INT DEFAULT NULL, CHANGE date_delete date_delete DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE historique_locations CHANGE date_delete date_delete DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE images CHANGE biens_id biens_id INT DEFAULT NULL, CHANGE alt alt VARCHAR(255) DEFAULT NULL, CHANGE width width VARCHAR(255) DEFAULT NULL, CHANGE height height VARCHAR(255) DEFAULT NULL, CHANGE date_delete date_delete DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE reset_password_request CHANGE user_id user_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE messages');
        $this->addSql('ALTER TABLE adresses CHANGE date_delete date_delete DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE biens CHANGE locataires_id locataires_id INT DEFAULT NULL, CHANGE date_delete date_delete DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE historique_locations CHANGE date_delete date_delete DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE images CHANGE biens_id biens_id INT DEFAULT NULL, CHANGE alt alt VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE width width VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE height height VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE date_delete date_delete DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE locataires CHANGE password password VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE date_delete date_delete DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE reset_password_request CHANGE user_id user_id INT DEFAULT NULL');
    }
}
