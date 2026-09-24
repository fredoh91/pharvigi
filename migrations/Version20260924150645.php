<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260924150645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analyse_risque ADD produits_id INT DEFAULT NULL, ADD cas_pv_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE analyse_risque ADD CONSTRAINT FK_C2402FAACD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE analyse_risque ADD CONSTRAINT FK_C2402FAA91787AD3 FOREIGN KEY (cas_pv_id) REFERENCES cas_pv (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C2402FAACD11A2CF ON analyse_risque (produits_id)');
        $this->addSql('CREATE INDEX IDX_C2402FAA91787AD3 ON analyse_risque (cas_pv_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analyse_risque DROP FOREIGN KEY FK_C2402FAACD11A2CF');
        $this->addSql('ALTER TABLE analyse_risque DROP FOREIGN KEY FK_C2402FAA91787AD3');
        $this->addSql('DROP INDEX UNIQ_C2402FAACD11A2CF ON analyse_risque');
        $this->addSql('DROP INDEX IDX_C2402FAA91787AD3 ON analyse_risque');
        $this->addSql('ALTER TABLE analyse_risque DROP produits_id, DROP cas_pv_id');
    }
}
