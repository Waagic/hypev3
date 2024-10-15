<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241015152038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CC54C8C93 FOREIGN KEY (type_id) REFERENCES media_type (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6A2CA10CC54C8C93 ON media (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CC54C8C93');
        $this->addSql('DROP INDEX UNIQ_6A2CA10CC54C8C93 ON media');
        $this->addSql('ALTER TABLE media DROP type_id');
    }
}
