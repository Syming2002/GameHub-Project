<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261121144740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE board_game ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE board_game ADD CONSTRAINT FK_F9BD68AF12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_F9BD68AF12469DE2 ON board_game (category_id)');
        $this->addSql('ALTER TABLE booking ADD party_game_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEF67E462E FOREIGN KEY (party_game_id) REFERENCES party_game (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEF67E462E ON booking (party_game_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEA76ED395 ON booking (user_id)');
        $this->addSql('ALTER TABLE party_game ADD board_game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE party_game ADD CONSTRAINT FK_3C88F05FAC91F10A FOREIGN KEY (board_game_id) REFERENCES board_game (id)');
        $this->addSql('CREATE INDEX IDX_3C88F05FAC91F10A ON party_game (board_game_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE board_game DROP FOREIGN KEY FK_F9BD68AF12469DE2');
        $this->addSql('DROP INDEX IDX_F9BD68AF12469DE2 ON board_game');
        $this->addSql('ALTER TABLE board_game DROP category_id');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEF67E462E');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('DROP INDEX IDX_E00CEDDEF67E462E ON booking');
        $this->addSql('DROP INDEX IDX_E00CEDDEA76ED395 ON booking');
        $this->addSql('ALTER TABLE booking DROP party_game_id, DROP user_id');
        $this->addSql('ALTER TABLE party_game DROP FOREIGN KEY FK_3C88F05FAC91F10A');
        $this->addSql('DROP INDEX IDX_3C88F05FAC91F10A ON party_game');
        $this->addSql('ALTER TABLE party_game DROP board_game_id');
    }
}
