<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250329222132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation_ordinateur (id INT AUTO_INCREMENT NOT NULL, ordinateur_id INT NOT NULL, utilisateur_id INT NOT NULL, date_reservation DATETIME NOT NULL, INDEX IDX_E7B8216F828317CA (ordinateur_id), INDEX IDX_E7B8216FFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_ordinateur ADD CONSTRAINT FK_E7B8216F828317CA FOREIGN KEY (ordinateur_id) REFERENCES ordinateur (id)');
        $this->addSql('ALTER TABLE reservation_ordinateur ADD CONSTRAINT FK_E7B8216FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_ordinateur DROP FOREIGN KEY FK_E7B8216F828317CA');
        $this->addSql('ALTER TABLE reservation_ordinateur DROP FOREIGN KEY FK_E7B8216FFB88E14F');
        $this->addSql('DROP TABLE reservation_ordinateur');
    }
}
