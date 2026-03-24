<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260322143929 extends AbstractMigration
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
        $this->addSql('CREATE TABLE statistique (id INT AUTO_INCREMENT NOT NULL, annee INT NOT NULL, taux_chomage DOUBLE PRECISION NOT NULL, taux_pauvrete DOUBLE PRECISION NOT NULL, taux_logement_individuels DOUBLE PRECISION NOT NULL, moins_20ans DOUBLE PRECISION NOT NULL, plus_60ans DOUBLE PRECISION NOT NULL, departement_code VARCHAR(10) NOT NULL, INDEX IDX_73A038AD6A333750 (departement_code), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B63AEB327AF FOREIGN KEY (region_code) REFERENCES region (code_region)');
        $this->addSql('ALTER TABLE statistique ADD CONSTRAINT FK_73A038AD6A333750 FOREIGN KEY (departement_code) REFERENCES departement (code_departement)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B63AEB327AF');
        $this->addSql('ALTER TABLE statistique DROP FOREIGN KEY FK_73A038AD6A333750');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE statistique');
    }
}
