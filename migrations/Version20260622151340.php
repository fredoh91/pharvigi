<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260622151340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE donnees_complementaires_emm (id INT AUTO_INCREMENT NOT NULL, em_err_averee TINYINT DEFAULT NULL, em_err_potentielle TINYINT DEFAULT NULL, em_risque_err TINYINT DEFAULT NULL, etape_ini_prescription TINYINT DEFAULT NULL, etape_ini_delivrance TINYINT DEFAULT NULL, etape_ini_admini TINYINT DEFAULT NULL, etape_ini_prepa TINYINT DEFAULT NULL, etape_ini_na_risque_err TINYINT DEFAULT NULL, cause_em_simi_deno_com TINYINT DEFAULT NULL, cause_em_simi_comprime TINYINT DEFAULT NULL, cause_em_simi_cond_prim TINYINT DEFAULT NULL, cause_em_simi_cond_ext TINYINT DEFAULT NULL, cause_em_manque_lisi TINYINT DEFAULT NULL, cause_em_info_manquante TINYINT DEFAULT NULL, cause_em_pres_inadap TINYINT DEFAULT NULL, cause_em_autre TINYINT DEFAULT NULL, cause_em_autre_comment LONGTEXT DEFAULT NULL, conse_em_a_conduit_ei TINYINT DEFAULT NULL, conse_em_aurait_pu_conduire_ei TINYINT DEFAULT NULL, crit_ana_risq_prob_recu TINYINT DEFAULT NULL, crit_ana_risq_cluster TINYINT DEFAULT NULL, crit_ana_risq_emenfant TINYINT DEFAULT NULL, crit_ana_risq_usage_parti TINYINT DEFAULT NULL, crit_ana_risq_context_media TINYINT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE donnees_complementaires_simad (id INT AUTO_INCREMENT NOT NULL, ei_attendu TINYINT DEFAULT NULL, ei_inattendu TINYINT DEFAULT NULL, plausibilite_pharma TINYINT DEFAULT NULL, tab_clini_inhab TINYINT DEFAULT NULL, tab_clini_inhab_comment LONGTEXT DEFAULT NULL, chrono_evo TINYINT DEFAULT NULL, semio_evo TINYINT DEFAULT NULL, semio_evo_comment LONGTEXT DEFAULT NULL, contex_prise_medic TINYINT DEFAULT NULL, contex_prise_medic_comment LONGTEXT DEFAULT NULL, seul_medic_susp TINYINT DEFAULT NULL, risque_recu TINYINT DEFAULT NULL, risque_recu_comment LONGTEXT DEFAULT NULL, autre_cas_bnpv TINYINT DEFAULT NULL, autre_cas_bnpv_comment LONGTEXT DEFAULT NULL, autre_cas_vigylise TINYINT DEFAULT NULL, autre_cas_vigylise_comment LONGTEXT DEFAULT NULL, particula_medic TINYINT DEFAULT NULL, particula_medic_comment LONGTEXT DEFAULT NULL, risque_docu_litt TINYINT DEFAULT NULL, risque_docu_litt_comment LONGTEXT DEFAULT NULL, context_media TINYINT DEFAULT NULL, context_media_comment LONGTEXT DEFAULT NULL, persist_prob TINYINT DEFAULT NULL, persist_prob_comment LONGTEXT DEFAULT NULL, asmr_smr TINYINT DEFAULT NULL, asmr_smr_comment LONGTEXT DEFAULT NULL, util_hors_amm_rtu_atu TINYINT DEFAULT NULL, util_hors_amm_rtu_atu_choix LONGTEXT DEFAULT NULL, autre TINYINT DEFAULT NULL, autre_comment LONGTEXT DEFAULT NULL, nouv_subst TINYINT DEFAULT NULL, nouv_subst_comment LONGTEXT DEFAULT NULL, lettre_logigramme VARCHAR(255) DEFAULT NULL, let_logi_a TINYINT DEFAULT NULL, let_logi_b TINYINT DEFAULT NULL, let_logi_c TINYINT DEFAULT NULL, let_logi_d TINYINT DEFAULT NULL, let_logi_e TINYINT DEFAULT NULL, let_logi_f TINYINT DEFAULT NULL, let_logi_g TINYINT DEFAULT NULL, let_logi_h TINYINT DEFAULT NULL, effet_observe LONGTEXT DEFAULT NULL, tab_clin_nouv TINYINT DEFAULT NULL, tab_clin_nouv_comment LONGTEXT DEFAULT NULL, context_particu TINYINT DEFAULT NULL, context_particu_comment LONGTEXT DEFAULT NULL, cluster TINYINT DEFAULT NULL, cluster_comment LONGTEXT DEFAULT NULL, pop_risk TINYINT DEFAULT NULL, pop_risk_comment LONGTEXT DEFAULT NULL, info_complement LONGTEXT DEFAULT NULL, conf_ana TINYINT DEFAULT NULL, conf_ana_comment LONGTEXT DEFAULT NULL, vol_risk TINYINT DEFAULT NULL, vol_risk_comment LONGTEXT DEFAULT NULL, aut_cas_bnpv TINYINT DEFAULT NULL, aut_cas_bnpv_oui_non LONGTEXT DEFAULT NULL, aut_cas_bnpv_comment LONGTEXT DEFAULT NULL, rech_rapp_ann TINYINT DEFAULT NULL, rech_rapp_ann_comment LONGTEXT DEFAULT NULL, context_sensi TINYINT DEFAULT NULL, context_sensi_comment LONGTEXT DEFAULT NULL, persist_prob_mes TINYINT DEFAULT NULL, persist_prob_mes_comment LONGTEXT DEFAULT NULL, sub_assoc_interet TINYINT DEFAULT NULL, sub_assoc_interet_comment LONGTEXT DEFAULT NULL, aut_donnees TINYINT DEFAULT NULL, aut_donnees_comment LONGTEXT DEFAULT NULL, avis_ceip_a TINYINT DEFAULT NULL, avis_ceip_a_comment LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE emm ADD donnees_complementaires_emm_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emm ADD CONSTRAINT FK_520DD8D6CE3E8E8A FOREIGN KEY (donnees_complementaires_emm_id) REFERENCES donnees_complementaires_emm (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_520DD8D6CE3E8E8A ON emm (donnees_complementaires_emm_id)');
        $this->addSql('ALTER TABLE simad ADD donnees_complementaires_simad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE simad ADD CONSTRAINT FK_4848725FFE8BBF7C FOREIGN KEY (donnees_complementaires_simad_id) REFERENCES donnees_complementaires_simad (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4848725FFE8BBF7C ON simad (donnees_complementaires_simad_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE donnees_complementaires_emm');
        $this->addSql('DROP TABLE donnees_complementaires_simad');
        $this->addSql('ALTER TABLE emm DROP FOREIGN KEY FK_520DD8D6CE3E8E8A');
        $this->addSql('DROP INDEX UNIQ_520DD8D6CE3E8E8A ON emm');
        $this->addSql('ALTER TABLE emm DROP donnees_complementaires_emm_id');
        $this->addSql('ALTER TABLE simad DROP FOREIGN KEY FK_4848725FFE8BBF7C');
        $this->addSql('DROP INDEX UNIQ_4848725FFE8BBF7C ON simad');
        $this->addSql('ALTER TABLE simad DROP donnees_complementaires_simad_id');
    }
}
