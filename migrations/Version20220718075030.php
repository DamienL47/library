<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220718075030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author CHANGE birth_date birth_date DATE NOT NULL, CHANGE death_date death_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE book CHANGE published_at published_at DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author CHANGE birth_date birth_date DATETIME NOT NULL, CHANGE death_date death_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE book CHANGE published_at published_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
