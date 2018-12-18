<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181218034158 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lj_comment DROP FOREIGN KEY FK_6402EBCAB281BE2E');
        $this->addSql('DROP INDEX IDX_6402EBCAB281BE2E ON lj_comment');
        $this->addSql('ALTER TABLE lj_comment CHANGE trick_id trock_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE lj_comment ADD CONSTRAINT FK_6402EBCA64D85D33 FOREIGN KEY (trock_id) REFERENCES lj_trick (id)');
        $this->addSql('CREATE INDEX IDX_6402EBCA64D85D33 ON lj_comment (trock_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lj_comment DROP FOREIGN KEY FK_6402EBCA64D85D33');
        $this->addSql('DROP INDEX IDX_6402EBCA64D85D33 ON lj_comment');
        $this->addSql('ALTER TABLE lj_comment CHANGE trock_id trick_id CHAR(36) DEFAULT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE lj_comment ADD CONSTRAINT FK_6402EBCAB281BE2E FOREIGN KEY (trick_id) REFERENCES lj_trick (id)');
        $this->addSql('CREATE INDEX IDX_6402EBCAB281BE2E ON lj_comment (trick_id)');
    }
}
