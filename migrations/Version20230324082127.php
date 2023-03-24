<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230324082127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE MedicalHistory (id INT AUTO_INCREMENT NOT NULL, susar_id INT DEFAULT NULL, disease_lib_LLT VARCHAR(255) DEFAULT NULL, disease_lib_PT VARCHAR(255) DEFAULT NULL, disease_code_LLT INT DEFAULT NULL, disease_code_PT INT DEFAULT NULL, continuing VARCHAR(255) DEFAULT NULL, medicalcomment LONGTEXT DEFAULT NULL, INDEX IDX_B70E6123887FE331 (susar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE MedicalHistory ADD CONSTRAINT FK_B70E6123887FE331 FOREIGN KEY (susar_id) REFERENCES Susar (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE MedicalHistory DROP FOREIGN KEY FK_B70E6123887FE331');
        $this->addSql('DROP TABLE MedicalHistory');
    }
}
