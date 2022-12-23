<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221221170011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IntervenantsANSM (id INT AUTO_INCREMENT NOT NULL, DMM_pole VARCHAR(255) NOT NULL, DMM_pole_court VARCHAR(255) NOT NULL, inactif TINYINT(1) NOT NULL, OrdreTri SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE susar ADD intervenantANSM_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE susar ADD CONSTRAINT FK_712A8E5749C25013 FOREIGN KEY (intervenantANSM_id) REFERENCES IntervenantsANSM (id)');
        $this->addSql('CREATE INDEX IDX_712A8E5749C25013 ON susar (intervenantANSM_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Susar DROP FOREIGN KEY FK_712A8E5749C25013');
        $this->addSql('DROP TABLE IntervenantsANSM');
        $this->addSql('DROP INDEX IDX_712A8E5749C25013 ON Susar');
        $this->addSql('ALTER TABLE Susar DROP intervenantANSM_id');
    }
}
