<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250814182806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return "Creation des tables correspondant aux entites";
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE campus (id INT AUTO_INCREMENT NOT NULL, ville VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creneau (id INT AUTO_INCREMENT NOT NULL, campus_id INT NOT NULL, jour_semaine_id INT NOT NULL, numero_nom VARCHAR(100) NOT NULL, INDEX IDX_F9668B5FAF5D55E1 (campus_id), INDEX IDX_F9668B5F5DE37D35 (jour_semaine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE foodtruck (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, type_cuisine VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jour_disponible (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, code_php INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, foodtruck_id INT NOT NULL, creneau_reserve_id INT NOT NULL, numero_reservation VARCHAR(100) NOT NULL, date_reservation DATETIME NOT NULL, INDEX IDX_42C84955FD42418B (foodtruck_id), INDEX IDX_42C84955A6729C (creneau_reserve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5FAF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5F5DE37D35 FOREIGN KEY (jour_semaine_id) REFERENCES jour_disponible (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955FD42418B FOREIGN KEY (foodtruck_id) REFERENCES foodtruck (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A6729C FOREIGN KEY (creneau_reserve_id) REFERENCES creneau (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creneau DROP FOREIGN KEY FK_F9668B5FAF5D55E1');
        $this->addSql('ALTER TABLE creneau DROP FOREIGN KEY FK_F9668B5F5DE37D35');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955FD42418B');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A6729C');
        $this->addSql('DROP TABLE campus');
        $this->addSql('DROP TABLE creneau');
        $this->addSql('DROP TABLE foodtruck');
        $this->addSql('DROP TABLE jour_disponible');
        $this->addSql('DROP TABLE reservation');
    }
}
