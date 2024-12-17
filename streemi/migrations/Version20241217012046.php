<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241217012046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, details VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, message LONGTEXT NOT NULL, parent_comment_id INT DEFAULT NULL, author_id INT NOT NULL, associated_media_id INT NOT NULL, INDEX IDX_9474526CBF2AF943 (parent_comment_id), INDEX IDX_9474526CF675F31B (author_id), INDEX IDX_9474526C9B351103 (associated_media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE episode (id INT AUTO_INCREMENT NOT NULL, episode_title VARCHAR(255) NOT NULL, runtime INT NOT NULL, air_date DATETIME NOT NULL, parent_season_id INT NOT NULL, INDEX IDX_DDAA1CDABF8B2E3F (parent_season_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, abbreviation VARCHAR(3) NOT NULL, UNIQUE INDEX UNIQ_D4DB71B5BCF3411D (abbreviation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, summary LONGTEXT NOT NULL, details LONGTEXT NOT NULL, name VARCHAR(255) NOT NULL, published_on DATETIME NOT NULL, thumbnail VARCHAR(255) NOT NULL, crew JSON NOT NULL, cast JSON NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE media_category (media_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_92D3773EA9FDD75 (media_id), INDEX IDX_92D377312469DE2 (category_id), PRIMARY KEY(media_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE media_language (media_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_DBBA5F07EA9FDD75 (media_id), INDEX IDX_DBBA5F0782F1BAF4 (language_id), PRIMARY KEY(media_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE movie (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE playlist (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_on DATETIME NOT NULL, updated_on DATETIME NOT NULL, owner_id INT NOT NULL, INDEX IDX_D782112D7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE playlist_media (id INT AUTO_INCREMENT NOT NULL, date_added DATETIME NOT NULL, parent_playlist_id INT NOT NULL, associated_media_id INT NOT NULL, INDEX IDX_C930B84F6D97C338 (parent_playlist_id), INDEX IDX_C930B84F9B351103 (associated_media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE playlist_subscription (id INT AUTO_INCREMENT NOT NULL, subscription_date DATETIME NOT NULL, user_id INT NOT NULL, subscribed_playlist_id INT NOT NULL, INDEX IDX_832940CA76ED395 (user_id), INDEX IDX_832940CB76B73F3 (subscribed_playlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, season_number VARCHAR(255) NOT NULL, parent_serie_id INT NOT NULL, INDEX IDX_F0E45BA9468E246C (parent_serie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE serie (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, plan_name VARCHAR(255) NOT NULL, monthly_cost NUMERIC(10, 2) NOT NULL, duration_in_months INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE subscription_history (id INT AUTO_INCREMENT NOT NULL, started_on DATETIME NOT NULL, ended_on DATETIME NOT NULL, user_id INT NOT NULL, plan_id INT NOT NULL, INDEX IDX_54AF90D0A76ED395 (user_id), INDEX IDX_54AF90D0E899029B (plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(100) NOT NULL, email_address VARCHAR(255) NOT NULL, hashed_password VARCHAR(255) NOT NULL, roles JSON NOT NULL, status VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649B08E074E (email_address), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE watch_history (id INT AUTO_INCREMENT NOT NULL, viewed_at DATETIME NOT NULL, view_count INT NOT NULL, user_id INT NOT NULL, content_id INT NOT NULL, INDEX IDX_DE44EFD8A76ED395 (user_id), INDEX IDX_DE44EFD884A0A3ED (content_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CBF2AF943 FOREIGN KEY (parent_comment_id) REFERENCES comment (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9B351103 FOREIGN KEY (associated_media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDABF8B2E3F FOREIGN KEY (parent_season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE media_category ADD CONSTRAINT FK_92D3773EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_category ADD CONSTRAINT FK_92D377312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_language ADD CONSTRAINT FK_DBBA5F07EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_language ADD CONSTRAINT FK_DBBA5F0782F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FBF396750 FOREIGN KEY (id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE playlist_media ADD CONSTRAINT FK_C930B84F6D97C338 FOREIGN KEY (parent_playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE playlist_media ADD CONSTRAINT FK_C930B84F9B351103 FOREIGN KEY (associated_media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE playlist_subscription ADD CONSTRAINT FK_832940CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE playlist_subscription ADD CONSTRAINT FK_832940CB76B73F3 FOREIGN KEY (subscribed_playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA9468E246C FOREIGN KEY (parent_serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A9334BF396750 FOREIGN KEY (id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subscription_history ADD CONSTRAINT FK_54AF90D0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE subscription_history ADD CONSTRAINT FK_54AF90D0E899029B FOREIGN KEY (plan_id) REFERENCES subscription (id)');
        $this->addSql('ALTER TABLE watch_history ADD CONSTRAINT FK_DE44EFD8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE watch_history ADD CONSTRAINT FK_DE44EFD884A0A3ED FOREIGN KEY (content_id) REFERENCES media (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CBF2AF943');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9B351103');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDABF8B2E3F');
        $this->addSql('ALTER TABLE media_category DROP FOREIGN KEY FK_92D3773EA9FDD75');
        $this->addSql('ALTER TABLE media_category DROP FOREIGN KEY FK_92D377312469DE2');
        $this->addSql('ALTER TABLE media_language DROP FOREIGN KEY FK_DBBA5F07EA9FDD75');
        $this->addSql('ALTER TABLE media_language DROP FOREIGN KEY FK_DBBA5F0782F1BAF4');
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26FBF396750');
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D7E3C61F9');
        $this->addSql('ALTER TABLE playlist_media DROP FOREIGN KEY FK_C930B84F6D97C338');
        $this->addSql('ALTER TABLE playlist_media DROP FOREIGN KEY FK_C930B84F9B351103');
        $this->addSql('ALTER TABLE playlist_subscription DROP FOREIGN KEY FK_832940CA76ED395');
        $this->addSql('ALTER TABLE playlist_subscription DROP FOREIGN KEY FK_832940CB76B73F3');
        $this->addSql('ALTER TABLE season DROP FOREIGN KEY FK_F0E45BA9468E246C');
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A9334BF396750');
        $this->addSql('ALTER TABLE subscription_history DROP FOREIGN KEY FK_54AF90D0A76ED395');
        $this->addSql('ALTER TABLE subscription_history DROP FOREIGN KEY FK_54AF90D0E899029B');
        $this->addSql('ALTER TABLE watch_history DROP FOREIGN KEY FK_DE44EFD8A76ED395');
        $this->addSql('ALTER TABLE watch_history DROP FOREIGN KEY FK_DE44EFD884A0A3ED');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE media_category');
        $this->addSql('DROP TABLE media_language');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_media');
        $this->addSql('DROP TABLE playlist_subscription');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE subscription_history');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE watch_history');
    }
}
