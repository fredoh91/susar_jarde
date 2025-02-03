<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203145210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX statusdate_idx ON susar (statusdate)');
        $this->addSql('CREATE INDEX dateEvaluation_idx ON susar (dateEvaluation)');
        $this->addSql('CREATE INDEX dateAiguillage_idx ON susar (dateAiguillage)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX statusdate_idx ON susar');
        $this->addSql('DROP INDEX dateEvaluation_idx ON susar');
        $this->addSql('DROP INDEX dateAiguillage_idx ON susar');
    }
}
