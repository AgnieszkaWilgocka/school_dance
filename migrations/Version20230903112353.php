<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230903112353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dances (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, field INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dances_tags (dance_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_DFE9C97B65D64EDD (dance_id), INDEX IDX_DFE9C97BBAD26311 (tag_id), PRIMARY KEY(dance_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE my_classes (id INT AUTO_INCREMENT NOT NULL, dance_id INT DEFAULT NULL, author_id INT DEFAULT NULL, INDEX IDX_8814D2E965D64EDD (dance_id), INDEX IDX_8814D2E9F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_data_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6496FF8BF36 (user_data_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_data (id INT AUTO_INCREMENT NOT NULL, nick VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dances_tags ADD CONSTRAINT FK_DFE9C97B65D64EDD FOREIGN KEY (dance_id) REFERENCES dances (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dances_tags ADD CONSTRAINT FK_DFE9C97BBAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE my_classes ADD CONSTRAINT FK_8814D2E965D64EDD FOREIGN KEY (dance_id) REFERENCES dances (id)');
        $this->addSql('ALTER TABLE my_classes ADD CONSTRAINT FK_8814D2E9F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496FF8BF36 FOREIGN KEY (user_data_id) REFERENCES users_data (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dances_tags DROP FOREIGN KEY FK_DFE9C97B65D64EDD');
        $this->addSql('ALTER TABLE dances_tags DROP FOREIGN KEY FK_DFE9C97BBAD26311');
        $this->addSql('ALTER TABLE my_classes DROP FOREIGN KEY FK_8814D2E965D64EDD');
        $this->addSql('ALTER TABLE my_classes DROP FOREIGN KEY FK_8814D2E9F675F31B');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496FF8BF36');
        $this->addSql('DROP TABLE dances');
        $this->addSql('DROP TABLE dances_tags');
        $this->addSql('DROP TABLE my_classes');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE users_data');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
