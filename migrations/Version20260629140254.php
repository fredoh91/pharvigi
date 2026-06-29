<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260629140254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE donnees_complementaires_cm ADD cm_pour_info TINYINT DEFAULT NULL, ADD cm_pour_info_comment LONGTEXT DEFAULT NULL, ADD signal_potentiel TINYINT DEFAULT NULL, ADD signal_potentiel_comment LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE donnees_complementaires_cm DROP cm_pour_info, DROP cm_pour_info_comment, DROP signal_potentiel, DROP signal_potentiel_comment');
    }
}
