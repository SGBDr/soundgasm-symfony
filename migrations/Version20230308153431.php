<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308153431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, artist_id BIGINT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE music (id INT AUTO_INCREMENT NOT NULL, artist_id INT NOT NULL, music_id BIGINT NOT NULL, name VARCHAR(255) NOT NULL, rep_image LONGTEXT NOT NULL, track LONGTEXT NOT NULL, style VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, release_date DATETIME NOT NULL, INDEX IDX_CD52224AB7970CF8 (artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D782112DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist_music (playlist_id INT NOT NULL, music_id INT NOT NULL, INDEX IDX_6E4E3B096BBD148 (playlist_id), INDEX IDX_6E4E3B09399BBB13 (music_id), PRIMARY KEY(playlist_id, music_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_music (user_id INT NOT NULL, music_id INT NOT NULL, INDEX IDX_2F90D912A76ED395 (user_id), INDEX IDX_2F90D912399BBB13 (music_id), PRIMARY KEY(user_id, music_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_artist (user_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_640B8DBAA76ED395 (user_id), INDEX IDX_640B8DBAB7970CF8 (artist_id), PRIMARY KEY(user_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE music ADD CONSTRAINT FK_CD52224AB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE playlist_music ADD CONSTRAINT FK_6E4E3B096BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE playlist_music ADD CONSTRAINT FK_6E4E3B09399BBB13 FOREIGN KEY (music_id) REFERENCES music (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_music ADD CONSTRAINT FK_2F90D912A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_music ADD CONSTRAINT FK_2F90D912399BBB13 FOREIGN KEY (music_id) REFERENCES music (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_artist ADD CONSTRAINT FK_640B8DBAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_artist ADD CONSTRAINT FK_640B8DBAB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) NOT NULL, ADD creation_date DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE music DROP FOREIGN KEY FK_CD52224AB7970CF8');
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112DA76ED395');
        $this->addSql('ALTER TABLE playlist_music DROP FOREIGN KEY FK_6E4E3B096BBD148');
        $this->addSql('ALTER TABLE playlist_music DROP FOREIGN KEY FK_6E4E3B09399BBB13');
        $this->addSql('ALTER TABLE user_music DROP FOREIGN KEY FK_2F90D912A76ED395');
        $this->addSql('ALTER TABLE user_music DROP FOREIGN KEY FK_2F90D912399BBB13');
        $this->addSql('ALTER TABLE user_artist DROP FOREIGN KEY FK_640B8DBAA76ED395');
        $this->addSql('ALTER TABLE user_artist DROP FOREIGN KEY FK_640B8DBAB7970CF8');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE music');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_music');
        $this->addSql('DROP TABLE user_music');
        $this->addSql('DROP TABLE user_artist');
        $this->addSql('ALTER TABLE user DROP name, DROP creation_date');
    }
}
