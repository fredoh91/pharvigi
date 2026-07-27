<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260727172932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cas_pv ADD avis_experts LONGTEXT DEFAULT NULL, ADD point_de_discussion LONGTEXT DEFAULT NULL, ADD nb_votant INT DEFAULT NULL, ADD abstention LONGTEXT DEFAULT NULL, ADD avis_defavorables LONGTEXT DEFAULT NULL, ADD avis_favorables LONGTEXT DEFAULT NULL, ADD mmr_experts LONGTEXT DEFAULT NULL, ADD action_surv_experts LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cas_pv DROP avis_experts, DROP point_de_discussion, DROP nb_votant, DROP abstention, DROP avis_defavorables, DROP avis_favorables, DROP mmr_experts, DROP action_surv_experts');
    }
}
