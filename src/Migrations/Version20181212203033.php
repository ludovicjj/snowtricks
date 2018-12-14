<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181212203033 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lj_tricks_images DROP FOREIGN KEY FK_FDAA43AE3DA5256D');
        $this->addSql('ALTER TABLE lj_tricks_images DROP FOREIGN KEY FK_FDAA43AEB281BE2E');
        $this->addSql('ALTER TABLE lj_tricks_images ADD CONSTRAINT FK_FDAA43AE3DA5256D FOREIGN KEY (image_id) REFERENCES lj_image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lj_tricks_images ADD CONSTRAINT FK_FDAA43AEB281BE2E FOREIGN KEY (trick_id) REFERENCES lj_trick (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lj_tricks_images DROP FOREIGN KEY FK_FDAA43AEB281BE2E');
        $this->addSql('ALTER TABLE lj_tricks_images DROP FOREIGN KEY FK_FDAA43AE3DA5256D');
        $this->addSql('ALTER TABLE lj_tricks_images ADD CONSTRAINT FK_FDAA43AEB281BE2E FOREIGN KEY (trick_id) REFERENCES lj_trick (id)');
        $this->addSql('ALTER TABLE lj_tricks_images ADD CONSTRAINT FK_FDAA43AE3DA5256D FOREIGN KEY (image_id) REFERENCES lj_image (id)');
    }
}
