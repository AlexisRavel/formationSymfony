<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230206112106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post_tags (post_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_A6E9F32D4B89032C (post_id), INDEX IDX_A6E9F32D8D7B4FB4 (tags_id), PRIMARY KEY(post_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_tags ADD CONSTRAINT FK_A6E9F32D4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_tags ADD CONSTRAINT FK_A6E9F32D8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tags DROP FOREIGN KEY FK_6FBC94264B89032C');
        $this->addSql('DROP INDEX IDX_6FBC94264B89032C ON tags');
        $this->addSql('ALTER TABLE tags DROP post_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_tags DROP FOREIGN KEY FK_A6E9F32D4B89032C');
        $this->addSql('ALTER TABLE post_tags DROP FOREIGN KEY FK_A6E9F32D8D7B4FB4');
        $this->addSql('DROP TABLE post_tags');
        $this->addSql('ALTER TABLE tags ADD post_id INT NOT NULL');
        $this->addSql('ALTER TABLE tags ADD CONSTRAINT FK_6FBC94264B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_6FBC94264B89032C ON tags (post_id)');
    }
}
