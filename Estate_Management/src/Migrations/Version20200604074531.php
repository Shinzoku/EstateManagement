<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200604074531 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE biens DROP FOREIGN KEY FK_1F9004DD6E7A3544');
        
        $this->addSql('ALTER TABLE biens DROP locataires_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        
        $this->addSql('ALTER TABLE biens ADD CONSTRAINT FK_1F9004DD6E7A3544 FOREIGN KEY (locataires_id) REFERENCES locataires (id)');
        $this->addSql('CREATE INDEX IDX_1F9004DD6E7A3544 ON biens (locataires_id)');
    }
}
