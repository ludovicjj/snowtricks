<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181205134251 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lj_category (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lj_trick ADD category_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', CHANGE date_create date_create DATETIME NOT NULL, CHANGE date_update date_update DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE lj_trick ADD CONSTRAINT FK_2EAA9D1712469DE2 FOREIGN KEY (category_id) REFERENCES lj_category (id)');
        $this->addSql('CREATE INDEX IDX_2EAA9D1712469DE2 ON lj_trick (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lj_trick DROP FOREIGN KEY FK_2EAA9D1712469DE2');
        $this->addSql('DROP TABLE lj_category');
        $this->addSql('DROP INDEX IDX_2EAA9D1712469DE2 ON lj_trick');
        $this->addSql('ALTER TABLE lj_trick DROP category_id, CHANGE date_create date_create INT NOT NULL, CHANGE date_update date_update INT DEFAULT NULL');
    }
}
