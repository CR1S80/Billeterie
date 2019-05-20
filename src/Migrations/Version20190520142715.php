<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190520142715 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visit (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, invoice_date DATE NOT NULL, visit_date DATE NOT NULL, type INT NOT NULL, number_of_ticket INT NOT NULL, total_price INT NOT NULL, booking_id VARCHAR(255) NOT NULL, INDEX IDX_437EE9399395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE9399395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('DROP TABLE booking');
        $this->addSql('ALTER TABLE ticket DROP country, DROP visit_at, CHANGE number_of_ticket visit_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA375FA0FF2 FOREIGN KEY (visit_id) REFERENCES visit (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA375FA0FF2 ON ticket (visit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE9399395C3F3');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA375FA0FF2');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, visit_day DATETIME NOT NULL, email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, booking_id VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE visit');
        $this->addSql('DROP INDEX IDX_97A0ADA375FA0FF2 ON ticket');
        $this->addSql('ALTER TABLE ticket ADD country VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD visit_at DATETIME NOT NULL, CHANGE visit_id number_of_ticket INT NOT NULL');
    }
}
