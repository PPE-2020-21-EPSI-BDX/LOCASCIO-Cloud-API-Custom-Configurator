<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220528134725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE barebone (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, availability VARCHAR(10) DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) DEFAULT NULL, url VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE barebone_motherboard (barebone_id INT NOT NULL, motherboard_id INT NOT NULL, INDEX IDX_BB59A5F54D3586AB (barebone_id), INDEX IDX_BB59A5F56511E8A3 (motherboard_id), PRIMARY KEY(barebone_id, motherboard_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE connector (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, max_transfert_speed VARCHAR(25) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disk (id INT AUTO_INCREMENT NOT NULL, interface_id INT NOT NULL, form_factor_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, capacity VARCHAR(10) NOT NULL, read_speed VARCHAR(10) DEFAULT NULL, write_speed VARCHAR(10) DEFAULT NULL, shuffle_playback VARCHAR(20) DEFAULT NULL, random_writing VARCHAR(20) DEFAULT NULL, application VARCHAR(50) DEFAULT NULL, hdd_rotation_speed VARCHAR(20) DEFAULT NULL, availability INT DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) NOT NULL, url VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_C74DD02AB0BE982 (interface_id), INDEX IDX_C74DD02CD887EAF (form_factor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE form_factor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, level INT NOT NULL, min_disk INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE memory (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, brand VARCHAR(50) NOT NULL, delivery DATETIME DEFAULT NULL, capacity VARCHAR(50) DEFAULT NULL, cas VARCHAR(50) DEFAULT NULL, number INT DEFAULT NULL, type VARCHAR(50) DEFAULT NULL, freq VARCHAR(50) DEFAULT NULL, ecc TINYINT(1) NOT NULL, application VARCHAR(255) DEFAULT NULL, url VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, slot_type VARCHAR(20) DEFAULT NULL, provider_reference VARCHAR(50) DEFAULT NULL, availability INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE memory_motherboard (memory_id INT NOT NULL, motherboard_id INT NOT NULL, INDEX IDX_BEFF40EACCC80CB3 (memory_id), INDEX IDX_BEFF40EA6511E8A3 (motherboard_id), PRIMARY KEY(memory_id, motherboard_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motherboard (id INT AUTO_INCREMENT NOT NULL, form_factor_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, dimension VARCHAR(255) DEFAULT NULL, processor_note LONGTEXT DEFAULT NULL, mem_slots INT NOT NULL, nbr_max_sata INT DEFAULT NULL, stata_speed VARCHAR(10) DEFAULT NULL, lan VARCHAR(255) DEFAULT NULL, usb VARCHAR(255) DEFAULT NULL, video_output VARCHAR(255) DEFAULT NULL, dom VARCHAR(255) DEFAULT NULL, tpm VARCHAR(255) DEFAULT NULL, availability VARCHAR(10) DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_7F7A0F2BCD887EAF (form_factor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motherboard_processor (motherboard_id INT NOT NULL, processor_id INT NOT NULL, INDEX IDX_2BE8FD216511E8A3 (motherboard_id), INDEX IDX_2BE8FD2137BAC19A (processor_id), PRIMARY KEY(motherboard_id, processor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motherboard_connector (motherboard_id INT NOT NULL, connector_id INT NOT NULL, INDEX IDX_16A4FE1F6511E8A3 (motherboard_id), INDEX IDX_16A4FE1F4D085745 (connector_id), PRIMARY KEY(motherboard_id, connector_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE processor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, brand VARCHAR(100) DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) DEFAULT NULL, socket VARCHAR(50) DEFAULT NULL, upi INT DEFAULT NULL, cores INT DEFAULT NULL, threads INT DEFAULT NULL, tdp VARCHAR(20) DEFAULT NULL, base_freq VARCHAR(50) DEFAULT NULL, boost_freq VARCHAR(50) DEFAULT NULL, cache VARCHAR(50) DEFAULT NULL, max_mem_capacity VARCHAR(50) DEFAULT NULL, max_mem_speed VARCHAR(50) DEFAULT NULL, mem_type VARCHAR(50) DEFAULT NULL, application VARCHAR(50) DEFAULT NULL, url VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, ecc TINYINT(1) DEFAULT NULL, grafics_processor TINYINT(1) DEFAULT NULL, availability INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raid_card (id INT AUTO_INCREMENT NOT NULL, input_to_motherboard_id INT NOT NULL, name VARCHAR(255) NOT NULL, max_nbr_disk INT NOT NULL, availability INT DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) NOT NULL, price DOUBLE PRECISION NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_2445047796F83576 (input_to_motherboard_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raid_card_interface (raid_card_id INT NOT NULL, connector_id INT NOT NULL, INDEX IDX_6A9E532B5525CBDA (raid_card_id), INDEX IDX_6A9E532B4D085745 (connector_id), PRIMARY KEY(raid_card_id, connector_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raid_card_level (raid_card_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_60FBFD055525CBDA (raid_card_id), INDEX IDX_60FBFD055FB14BA7 (level_id), PRIMARY KEY(raid_card_id, level_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE barebone_motherboard ADD CONSTRAINT FK_BB59A5F54D3586AB FOREIGN KEY (barebone_id) REFERENCES barebone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE barebone_motherboard ADD CONSTRAINT FK_BB59A5F56511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE disk ADD CONSTRAINT FK_C74DD02AB0BE982 FOREIGN KEY (interface_id) REFERENCES connector (id)');
        $this->addSql('ALTER TABLE disk ADD CONSTRAINT FK_C74DD02CD887EAF FOREIGN KEY (form_factor_id) REFERENCES form_factor (id)');
        $this->addSql('ALTER TABLE memory_motherboard ADD CONSTRAINT FK_BEFF40EACCC80CB3 FOREIGN KEY (memory_id) REFERENCES memory (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE memory_motherboard ADD CONSTRAINT FK_BEFF40EA6511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard ADD CONSTRAINT FK_7F7A0F2BCD887EAF FOREIGN KEY (form_factor_id) REFERENCES form_factor (id)');
        $this->addSql('ALTER TABLE motherboard_processor ADD CONSTRAINT FK_2BE8FD216511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_processor ADD CONSTRAINT FK_2BE8FD2137BAC19A FOREIGN KEY (processor_id) REFERENCES processor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_connector ADD CONSTRAINT FK_16A4FE1F6511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_connector ADD CONSTRAINT FK_16A4FE1F4D085745 FOREIGN KEY (connector_id) REFERENCES connector (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE raid_card ADD CONSTRAINT FK_2445047796F83576 FOREIGN KEY (input_to_motherboard_id) REFERENCES connector (id)');
        $this->addSql('ALTER TABLE raid_card_interface ADD CONSTRAINT FK_6A9E532B5525CBDA FOREIGN KEY (raid_card_id) REFERENCES raid_card (id)');
        $this->addSql('ALTER TABLE raid_card_interface ADD CONSTRAINT FK_6A9E532B4D085745 FOREIGN KEY (connector_id) REFERENCES connector (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE raid_card_level ADD CONSTRAINT FK_60FBFD055525CBDA FOREIGN KEY (raid_card_id) REFERENCES raid_card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE raid_card_level ADD CONSTRAINT FK_60FBFD055FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE barebone_motherboard DROP FOREIGN KEY FK_BB59A5F54D3586AB');
        $this->addSql('ALTER TABLE disk DROP FOREIGN KEY FK_C74DD02AB0BE982');
        $this->addSql('ALTER TABLE motherboard_connector DROP FOREIGN KEY FK_16A4FE1F4D085745');
        $this->addSql('ALTER TABLE raid_card DROP FOREIGN KEY FK_2445047796F83576');
        $this->addSql('ALTER TABLE raid_card_interface DROP FOREIGN KEY FK_6A9E532B4D085745');
        $this->addSql('ALTER TABLE disk DROP FOREIGN KEY FK_C74DD02CD887EAF');
        $this->addSql('ALTER TABLE motherboard DROP FOREIGN KEY FK_7F7A0F2BCD887EAF');
        $this->addSql('ALTER TABLE raid_card_level DROP FOREIGN KEY FK_60FBFD055FB14BA7');
        $this->addSql('ALTER TABLE memory_motherboard DROP FOREIGN KEY FK_BEFF40EACCC80CB3');
        $this->addSql('ALTER TABLE barebone_motherboard DROP FOREIGN KEY FK_BB59A5F56511E8A3');
        $this->addSql('ALTER TABLE memory_motherboard DROP FOREIGN KEY FK_BEFF40EA6511E8A3');
        $this->addSql('ALTER TABLE motherboard_processor DROP FOREIGN KEY FK_2BE8FD216511E8A3');
        $this->addSql('ALTER TABLE motherboard_connector DROP FOREIGN KEY FK_16A4FE1F6511E8A3');
        $this->addSql('ALTER TABLE motherboard_processor DROP FOREIGN KEY FK_2BE8FD2137BAC19A');
        $this->addSql('ALTER TABLE raid_card_interface DROP FOREIGN KEY FK_6A9E532B5525CBDA');
        $this->addSql('ALTER TABLE raid_card_level DROP FOREIGN KEY FK_60FBFD055525CBDA');
        $this->addSql('DROP TABLE barebone');
        $this->addSql('DROP TABLE barebone_motherboard');
        $this->addSql('DROP TABLE connector');
        $this->addSql('DROP TABLE disk');
        $this->addSql('DROP TABLE form_factor');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE memory');
        $this->addSql('DROP TABLE memory_motherboard');
        $this->addSql('DROP TABLE motherboard');
        $this->addSql('DROP TABLE motherboard_processor');
        $this->addSql('DROP TABLE motherboard_connector');
        $this->addSql('DROP TABLE processor');
        $this->addSql('DROP TABLE raid_card');
        $this->addSql('DROP TABLE raid_card_interface');
        $this->addSql('DROP TABLE raid_card_level');
    }
}
