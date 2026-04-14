<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260410225158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribution_cspcas_pv (id INT AUTO_INCREMENT NOT NULL, user_create VARCHAR(255) DEFAULT NULL, user_modif VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, liste_csp_id INT DEFAULT NULL, cas_pv_id INT DEFAULT NULL, INDEX IDX_9B2DBE08429E8FCD (liste_csp_id), INDEX IDX_9B2DBE0891787AD3 (cas_pv_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE attribution_experts (id INT AUTO_INCREMENT NOT NULL, user_create VARCHAR(255) DEFAULT NULL, user_modif VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, liste_experts_id INT DEFAULT NULL, attribution_cspcas_pv_id INT DEFAULT NULL, INDEX IDX_3F99E4D15239505E (liste_experts_id), INDEX IDX_3F99E4D157CB4B50 (attribution_cspcas_pv_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE cas_pv (id INT AUTO_INCREMENT NOT NULL, type_cas_pv VARCHAR(50) DEFAULT NULL, numero_bnpv VARCHAR(20) DEFAULT NULL, problematique LONGTEXT DEFAULT NULL, proposition_crpv LONGTEXT DEFAULT NULL, conclusions LONGTEXT DEFAULT NULL, presentation VARCHAR(50) DEFAULT NULL, crpv VARCHAR(50) DEFAULT NULL, code_crpv VARCHAR(10) DEFAULT NULL, gravite VARCHAR(10) DEFAULT NULL, deces VARCHAR(10) DEFAULT NULL, mise_en_jeu_pronostic VARCHAR(10) DEFAULT NULL, hospitalisation VARCHAR(10) DEFAULT NULL, incapacite VARCHAR(10) DEFAULT NULL, anomalie_congenitale VARCHAR(10) DEFAULT NULL, autre_situation VARCHAR(10) DEFAULT NULL, typologie VARCHAR(50) DEFAULT NULL, date_arrivee DATE DEFAULT NULL, age INT DEFAULT NULL, sexe VARCHAR(15) DEFAULT NULL, unite_age VARCHAR(10) DEFAULT NULL, effet_indesirable VARCHAR(255) DEFAULT NULL, prequalification_dsurv VARCHAR(100) DEFAULT NULL, motif_prequalification LONGTEXT DEFAULT NULL, investigation_dp LONGTEXT DEFAULT NULL, echange_dmm_crpv LONGTEXT DEFAULT NULL, cluster TINYINT DEFAULT NULL, finalise TINYINT DEFAULT NULL, cas_pere TINYINT DEFAULT NULL, lettre VARCHAR(2) DEFAULT NULL, motif_qualification_dmm LONGTEXT DEFAULT NULL, sre TINYINT DEFAULT NULL, user_create VARCHAR(255) DEFAULT NULL, user_modif VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, niveau_risque_final VARCHAR(255) DEFAULT NULL, niveau_risque_pgs VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE cm (avis_crpv VARCHAR(50) DEFAULT NULL, motif_non_presentation LONGTEXT DEFAULT NULL, suivi_enquete VARCHAR(50) DEFAULT NULL, liste_crpv VARCHAR(255) DEFAULT NULL, maitrise_risque_commentaire LONGTEXT DEFAULT NULL, donnees_complementaires_cm_id INT DEFAULT NULL, id INT NOT NULL, UNIQUE INDEX UNIQ_3C0A377EF024CA3 (donnees_complementaires_cm_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE donnees_complementaires_cm (id INT AUTO_INCREMENT NOT NULL, ei_attendu TINYINT DEFAULT NULL, ei_inattendu TINYINT DEFAULT NULL, plausibilite_pharma TINYINT DEFAULT NULL, tab_clini_inhab TINYINT DEFAULT NULL, tab_clini_inhab_comment LONGTEXT DEFAULT NULL, chrono_evo TINYINT DEFAULT NULL, semio_evo TINYINT DEFAULT NULL, semio_evo_comment LONGTEXT DEFAULT NULL, contex_prise_medic TINYINT DEFAULT NULL, contex_prise_medic_comment LONGTEXT DEFAULT NULL, seul_medic_susp TINYINT DEFAULT NULL, risque_recu TINYINT DEFAULT NULL, risque_recu_comment LONGTEXT DEFAULT NULL, autre_cas_bnpv TINYINT DEFAULT NULL, autre_cas_bnpv_comment LONGTEXT DEFAULT NULL, autre_cas_vigylise TINYINT DEFAULT NULL, autre_cas_vigylise_comment LONGTEXT DEFAULT NULL, particula_medic TINYINT DEFAULT NULL, particula_medic_comment LONGTEXT DEFAULT NULL, risque_docu_litt TINYINT DEFAULT NULL, risque_docu_litt_comment LONGTEXT DEFAULT NULL, context_media TINYINT DEFAULT NULL, context_media_comment LONGTEXT DEFAULT NULL, persist_prob TINYINT DEFAULT NULL, persist_prob_comment LONGTEXT DEFAULT NULL, asmr_smr TINYINT DEFAULT NULL, asmr_smr_comment LONGTEXT DEFAULT NULL, util_hors_amm_rtu_atu TINYINT DEFAULT NULL, util_hors_amm_rtu_atu_choix LONGTEXT DEFAULT NULL, autre TINYINT DEFAULT NULL, autre_comment LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE emm (avis_crpv VARCHAR(50) DEFAULT NULL, motif_non_presentation LONGTEXT DEFAULT NULL, suivi_enquete VARCHAR(50) DEFAULT NULL, liste_crpv VARCHAR(255) DEFAULT NULL, maitrise_risque_commentaire LONGTEXT DEFAULT NULL, id INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE liste_csp (id INT AUTO_INCREMENT NOT NULL, date_csp DATE DEFAULT NULL, type_csp VARCHAR(255) DEFAULT NULL, fl_inactive TINYINT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE liste_experts (id INT AUTO_INCREMENT NOT NULL, num_binome INT DEFAULT NULL, civilite VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, type_expert VARCHAR(255) DEFAULT NULL, date_debut_nomination DATE DEFAULT NULL, date_fin_nomination DATE DEFAULT NULL, date_dpi DATE DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE simad (cas_import_depuis_excel TINYINT DEFAULT NULL, divas TINYINT DEFAULT NULL, date_evenement VARCHAR(255) DEFAULT NULL, date_notification VARCHAR(255) DEFAULT NULL, id INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE attribution_cspcas_pv ADD CONSTRAINT FK_9B2DBE08429E8FCD FOREIGN KEY (liste_csp_id) REFERENCES liste_csp (id)');
        $this->addSql('ALTER TABLE attribution_cspcas_pv ADD CONSTRAINT FK_9B2DBE0891787AD3 FOREIGN KEY (cas_pv_id) REFERENCES cas_pv (id)');
        $this->addSql('ALTER TABLE attribution_experts ADD CONSTRAINT FK_3F99E4D15239505E FOREIGN KEY (liste_experts_id) REFERENCES liste_experts (id)');
        $this->addSql('ALTER TABLE attribution_experts ADD CONSTRAINT FK_3F99E4D157CB4B50 FOREIGN KEY (attribution_cspcas_pv_id) REFERENCES attribution_cspcas_pv (id)');
        $this->addSql('ALTER TABLE cm ADD CONSTRAINT FK_3C0A377EF024CA3 FOREIGN KEY (donnees_complementaires_cm_id) REFERENCES donnees_complementaires_cm (id)');
        $this->addSql('ALTER TABLE cm ADD CONSTRAINT FK_3C0A377EBF396750 FOREIGN KEY (id) REFERENCES cas_pv (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emm ADD CONSTRAINT FK_520DD8D6BF396750 FOREIGN KEY (id) REFERENCES cas_pv (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE simad ADD CONSTRAINT FK_4848725FBF396750 FOREIGN KEY (id) REFERENCES cas_pv (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribution_cspcas_pv DROP FOREIGN KEY FK_9B2DBE08429E8FCD');
        $this->addSql('ALTER TABLE attribution_cspcas_pv DROP FOREIGN KEY FK_9B2DBE0891787AD3');
        $this->addSql('ALTER TABLE attribution_experts DROP FOREIGN KEY FK_3F99E4D15239505E');
        $this->addSql('ALTER TABLE attribution_experts DROP FOREIGN KEY FK_3F99E4D157CB4B50');
        $this->addSql('ALTER TABLE cm DROP FOREIGN KEY FK_3C0A377EF024CA3');
        $this->addSql('ALTER TABLE cm DROP FOREIGN KEY FK_3C0A377EBF396750');
        $this->addSql('ALTER TABLE emm DROP FOREIGN KEY FK_520DD8D6BF396750');
        $this->addSql('ALTER TABLE simad DROP FOREIGN KEY FK_4848725FBF396750');
        $this->addSql('DROP TABLE attribution_cspcas_pv');
        $this->addSql('DROP TABLE attribution_experts');
        $this->addSql('DROP TABLE cas_pv');
        $this->addSql('DROP TABLE cm');
        $this->addSql('DROP TABLE donnees_complementaires_cm');
        $this->addSql('DROP TABLE emm');
        $this->addSql('DROP TABLE liste_csp');
        $this->addSql('DROP TABLE liste_experts');
        $this->addSql('DROP TABLE simad');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
