<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260628202609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE effets_indesirables (id INT AUTO_INCREMENT NOT NULL, llt_code INT DEFAULT NULL, llt_terme VARCHAR(255) DEFAULT NULL, pt_code INT DEFAULT NULL, pt_terme VARCHAR(255) DEFAULT NULL, hlt_code INT DEFAULT NULL, hlt_terme VARCHAR(255) DEFAULT NULL, hlgt_code INT DEFAULT NULL, hlgt_terme VARCHAR(255) DEFAULT NULL, soc_code INT DEFAULT NULL, soc_terme VARCHAR(255) DEFAULT NULL, med_dra_ver VARCHAR(10) DEFAULT NULL, llt_terme_en VARCHAR(10) DEFAULT NULL, pt_terme_en VARCHAR(10) DEFAULT NULL, hlt_terme_en VARCHAR(10) DEFAULT NULL, hlgt_terme_en VARCHAR(10) DEFAULT NULL, soc_terme_en VARCHAR(10) DEFAULT NULL, cas_pv_id INT DEFAULT NULL, INDEX IDX_6328852291787AD3 (cas_pv_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE effets_indesirables ADD CONSTRAINT FK_6328852291787AD3 FOREIGN KEY (cas_pv_id) REFERENCES cas_pv (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE effets_indesirables DROP FOREIGN KEY FK_6328852291787AD3');
        $this->addSql('DROP TABLE effets_indesirables');
    }
}
