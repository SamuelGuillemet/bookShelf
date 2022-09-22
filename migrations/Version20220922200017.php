<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922200017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE membre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, bibliotheque_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, birth_date DATE NOT NULL, CONSTRAINT FK_F6B4FB294419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6B4FB294419DE7D ON membre (bibliotheque_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__bibliotheque AS SELECT id, description FROM bibliotheque');
        $this->addSql('DROP TABLE bibliotheque');
        $this->addSql('CREATE TABLE bibliotheque (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, description CLOB NOT NULL, name VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO bibliotheque (id, description) SELECT id, description FROM __temp__bibliotheque');
        $this->addSql('DROP TABLE __temp__bibliotheque');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE membre');
        $this->addSql('CREATE TEMPORARY TABLE __temp__bibliotheque AS SELECT id, description FROM bibliotheque');
        $this->addSql('DROP TABLE bibliotheque');
        $this->addSql('CREATE TABLE bibliotheque (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, description VARCHAR(1000) NOT NULL)');
        $this->addSql('INSERT INTO bibliotheque (id, description) SELECT id, description FROM __temp__bibliotheque');
        $this->addSql('DROP TABLE __temp__bibliotheque');
    }
}
