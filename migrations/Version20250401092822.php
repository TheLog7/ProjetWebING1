<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<<< HEAD:migrations/Version20250402060737.php
final class Version20250402060737 extends AbstractMigration
========
final class Version20250401092822 extends AbstractMigration
>>>>>>>> 7db97bbd41a42d331d9969a2a7a16e2db0437203:migrations/Version20250401092822.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20250402060737.php
        $this->addSql('ALTER TABLE article ADD image VARCHAR(255) DEFAULT NULL');
========
        $this->addSql('ALTER TABLE utilisateur CHANGE valide valide VARCHAR(255) NOT NULL');
>>>>>>>> 7db97bbd41a42d331d9969a2a7a16e2db0437203:migrations/Version20250401092822.php
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20250402060737.php
        $this->addSql('ALTER TABLE article DROP image');
========
        $this->addSql('ALTER TABLE utilisateur CHANGE valide valide TINYINT(1) NOT NULL');
>>>>>>>> 7db97bbd41a42d331d9969a2a7a16e2db0437203:migrations/Version20250401092822.php
    }
}
