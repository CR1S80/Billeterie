<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190607232652 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer ADD visit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E0975FA0FF2 FOREIGN KEY (visit_id) REFERENCES visit (id)');
        $this->addSql('CREATE INDEX IDX_81398E0975FA0FF2 ON customer (visit_id)');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE9399395C3F3');
        $this->addSql('DROP INDEX UNIQ_437EE9399395C3F3 ON visit');
        $this->addSql('ALTER TABLE visit DROP customer_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E0975FA0FF2');
        $this->addSql('DROP INDEX IDX_81398E0975FA0FF2 ON customer');
        $this->addSql('ALTER TABLE customer DROP visit_id');
        $this->addSql('ALTER TABLE visit ADD customer_id INT NOT NULL');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE9399395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_437EE9399395C3F3 ON visit (customer_id)');
    }
}
