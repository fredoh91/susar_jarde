<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230318100450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Indications (id INT AUTO_INCREMENT NOT NULL, susar_id INT DEFAULT NULL, productName VARCHAR(255) DEFAULT NULL, productIndications VARCHAR(255) DEFAULT NULL, productIndications_eng VARCHAR(255) DEFAULT NULL, codeProductIndications INT DEFAULT NULL, INDEX IDX_85F457CE887FE331 (susar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Indications ADD CONSTRAINT FK_85F457CE887FE331 FOREIGN KEY (susar_id) REFERENCES Susar (id)');
        $this->addSql('ALTER TABLE indication DROP FOREIGN KEY FK_9E0D6607887FE331');
        $this->addSql('DROP TABLE indication');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE indication (id INT AUTO_INCREMENT NOT NULL, susar_id INT DEFAULT NULL, productName VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, productIndication VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, productIndication_eng VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, codeProductIndication INT DEFAULT NULL, INDEX IDX_9E0D6607887FE331 (susar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE indication ADD CONSTRAINT FK_9E0D6607887FE331 FOREIGN KEY (susar_id) REFERENCES susar (id)');
        $this->addSql('ALTER TABLE Indications DROP FOREIGN KEY FK_85F457CE887FE331');
        $this->addSql('DROP TABLE Indications');
    }
}
