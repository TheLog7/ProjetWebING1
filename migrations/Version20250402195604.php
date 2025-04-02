<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250402195604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jeux ADD nombre_emprunts INT NOT NULL');
        $this->addSql('ALTER TABLE livre ADD nombre_emprunts INT NOT NULL');
        $this->addSql('ALTER TABLE ordinateur ADD nombre_emprunts INT NOT NULL');
        $this->addSql('ALTER TABLE trottinette ADD nombre_emprunts INT NOT NULL');
        $this->addSql('ALTER TABLE velo ADD nombre_emprunts INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jeux DROP nombre_emprunts');
        $this->addSql('ALTER TABLE livre DROP nombre_emprunts');
        $this->addSql('ALTER TABLE ordinateur DROP nombre_emprunts');
        $this->addSql('ALTER TABLE trottinette DROP nombre_emprunts');
        $this->addSql('ALTER TABLE velo DROP nombre_emprunts');
    }
}
