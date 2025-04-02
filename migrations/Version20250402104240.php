<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250402104240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, category VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, enseignant_id INT NOT NULL, matiere VARCHAR(255) NOT NULL, classe VARCHAR(255) NOT NULL, salle VARCHAR(255) NOT NULL, debut DATETIME NOT NULL, fin DATETIME NOT NULL, INDEX IDX_FDCA8C9CE455FCC0 (enseignant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE imprimante (id INT AUTO_INCREMENT NOT NULL, identifiant_unique VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, modele VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, niveau_batterie INT DEFAULT NULL, niveau_encre INT DEFAULT NULL, derniere_interaction DATETIME DEFAULT NULL, salle VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4DF2C3AA545B2B13 (identifiant_unique), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeux (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, max_places INT NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, nom_auteur VARCHAR(255) NOT NULL, prenom_auteur VARCHAR(255) DEFAULT NULL, date_publication DATE NOT NULL, genre VARCHAR(255) NOT NULL, disponible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, entree VARCHAR(255) NOT NULL, plat VARCHAR(255) NOT NULL, dessert VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordinateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, numero_serie VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, localisation VARCHAR(255) NOT NULL, niveau_batterie INT DEFAULT NULL, date_achat DATE DEFAULT NULL, derniere_maintenance DATE DEFAULT NULL, est_en_service TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8712E8DB565B809 (numero_serie), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_42C84955A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_jeux (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, jeux_id INT NOT NULL, start_time DATETIME NOT NULL, endtime DATETIME NOT NULL, nb_joueurs INT NOT NULL, INDEX IDX_216C7865FB88E14F (utilisateur_id), INDEX IDX_216C7865EC2AA9D2 (jeux_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_livre (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, livre_id INT NOT NULL, date_emprunt DATE NOT NULL, date_retour DATE DEFAULT NULL, INDEX IDX_EF1C9F3EFB88E14F (utilisateur_id), INDEX IDX_EF1C9F3E37D925CB (livre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_ordinateur (id INT AUTO_INCREMENT NOT NULL, ordinateur_id INT NOT NULL, utilisateur_id INT NOT NULL, date_reservation DATETIME NOT NULL, INDEX IDX_E7B8216F828317CA (ordinateur_id), INDEX IDX_E7B8216FFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_trottinette (id INT AUTO_INCREMENT NOT NULL, trottinette_id INT NOT NULL, utilisateur_id INT NOT NULL, date_reservation DATETIME NOT NULL, INDEX IDX_88394465F6798F43 (trottinette_id), INDEX IDX_88394465FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_velo (id INT AUTO_INCREMENT NOT NULL, velo_id INT NOT NULL, utilisateur_id INT NOT NULL, date_reservation DATETIME NOT NULL, INDEX IDX_2370BC9DEC6AC5BD (velo_id), INDEX IDX_2370BC9DFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thermostat (id INT AUTO_INCREMENT NOT NULL, identifiant_unique VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, temperature_actuelle DOUBLE PRECISION DEFAULT NULL, temperature_cible DOUBLE PRECISION DEFAULT NULL, mode VARCHAR(255) DEFAULT NULL, connectivite VARCHAR(255) DEFAULT NULL, niveau_batterie INT DEFAULT NULL, derniere_interaction DATETIME DEFAULT NULL, salle VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B69BDDD0545B2B13 (identifiant_unique), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trottinette (id INT AUTO_INCREMENT NOT NULL, identifiant_unique VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, niveau_batterie INT DEFAULT NULL, statut VARCHAR(255) NOT NULL, derniere_interaction DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_44559939545B2B13 (identifiant_unique), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, age INT NOT NULL, sexe VARCHAR(10) NOT NULL, type VARCHAR(20) NOT NULL, photo VARCHAR(255) DEFAULT NULL, niveau INT NOT NULL, points INT NOT NULL, valide VARCHAR(255) NOT NULL, classe VARCHAR(255) DEFAULT NULL, matiere VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_cours (utilisateur_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_1F0877C4FB88E14F (utilisateur_id), INDEX IDX_1F0877C47ECF78B0 (cours_id), PRIMARY KEY(utilisateur_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE velo (id INT AUTO_INCREMENT NOT NULL, identifiant_unique VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, niveau_batterie INT DEFAULT NULL, statut VARCHAR(255) NOT NULL, derniere_interaction DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_354971F5545B2B13 (identifiant_unique), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CE455FCC0 FOREIGN KEY (enseignant_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation_jeux ADD CONSTRAINT FK_216C7865FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation_jeux ADD CONSTRAINT FK_216C7865EC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id)');
        $this->addSql('ALTER TABLE reservation_livre ADD CONSTRAINT FK_EF1C9F3EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation_livre ADD CONSTRAINT FK_EF1C9F3E37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE reservation_ordinateur ADD CONSTRAINT FK_E7B8216F828317CA FOREIGN KEY (ordinateur_id) REFERENCES ordinateur (id)');
        $this->addSql('ALTER TABLE reservation_ordinateur ADD CONSTRAINT FK_E7B8216FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation_trottinette ADD CONSTRAINT FK_88394465F6798F43 FOREIGN KEY (trottinette_id) REFERENCES trottinette (id)');
        $this->addSql('ALTER TABLE reservation_trottinette ADD CONSTRAINT FK_88394465FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation_velo ADD CONSTRAINT FK_2370BC9DEC6AC5BD FOREIGN KEY (velo_id) REFERENCES velo (id)');
        $this->addSql('ALTER TABLE reservation_velo ADD CONSTRAINT FK_2370BC9DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE user_cours ADD CONSTRAINT FK_1F0877C4FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_cours ADD CONSTRAINT FK_1F0877C47ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CE455FCC0');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE reservation_jeux DROP FOREIGN KEY FK_216C7865FB88E14F');
        $this->addSql('ALTER TABLE reservation_jeux DROP FOREIGN KEY FK_216C7865EC2AA9D2');
        $this->addSql('ALTER TABLE reservation_livre DROP FOREIGN KEY FK_EF1C9F3EFB88E14F');
        $this->addSql('ALTER TABLE reservation_livre DROP FOREIGN KEY FK_EF1C9F3E37D925CB');
        $this->addSql('ALTER TABLE reservation_ordinateur DROP FOREIGN KEY FK_E7B8216F828317CA');
        $this->addSql('ALTER TABLE reservation_ordinateur DROP FOREIGN KEY FK_E7B8216FFB88E14F');
        $this->addSql('ALTER TABLE reservation_trottinette DROP FOREIGN KEY FK_88394465F6798F43');
        $this->addSql('ALTER TABLE reservation_trottinette DROP FOREIGN KEY FK_88394465FB88E14F');
        $this->addSql('ALTER TABLE reservation_velo DROP FOREIGN KEY FK_2370BC9DEC6AC5BD');
        $this->addSql('ALTER TABLE reservation_velo DROP FOREIGN KEY FK_2370BC9DFB88E14F');
        $this->addSql('ALTER TABLE user_cours DROP FOREIGN KEY FK_1F0877C4FB88E14F');
        $this->addSql('ALTER TABLE user_cours DROP FOREIGN KEY FK_1F0877C47ECF78B0');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE imprimante');
        $this->addSql('DROP TABLE jeux');
        $this->addSql('DROP TABLE livre');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE ordinateur');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_jeux');
        $this->addSql('DROP TABLE reservation_livre');
        $this->addSql('DROP TABLE reservation_ordinateur');
        $this->addSql('DROP TABLE reservation_trottinette');
        $this->addSql('DROP TABLE reservation_velo');
        $this->addSql('DROP TABLE thermostat');
        $this->addSql('DROP TABLE trottinette');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE user_cours');
        $this->addSql('DROP TABLE velo');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
