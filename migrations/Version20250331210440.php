<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331210440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation_trottinette (id INT AUTO_INCREMENT NOT NULL, trottinette_id INT NOT NULL, utilisateur_id INT NOT NULL, date_reservation DATETIME NOT NULL, INDEX IDX_88394465F6798F43 (trottinette_id), INDEX IDX_88394465FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_trottinette ADD CONSTRAINT FK_88394465F6798F43 FOREIGN KEY (trottinette_id) REFERENCES trottinette (id)');
        $this->addSql('ALTER TABLE reservation_trottinette ADD CONSTRAINT FK_88394465FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_trottinette DROP FOREIGN KEY FK_88394465F6798F43');
        $this->addSql('ALTER TABLE reservation_trottinette DROP FOREIGN KEY FK_88394465FB88E14F');
        $this->addSql('DROP TABLE reservation_trottinette');
    }
}
