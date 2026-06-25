<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260625154539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE statut_cas_pv (id INT AUTO_INCREMENT NOT NULL, lib_statut VARCHAR(255) DEFAULT NULL, date_mise_en_place DATE DEFAULT NULL, date_desactivation DATE DEFAULT NULL, statut_actif TINYINT DEFAULT NULL, user_create VARCHAR(255) DEFAULT NULL, user_modif VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, statut_cas_pv_id INT DEFAULT NULL, INDEX IDX_A44CE8FE30D6EF11 (statut_cas_pv_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE statut_cas_pv ADD CONSTRAINT FK_A44CE8FE30D6EF11 FOREIGN KEY (statut_cas_pv_id) REFERENCES cas_pv (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE statut_cas_pv DROP FOREIGN KEY FK_A44CE8FE30D6EF11');
        $this->addSql('DROP TABLE statut_cas_pv');
    }
}
