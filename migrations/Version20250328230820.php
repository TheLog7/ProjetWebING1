<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250328230820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation_livre (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, livre_id INT NOT NULL, date_emprunt DATE NOT NULL, date_retour DATE DEFAULT NULL, INDEX IDX_EF1C9F3EFB88E14F (utilisateur_id), INDEX IDX_EF1C9F3E37D925CB (livre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_livre ADD CONSTRAINT FK_EF1C9F3EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation_livre ADD CONSTRAINT FK_EF1C9F3E37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE livre ADD reserve TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_livre DROP FOREIGN KEY FK_EF1C9F3EFB88E14F');
        $this->addSql('ALTER TABLE reservation_livre DROP FOREIGN KEY FK_EF1C9F3E37D925CB');
        $this->addSql('DROP TABLE reservation_livre');
        $this->addSql('ALTER TABLE livre DROP reserve');
    }
}
