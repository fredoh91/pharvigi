<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260924150417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE analyse_risque (id INT AUTO_INCREMENT NOT NULL, lib_critere_gravite VARCHAR(255) DEFAULT NULL, lib_critere_inhab VARCHAR(255) DEFAULT NULL, lib_type_population VARCHAR(255) DEFAULT NULL, lib_suite_jud VARCHAR(255) DEFAULT NULL, lib_mediatisation VARCHAR(255) DEFAULT NULL, lib_prob_sens_tutelle VARCHAR(255) DEFAULT NULL, lib_prob_sens_partenaires VARCHAR(255) DEFAULT NULL, lib_produit_surveillance VARCHAR(255) DEFAULT NULL, prod_surv_surv_renforcee TINYINT DEFAULT NULL, prod_surv_enquete TINYINT DEFAULT NULL, prod_surv_atu_rtu TINYINT DEFAULT NULL, comment_critere_inhab LONGTEXT DEFAULT NULL, comment_contexte LONGTEXT DEFAULT NULL, comment_produit_surveillance LONGTEXT DEFAULT NULL, lib_population_exposee VARCHAR(255) DEFAULT NULL, comment_population_exposee LONGTEXT DEFAULT NULL, lib_das_bnpv VARCHAR(255) DEFAULT NULL, comment_das_bnpv LONGTEXT DEFAULT NULL, lib_ermr VARCHAR(255) DEFAULT NULL, comment_ermr LONGTEXT DEFAULT NULL, lib_autre_cas VARCHAR(255) DEFAULT NULL, comment_autre_cas LONGTEXT DEFAULT NULL, lib_sig_eu VARCHAR(255) DEFAULT NULL, comment_sig_eu LONGTEXT DEFAULT NULL, comment_general LONGTEXT DEFAULT NULL, user_create VARCHAR(255) DEFAULT NULL, user_modif VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, date_calcul DATETIME DEFAULT NULL, critere_gravite_score INT DEFAULT NULL, critere_gravite_poids INT DEFAULT NULL, car_inhabituel_score INT DEFAULT NULL, car_inhabituel_poids INT DEFAULT NULL, type_population_score INT DEFAULT NULL, type_population_poids INT DEFAULT NULL, suite_jud_score INT DEFAULT NULL, suite_jud_poids INT DEFAULT NULL, mediatisation_score INT DEFAULT NULL, mediatisation_poids INT DEFAULT NULL, prob_sens_tutelle_score INT DEFAULT NULL, prob_sens_tutelle_poids INT DEFAULT NULL, prob_sens_partenaires_score INT DEFAULT NULL, prob_sens_partenaires_poids INT DEFAULT NULL, produit_surveillance_score INT DEFAULT NULL, produit_surveillance_poids INT DEFAULT NULL, population_exposee_score INT DEFAULT NULL, population_exposee_poids INT DEFAULT NULL, dasbnpv_e_rmr_score INT DEFAULT NULL, dasbnpv_e_rmr_poids INT DEFAULT NULL, cm_sig_eu_score INT DEFAULT NULL, cm_sig_eu_poids INT DEFAULT NULL, score_hr INT DEFAULT NULL, niveau_risque_calcule VARCHAR(255) DEFAULT NULL, occurence_em_score INT DEFAULT NULL, occurence_em_poids INT DEFAULT NULL, commentaire_dmm LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE analyse_risque');
    }
}
