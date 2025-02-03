<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203142321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE susar DROP FOREIGN KEY FK_712A8E573AC54F42');
        $this->addSql('ALTER TABLE susar DROP FOREIGN KEY FK_712A8E5749C25013');
        $this->addSql('DROP INDEX idx_712a8e5749c25013 ON susar');
        $this->addSql('CREATE INDEX IDX_B0EBA15349C25013 ON susar (intervenantANSM_id)');
        $this->addSql('DROP INDEX idx_712a8e573ac54f42 ON susar');
        $this->addSql('CREATE INDEX IDX_B0EBA1533AC54F42 ON susar (MesureAction_id)');
        $this->addSql('ALTER TABLE susar ADD CONSTRAINT FK_712A8E573AC54F42 FOREIGN KEY (MesureAction_id) REFERENCES mesureaction (id)');
        $this->addSql('ALTER TABLE susar ADD CONSTRAINT FK_712A8E5749C25013 FOREIGN KEY (intervenantANSM_id) REFERENCES intervenantsansm (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE susar DROP FOREIGN KEY FK_B0EBA15349C25013');
        $this->addSql('ALTER TABLE susar DROP FOREIGN KEY FK_B0EBA1533AC54F42');
        $this->addSql('DROP INDEX idx_b0eba15349c25013 ON susar');
        $this->addSql('CREATE INDEX IDX_712A8E5749C25013 ON susar (intervenantANSM_id)');
        $this->addSql('DROP INDEX idx_b0eba1533ac54f42 ON susar');
        $this->addSql('CREATE INDEX IDX_712A8E573AC54F42 ON susar (MesureAction_id)');
        $this->addSql('ALTER TABLE susar ADD CONSTRAINT FK_B0EBA15349C25013 FOREIGN KEY (intervenantANSM_id) REFERENCES IntervenantsANSM (id)');
        $this->addSql('ALTER TABLE susar ADD CONSTRAINT FK_B0EBA1533AC54F42 FOREIGN KEY (MesureAction_id) REFERENCES MesureAction (id)');
        $this->addSql('ALTER TABLE User CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');
    }
}
