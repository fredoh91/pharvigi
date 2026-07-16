<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260715200344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produits (id INT AUTO_INCREMENT NOT NULL, denomination VARCHAR(255) DEFAULT NULL, dci VARCHAR(255) DEFAULT NULL, dosage VARCHAR(255) DEFAULT NULL, voie VARCHAR(255) DEFAULT NULL, code_atc VARCHAR(255) DEFAULT NULL, lib_atc VARCHAR(255) DEFAULT NULL, type_procedure VARCHAR(255) DEFAULT NULL, code_cis VARCHAR(255) DEFAULT NULL, code_vu VARCHAR(255) DEFAULT NULL, code_dossier VARCHAR(255) DEFAULT NULL, nom_vu VARCHAR(255) DEFAULT NULL, codex TINYINT DEFAULT NULL, laboratoire VARCHAR(255) DEFAULT NULL, id_laboratoire VARCHAR(255) DEFAULT NULL, adresse_contact VARCHAR(255) DEFAULT NULL, adresse_compl VARCHAR(255) DEFAULT NULL, code_post VARCHAR(255) DEFAULT NULL, nom_ville VARCHAR(255) DEFAULT NULL, tel_contact VARCHAR(255) DEFAULT NULL, fax_contact VARCHAR(255) DEFAULT NULL, dbo_pays_lib_abr VARCHAR(255) DEFAULT NULL, titulaire VARCHAR(255) DEFAULT NULL, id_titulaire VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, adresse_compl_expl VARCHAR(255) DEFAULT NULL, code_post_expl VARCHAR(255) DEFAULT NULL, nom_ville_expl VARCHAR(255) DEFAULT NULL, complement VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, fax VARCHAR(255) DEFAULT NULL, medic_acces_libre TINYINT DEFAULT NULL, prescription_delivrance LONGTEXT DEFAULT NULL, statut_actif_specialite VARCHAR(255) DEFAULT NULL, user_create VARCHAR(255) DEFAULT NULL, user_modif VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, nom_produit VARCHAR(255) DEFAULT NULL, type_substance VARCHAR(10) DEFAULT NULL, product_family VARCHAR(170) DEFAULT NULL, top_product_name VARCHAR(10) DEFAULT NULL, unii_id VARCHAR(200) DEFAULT NULL, cas_id VARCHAR(200) DEFAULT NULL, cas_pv_id INT DEFAULT NULL, INDEX IDX_BE2DDF8C91787AD3 (cas_pv_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE produits_bnpv (id INT AUTO_INCREMENT NOT NULL, master_id INT DEFAULT NULL, dlp_version INT DEFAULT NULL, product_characterization VARCHAR(255) DEFAULT NULL, product_name VARCHAR(255) DEFAULT NULL, nbblock INT DEFAULT NULL, substance_name VARCHAR(255) DEFAULT NULL, product_indication VARCHAR(255) DEFAULT NULL, nbblock2 INT DEFAULT NULL, user_create VARCHAR(255) DEFAULT NULL, user_modif VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, cas_pv_id INT DEFAULT NULL, INDEX IDX_79AC798391787AD3 (cas_pv_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C91787AD3 FOREIGN KEY (cas_pv_id) REFERENCES cas_pv (id)');
        $this->addSql('ALTER TABLE produits_bnpv ADD CONSTRAINT FK_79AC798391787AD3 FOREIGN KEY (cas_pv_id) REFERENCES cas_pv (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C91787AD3');
        $this->addSql('ALTER TABLE produits_bnpv DROP FOREIGN KEY FK_79AC798391787AD3');
        $this->addSql('DROP TABLE produits');
        $this->addSql('DROP TABLE produits_bnpv');
    }
}
