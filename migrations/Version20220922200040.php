<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922200040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__bibliotheque AS SELECT id, description, name FROM bibliotheque');
        $this->addSql('UPDATE __temp__bibliotheque SET name = "Bibliothèque de "');
        $this->addSql('DROP TABLE bibliotheque');
        $this->addSql('CREATE TABLE bibliotheque (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, description CLOB NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO bibliotheque (id, description, name) SELECT id, description, name FROM __temp__bibliotheque');
        $this->addSql('DROP TABLE __temp__bibliotheque');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__bibliotheque AS SELECT id, description, name FROM bibliotheque');
        $this->addSql('DROP TABLE bibliotheque');
        $this->addSql('CREATE TABLE bibliotheque (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, description CLOB NOT NULL, name VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO bibliotheque (id, description, name) SELECT id, description, name FROM __temp__bibliotheque');
        $this->addSql('DROP TABLE __temp__bibliotheque');
    }
}