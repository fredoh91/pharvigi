<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260626081728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE statut_cas_pv DROP FOREIGN KEY `FK_A44CE8FE30D6EF11`');
        $this->addSql('DROP INDEX IDX_A44CE8FE30D6EF11 ON statut_cas_pv');
        $this->addSql('ALTER TABLE statut_cas_pv CHANGE statut_cas_pv_id cas_pv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE statut_cas_pv ADD CONSTRAINT FK_A44CE8FE91787AD3 FOREIGN KEY (cas_pv_id) REFERENCES cas_pv (id)');
        $this->addSql('CREATE INDEX IDX_A44CE8FE91787AD3 ON statut_cas_pv (cas_pv_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE statut_cas_pv DROP FOREIGN KEY FK_A44CE8FE91787AD3');
        $this->addSql('DROP INDEX IDX_A44CE8FE91787AD3 ON statut_cas_pv');
        $this->addSql('ALTER TABLE statut_cas_pv CHANGE cas_pv_id statut_cas_pv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE statut_cas_pv ADD CONSTRAINT `FK_A44CE8FE30D6EF11` FOREIGN KEY (statut_cas_pv_id) REFERENCES cas_pv (id)');
        $this->addSql('CREATE INDEX IDX_A44CE8FE30D6EF11 ON statut_cas_pv (statut_cas_pv_id)');
    }
}
