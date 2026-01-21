<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260117150309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_match (id INT AUTO_INCREMENT NOT NULL, round INT NOT NULL, status VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, player_one_id INT NOT NULL, player_two_id INT NOT NULL, INDEX IDX_4868BC8A649A58CD (player_one_id), INDEX IDX_4868BC8AFC6BF02 (player_two_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE match_result (id INT AUTO_INCREMENT NOT NULL, result VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL, game_match_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_B205381281FA53F0 (game_match_id), INDEX IDX_B205381299E6F5DF (player_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE game_match ADD CONSTRAINT FK_4868BC8A649A58CD FOREIGN KEY (player_one_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game_match ADD CONSTRAINT FK_4868BC8AFC6BF02 FOREIGN KEY (player_two_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE match_result ADD CONSTRAINT FK_B205381281FA53F0 FOREIGN KEY (game_match_id) REFERENCES game_match (id)');
        $this->addSql('ALTER TABLE match_result ADD CONSTRAINT FK_B205381299E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_match DROP FOREIGN KEY FK_4868BC8A649A58CD');
        $this->addSql('ALTER TABLE game_match DROP FOREIGN KEY FK_4868BC8AFC6BF02');
        $this->addSql('ALTER TABLE match_result DROP FOREIGN KEY FK_B205381281FA53F0');
        $this->addSql('ALTER TABLE match_result DROP FOREIGN KEY FK_B205381299E6F5DF');
        $this->addSql('DROP TABLE game_match');
        $this->addSql('DROP TABLE match_result');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
