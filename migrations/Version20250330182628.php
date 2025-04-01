<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250330182628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_cours (utilisateur_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_1F0877C4FB88E14F (utilisateur_id), INDEX IDX_1F0877C47ECF78B0 (cours_id), PRIMARY KEY(utilisateur_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_cours ADD CONSTRAINT FK_1F0877C4FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD classe VARCHAR(255) DEFAULT NULL, ADD matiere VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_cours DROP FOREIGN KEY FK_1F0877C4FB88E14F');
        $this->addSql('DROP TABLE user_cours');
        $this->addSql('ALTER TABLE utilisateur DROP classe, DROP matiere');
    }
}
