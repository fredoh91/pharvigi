<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260714170525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE identifiants_bnpv (id INT AUTO_INCREMENT NOT NULL, master_id INT DEFAULT NULL, dlp_version INT DEFAULT NULL, deleted TINYINT DEFAULT NULL, creation_date_bnpv DATETIME DEFAULT NULL, last_modification_date_bnpv DATETIME DEFAULT NULL, status_date_bnpv DATETIME DEFAULT NULL, user_create VARCHAR(255) DEFAULT NULL, user_modif VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, cas_pv_id INT DEFAULT NULL, INDEX IDX_BE82719B91787AD3 (cas_pv_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE identifiants_bnpv ADD CONSTRAINT FK_BE82719B91787AD3 FOREIGN KEY (cas_pv_id) REFERENCES cas_pv (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE identifiants_bnpv DROP FOREIGN KEY FK_BE82719B91787AD3');
        $this->addSql('DROP TABLE identifiants_bnpv');
    }
}
