<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181208195303 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lj_tricks_images (trick_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', image_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_FDAA43AEB281BE2E (trick_id), INDEX IDX_FDAA43AE3DA5256D (image_id), PRIMARY KEY(trick_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lj_tricks_images ADD CONSTRAINT FK_FDAA43AEB281BE2E FOREIGN KEY (trick_id) REFERENCES lj_trick (id)');
        $this->addSql('ALTER TABLE lj_tricks_images ADD CONSTRAINT FK_FDAA43AE3DA5256D FOREIGN KEY (image_id) REFERENCES lj_image (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE lj_tricks_images');
    }
}
