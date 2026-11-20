<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261120132913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE board_game (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, number_player SMALLINT NOT NULL, average_duration TIME NOT NULL, min_age SMALLINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, booking_date DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE copy (id INT AUTO_INCREMENT NOT NULL, copy_number SMALLINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE party_game (id INT AUTO_INCREMENT NOT NULL, party_game_name VARCHAR(50) DEFAULT NULL, party_game_description LONGTEXT DEFAULT NULL, available_space SMALLINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_type VARCHAR(255) NOT NULL, user_first_name VARCHAR(50) NOT NULL, user_last_name VARCHAR(50) NOT NULL, user_email VARCHAR(100) NOT NULL, user_password VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE board_game');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE copy');
        $this->addSql('DROP TABLE party_game');
        $this->addSql('DROP TABLE user');
    }
}
