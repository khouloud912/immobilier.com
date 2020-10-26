<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200104225422 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE immobilier ADD id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE immobilier ADD CONSTRAINT FK_142D24D26B3CA4B FOREIGN KEY (id_user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_142D24D26B3CA4B ON immobilier (id_user)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE immobilier DROP FOREIGN KEY FK_142D24D26B3CA4B');
        $this->addSql('DROP INDEX IDX_142D24D26B3CA4B ON immobilier');
        $this->addSql('ALTER TABLE immobilier DROP id_user');
    }
}
