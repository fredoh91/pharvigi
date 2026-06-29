<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260629092858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE donnees_aanonymiser (id INT AUTO_INCREMENT NOT NULL, entite VARCHAR(255) DEFAULT NULL, champ VARCHAR(255) DEFAULT NULL, texte_complet LONGTEXT DEFAULT NULL, text_aanonymiser VARCHAR(255) DEFAULT NULL, cas_pv_id INT DEFAULT NULL, INDEX IDX_4047DE8E91787AD3 (cas_pv_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE donnees_aanonymiser ADD CONSTRAINT FK_4047DE8E91787AD3 FOREIGN KEY (cas_pv_id) REFERENCES cas_pv (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE donnees_aanonymiser DROP FOREIGN KEY FK_4047DE8E91787AD3');
        $this->addSql('DROP TABLE donnees_aanonymiser');
    }
}
