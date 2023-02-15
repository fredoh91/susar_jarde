<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214225845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE EffetsIndesirables (id INT AUTO_INCREMENT NOT NULL, master_id INT NOT NULL, caseid INT NOT NULL, specificcaseid VARCHAR(255) NOT NULL, DLPVersion INT NOT NULL, reactionstartdate DATETIME DEFAULT NULL, reactionmeddrallt VARCHAR(255) DEFAULT NULL, codereactionmeddrallt INT DEFAULT NULL, reactionmeddrapt VARCHAR(255) DEFAULT NULL, codereactionmeddrapt INT DEFAULT NULL, reactionmeddrahlt VARCHAR(255) DEFAULT NULL, codereactionmeddrahlt INT DEFAULT NULL, reactionmeddrahlgt VARCHAR(255) DEFAULT NULL, codereactionmeddrahlgt INT DEFAULT NULL, soc VARCHAR(255) DEFAULT NULL, reactionmeddrasoc INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Medicaments (id INT AUTO_INCREMENT NOT NULL, master_id INT NOT NULL, caseid INT NOT NULL, specificcaseid VARCHAR(255) NOT NULL, DLPVersion INT NOT NULL, productcharacterization VARCHAR(255) NOT NULL, productname VARCHAR(255) DEFAULT NULL, NBBlock INT DEFAULT NULL, substancename VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE EffetsIndesirables');
        $this->addSql('DROP TABLE Medicaments');
    }
}
