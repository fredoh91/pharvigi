<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260708155342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_csp ADD date_max_arrivee_mail_crpv_ceip DATE DEFAULT NULL, ADD date_max_prequalif_surv DATE DEFAULT NULL, ADD date_max_qualif_dmm DATE DEFAULT NULL, ADD date_max_securisation_surv DATE DEFAULT NULL, ADD date_envoi_experts DATE DEFAULT NULL, ADD date_max_reception_avis_experts DATE DEFAULT NULL, ADD date_max_import_avis_expert DATE DEFAULT NULL, ADD date_max_prep_planning DATE DEFAULT NULL, ADD date_max_envoi_liste_cas_membres_csp DATE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_csp DROP date_max_arrivee_mail_crpv_ceip, DROP date_max_prequalif_surv, DROP date_max_qualif_dmm, DROP date_max_securisation_surv, DROP date_envoi_experts, DROP date_max_reception_avis_experts, DROP date_max_import_avis_expert, DROP date_max_prep_planning, DROP date_max_envoi_liste_cas_membres_csp');
    }
}
