<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331133313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE jeux (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, max_places INT NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_jeux (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, jeux_id INT NOT NULL, start_time DATETIME NOT NULL, endtime DATETIME NOT NULL, nb_joueurs INT NOT NULL, INDEX IDX_216C7865FB88E14F (utilisateur_id), INDEX IDX_216C7865EC2AA9D2 (jeux_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_jeux ADD CONSTRAINT FK_216C7865FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation_jeux ADD CONSTRAINT FK_216C7865EC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_jeux DROP FOREIGN KEY FK_216C7865FB88E14F');
        $this->addSql('ALTER TABLE reservation_jeux DROP FOREIGN KEY FK_216C7865EC2AA9D2');
        $this->addSql('DROP TABLE jeux');
        $this->addSql('DROP TABLE reservation_jeux');
    }
}
