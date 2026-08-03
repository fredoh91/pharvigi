<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260803115248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE donnees_complementaires_cm ADD numero_bnpv VARCHAR(255) DEFAULT NULL, ADD specialite_dci VARCHAR(255) DEFAULT NULL, ADD effets_indesirables VARCHAR(255) DEFAULT NULL, ADD lettre VARCHAR(10) DEFAULT NULL, ADD problematique LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE donnees_complementaires_cm DROP numero_bnpv, DROP specialite_dci, DROP effets_indesirables, DROP lettre, DROP problematique');
    }
}
