<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181219052612 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lj_user ADD avatar_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE lj_user ADD CONSTRAINT FK_6E81849C86383B10 FOREIGN KEY (avatar_id) REFERENCES lj_avatar (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6E81849C86383B10 ON lj_user (avatar_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lj_user DROP FOREIGN KEY FK_6E81849C86383B10');
        $this->addSql('DROP INDEX UNIQ_6E81849C86383B10 ON lj_user');
        $this->addSql('ALTER TABLE lj_user DROP avatar_id');
    }
}
