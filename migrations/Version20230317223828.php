<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230317223828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Indication (id INT AUTO_INCREMENT NOT NULL, susar_id INT DEFAULT NULL, productName VARCHAR(255) DEFAULT NULL, productIndication VARCHAR(255) DEFAULT NULL, productIndication_eng VARCHAR(255) DEFAULT NULL, codeProductIndication INT DEFAULT NULL, INDEX IDX_9E0D6607887FE331 (susar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Indication ADD CONSTRAINT FK_9E0D6607887FE331 FOREIGN KEY (susar_id) REFERENCES Susar (id)');
        $this->addSql('DROP TABLE intervenantsansm_20230317');
        $this->addSql('ALTER TABLE susar ADD NbMedicSuspect INT DEFAULT NULL, ADD patientAgeGroup VARCHAR(255) DEFAULT NULL, ADD patientAge DOUBLE PRECISION DEFAULT NULL, ADD patientAgeUnitLabel VARCHAR(255) DEFAULT NULL, ADD isCaseSerious VARCHAR(255) DEFAULT NULL, ADD seriousnessCriteria VARCHAR(255) DEFAULT NULL, ADD patientSex VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE intervenantsansm_20230317 (id INT AUTO_INCREMENT NOT NULL, DMM_pole VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DMM_pole_court VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, inactif TINYINT(1) NOT NULL, OrdreTri SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE Indication DROP FOREIGN KEY FK_9E0D6607887FE331');
        $this->addSql('DROP TABLE Indication');
        $this->addSql('ALTER TABLE Susar DROP NbMedicSuspect, DROP patientAgeGroup, DROP patientAge, DROP patientAgeUnitLabel, DROP isCaseSerious, DROP seriousnessCriteria, DROP patientSex');
    }
}
