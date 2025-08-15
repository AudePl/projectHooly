<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250815095358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return "Insertion des donnees dans les tables Campus, JourDisponible, Creneau";
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        //Insertion donnees Campus
        $this->addSql('INSERT INTO campus (ville) VALUES ("Paris"), ("Lyon");');
        
        //Insertion donnees JourDisponible
        $this->addSql('INSERT INTO jour_disponible (nom, code_php) VALUES ("Lundi", 1), ("Mardi", 2), ("Mercredi", 3), ("Jeudi", 4), ("Vendredi", 5);');

        //Insertion donnees Creneau (avec relation)
        $this->addSql('INSERT INTO creneau (numero_nom, campus_id, jour_semaine_id) VALUES
            ("Emplacement A", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Lundi")), 
            ("Emplacement A", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Mardi")), 
            ("Emplacement A", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Mercredi")), 
            ("Emplacement A", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Jeudi")), 
            ("Emplacement A", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Vendredi")), 
            ("Emplacement B", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Lundi")), 
            ("Emplacement B", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Mardi")), 
            ("Emplacement B", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Mercredi")), 
            ("Emplacement B", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Jeudi")), 
            ("Emplacement B", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Vendredi")), 
            ("Emplacement C", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Lundi")), 
            ("Emplacement C", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Mardi")), 
            ("Emplacement C", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Mercredi")), 
            ("Emplacement C", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Jeudi")), 
            ("Emplacement C", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Vendredi")), 
            ("Emplacement D", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Lundi")), 
            ("Emplacement D", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Mardi")), 
            ("Emplacement D", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Mercredi")), 
            ("Emplacement D", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Jeudi")), 
            ("Emplacement D", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Vendredi")), 
            ("Emplacement E", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Mardi")), 
            ("Emplacement E", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Mercredi")), 
            ("Emplacement E", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Jeudi")), 
            ("Emplacement E", (SELECT id FROM campus WHERE ville="Lyon"), (SELECT id FROM jour_disponible WHERE nom="Vendredi")),
            ("Emplacement 1", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Lundi")), 
            ("Emplacement 1", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Mardi")), 
            ("Emplacement 1", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Mercredi")), 
            ("Emplacement 1", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Jeudi")), 
            ("Emplacement 1", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Vendredi")), 
            ("Emplacement 2", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Lundi")), 
            ("Emplacement 2", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Mardi")), 
            ("Emplacement 2", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Mercredi")), 
            ("Emplacement 2", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Jeudi")), 
            ("Emplacement 2", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Vendredi")), 
            ("Emplacement 3", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Lundi")), 
            ("Emplacement 3", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Mardi")), 
            ("Emplacement 3", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Mercredi")), 
            ("Emplacement 3", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Jeudi")), 
            ("Emplacement 3", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Vendredi")), 
            ("Emplacement 4", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Lundi")), 
            ("Emplacement 4", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Mardi")), 
            ("Emplacement 4", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Mercredi")), 
            ("Emplacement 4", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Jeudi")), 
            ("Emplacement 4", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Vendredi")), 
            ("Emplacement 5", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Lundi")), 
            ("Emplacement 5", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Mardi")), 
            ("Emplacement 5", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Mercredi")), 
            ("Emplacement 5", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Jeudi")), 
            ("Emplacement 5", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Vendredi")), 
            ("Emplacement 6", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Lundi")), 
            ("Emplacement 6", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Mardi")), 
            ("Emplacement 6", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Mercredi")), 
            ("Emplacement 6", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Jeudi")), 
            ("Emplacement 6", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Vendredi")), 
            ("Emplacement 7", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Lundi")), 
            ("Emplacement 7", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Mardi")), 
            ("Emplacement 7", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Mercredi")), 
            ("Emplacement 7", (SELECT id FROM campus WHERE ville="Paris"), (SELECT id FROM jour_disponible WHERE nom="Jeudi"))
            ;');


    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

        // Suppression des donnees des tables
        $this->addSql('DELETE FROM creneau;');
        $this->addSql('DELETE FROM campus;');
        $this->addSql('DELETE FROM jour_disponible;');

    }
}
