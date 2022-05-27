<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220527072232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE motherboard_memory');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE motherboard_memory (motherboard_id INT NOT NULL, memory_id INT NOT NULL, INDEX IDX_AF8C44A16511E8A3 (motherboard_id), INDEX IDX_AF8C44A1CCC80CB3 (memory_id), PRIMARY KEY(motherboard_id, memory_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE motherboard_memory ADD CONSTRAINT FK_AF8C44A16511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_memory ADD CONSTRAINT FK_AF8C44A1CCC80CB3 FOREIGN KEY (memory_id) REFERENCES memory (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
