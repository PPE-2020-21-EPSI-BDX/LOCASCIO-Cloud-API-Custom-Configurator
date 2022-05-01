<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220501184653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE firewall ADD form_factor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE firewall ADD CONSTRAINT FK_48011B7ECD887EAF FOREIGN KEY (form_factor_id) REFERENCES form_factor (id)');
        $this->addSql('CREATE INDEX IDX_48011B7ECD887EAF ON firewall (form_factor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE firewall DROP FOREIGN KEY FK_48011B7ECD887EAF');
        $this->addSql('DROP INDEX IDX_48011B7ECD887EAF ON firewall');
        $this->addSql('ALTER TABLE firewall DROP form_factor_id');
    }
}
