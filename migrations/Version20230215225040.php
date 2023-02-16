<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215225040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE effetsindesirables ADD susar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE effetsindesirables ADD CONSTRAINT FK_BC9482B7887FE331 FOREIGN KEY (susar_id) REFERENCES Susar (id)');
        $this->addSql('CREATE INDEX IDX_BC9482B7887FE331 ON effetsindesirables (susar_id)');
        $this->addSql('ALTER TABLE medicaments ADD susar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE medicaments ADD CONSTRAINT FK_5B04051C887FE331 FOREIGN KEY (susar_id) REFERENCES Susar (id)');
        $this->addSql('CREATE INDEX IDX_5B04051C887FE331 ON medicaments (susar_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE EffetsIndesirables DROP FOREIGN KEY FK_BC9482B7887FE331');
        $this->addSql('DROP INDEX IDX_BC9482B7887FE331 ON EffetsIndesirables');
        $this->addSql('ALTER TABLE EffetsIndesirables DROP susar_id');
        $this->addSql('ALTER TABLE Medicaments DROP FOREIGN KEY FK_5B04051C887FE331');
        $this->addSql('DROP INDEX IDX_5B04051C887FE331 ON Medicaments');
        $this->addSql('ALTER TABLE Medicaments DROP susar_id');
    }
}
