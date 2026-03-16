<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260313125611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE departement (code_departement VARCHAR(10) NOT NULL, nom_departement VARCHAR(255) NOT NULL, region_code VARCHAR(10) NOT NULL, INDEX IDX_C1765B63AEB327AF (region_code), PRIMARY KEY (code_departement)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE region (code_region VARCHAR(10) NOT NULL, nom_region VARCHAR(255) NOT NULL, PRIMARY KEY (code_region)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B63AEB327AF FOREIGN KEY (region_code) REFERENCES region (code_region)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B63AEB327AF');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE region');
    }
}
