<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230228125846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE BilanSusar (id INT AUTO_INCREMENT NOT NULL, creationdate DATETIME DEFAULT NULL, NbTotal INT DEFAULT NULL, NbNonAiguille INT DEFAULT NULL, NbAiguille INT DEFAULT NULL, NbNonEvalue INT DEFAULT NULL, NbEvalue INT DEFAULT NULL, dateImport DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE susar ADD dateImport DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE BilanSusar');
        $this->addSql('ALTER TABLE Susar DROP dateImport');
    }
}
