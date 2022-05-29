<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220529175827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE connector (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, max_transfert_speed VARCHAR(25) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disk (id INT AUTO_INCREMENT NOT NULL, interface_id INT NOT NULL, form_factor_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, capacity VARCHAR(10) NOT NULL, read_speed VARCHAR(10) DEFAULT NULL, write_speed VARCHAR(10) DEFAULT NULL, shuffle_playback VARCHAR(20) DEFAULT NULL, random_writing VARCHAR(20) DEFAULT NULL, application VARCHAR(50) DEFAULT NULL, hdd_rotation_speed VARCHAR(20) DEFAULT NULL, availability INT DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) NOT NULL, url VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_C74DD02AB0BE982 (interface_id), INDEX IDX_C74DD02CD887EAF (form_factor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE form_factor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE indicator (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, level INT NOT NULL, min_disk INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE memory (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, brand VARCHAR(50) NOT NULL, delivery DATETIME DEFAULT NULL, capacity VARCHAR(50) DEFAULT NULL, cas VARCHAR(50) DEFAULT NULL, number INT DEFAULT NULL, type VARCHAR(50) DEFAULT NULL, freq VARCHAR(50) DEFAULT NULL, ecc TINYINT(1) NOT NULL, application VARCHAR(255) DEFAULT NULL, url VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, slot_type VARCHAR(20) DEFAULT NULL, provider_reference VARCHAR(50) DEFAULT NULL, availability INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motherboard (id INT AUTO_INCREMENT NOT NULL, form_factor_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, processor_note LONGTEXT DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, tpm INT NOT NULL, availability INT DEFAULT NULL, INDEX IDX_7F7A0F2BCD887EAF (form_factor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motherboard_interface (motherboard_id INT NOT NULL, connector_id INT NOT NULL, INDEX IDX_36DC57AC6511E8A3 (motherboard_id), INDEX IDX_36DC57AC4D085745 (connector_id), PRIMARY KEY(motherboard_id, connector_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motherboard_memory (motherboard_id INT NOT NULL, memory_id INT NOT NULL, INDEX IDX_AF8C44A16511E8A3 (motherboard_id), INDEX IDX_AF8C44A1CCC80CB3 (memory_id), PRIMARY KEY(motherboard_id, memory_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motherboard_processor (motherboard_id INT NOT NULL, processor_id INT NOT NULL, INDEX IDX_2BE8FD216511E8A3 (motherboard_id), INDEX IDX_2BE8FD2137BAC19A (processor_id), PRIMARY KEY(motherboard_id, processor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE power (id INT AUTO_INCREMENT NOT NULL, capacity DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE processor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, brand VARCHAR(100) DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) DEFAULT NULL, socket VARCHAR(50) DEFAULT NULL, upi INT DEFAULT NULL, cores INT DEFAULT NULL, threads INT DEFAULT NULL, tdp VARCHAR(20) DEFAULT NULL, base_freq VARCHAR(50) DEFAULT NULL, boost_freq VARCHAR(50) DEFAULT NULL, cache VARCHAR(50) DEFAULT NULL, max_mem_capacity VARCHAR(50) DEFAULT NULL, max_mem_speed VARCHAR(50) DEFAULT NULL, mem_type VARCHAR(50) DEFAULT NULL, application VARCHAR(50) DEFAULT NULL, url VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, ecc TINYINT(1) DEFAULT NULL, grafics_processor TINYINT(1) DEFAULT NULL, availability INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rack (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, brand VARCHAR(100) DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, width INT DEFAULT NULL, depth INT DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, availability INT DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) NOT NULL, url VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, height INT DEFAULT NULL, type VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rack_form_factor (id INT AUTO_INCREMENT NOT NULL, rack_id INT NOT NULL, rack_unit_id INT NOT NULL, INDEX IDX_9C80C0148E86A33E (rack_id), INDEX IDX_9C80C0142FCF7EEF (rack_unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rack_indicator (id INT AUTO_INCREMENT NOT NULL, rack_id INT NOT NULL, indicator_id INT NOT NULL, INDEX IDX_5AC4F6A88E86A33E (rack_id), INDEX IDX_5AC4F6A84402854A (indicator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rack_motherboard (id INT AUTO_INCREMENT NOT NULL, rack_id INT NOT NULL, motherboard_id INT NOT NULL, INDEX IDX_C2CF7918E86A33E (rack_id), INDEX IDX_C2CF7916511E8A3 (motherboard_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rack_power (id INT AUTO_INCREMENT NOT NULL, rack_id INT NOT NULL, power_id INT NOT NULL, power_supply_included INT NOT NULL, redundant_power INT NOT NULL, INDEX IDX_1D8B5BEC8E86A33E (rack_id), INDEX IDX_1D8B5BECAB4FC384 (power_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rack_storage (id INT AUTO_INCREMENT NOT NULL, rack_id INT NOT NULL, disk_form_factor_id INT NOT NULL, storage_connector_id INT NOT NULL, INDEX IDX_830815D68E86A33E (rack_id), INDEX IDX_830815D6D5B29D06 (disk_form_factor_id), INDEX IDX_830815D616BD7E2 (storage_connector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raid_card (id INT AUTO_INCREMENT NOT NULL, input_to_motherboard_id INT NOT NULL, name VARCHAR(255) NOT NULL, max_nbr_disk INT NOT NULL, availability INT DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) NOT NULL, price DOUBLE PRECISION NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_2445047796F83576 (input_to_motherboard_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raid_card_interface (raid_card_id INT NOT NULL, connector_id INT NOT NULL, INDEX IDX_6A9E532B5525CBDA (raid_card_id), INDEX IDX_6A9E532B4D085745 (connector_id), PRIMARY KEY(raid_card_id, connector_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raid_card_level (raid_card_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_60FBFD055525CBDA (raid_card_id), INDEX IDX_60FBFD055FB14BA7 (level_id), PRIMARY KEY(raid_card_id, level_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE disk ADD CONSTRAINT FK_C74DD02AB0BE982 FOREIGN KEY (interface_id) REFERENCES connector (id)');
        $this->addSql('ALTER TABLE disk ADD CONSTRAINT FK_C74DD02CD887EAF FOREIGN KEY (form_factor_id) REFERENCES form_factor (id)');
        $this->addSql('ALTER TABLE motherboard ADD CONSTRAINT FK_7F7A0F2BCD887EAF FOREIGN KEY (form_factor_id) REFERENCES form_factor (id)');
        $this->addSql('ALTER TABLE motherboard_interface ADD CONSTRAINT FK_36DC57AC6511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_interface ADD CONSTRAINT FK_36DC57AC4D085745 FOREIGN KEY (connector_id) REFERENCES connector (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_memory ADD CONSTRAINT FK_AF8C44A16511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_memory ADD CONSTRAINT FK_AF8C44A1CCC80CB3 FOREIGN KEY (memory_id) REFERENCES memory (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_processor ADD CONSTRAINT FK_2BE8FD216511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_processor ADD CONSTRAINT FK_2BE8FD2137BAC19A FOREIGN KEY (processor_id) REFERENCES processor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rack_form_factor ADD CONSTRAINT FK_9C80C0148E86A33E FOREIGN KEY (rack_id) REFERENCES rack (id)');
        $this->addSql('ALTER TABLE rack_form_factor ADD CONSTRAINT FK_9C80C0142FCF7EEF FOREIGN KEY (rack_unit_id) REFERENCES form_factor (id)');
        $this->addSql('ALTER TABLE rack_indicator ADD CONSTRAINT FK_5AC4F6A88E86A33E FOREIGN KEY (rack_id) REFERENCES rack (id)');
        $this->addSql('ALTER TABLE rack_indicator ADD CONSTRAINT FK_5AC4F6A84402854A FOREIGN KEY (indicator_id) REFERENCES indicator (id)');
        $this->addSql('ALTER TABLE rack_motherboard ADD CONSTRAINT FK_C2CF7918E86A33E FOREIGN KEY (rack_id) REFERENCES rack (id)');
        $this->addSql('ALTER TABLE rack_motherboard ADD CONSTRAINT FK_C2CF7916511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id)');
        $this->addSql('ALTER TABLE rack_power ADD CONSTRAINT FK_1D8B5BEC8E86A33E FOREIGN KEY (rack_id) REFERENCES rack (id)');
        $this->addSql('ALTER TABLE rack_power ADD CONSTRAINT FK_1D8B5BECAB4FC384 FOREIGN KEY (power_id) REFERENCES power (id)');
        $this->addSql('ALTER TABLE rack_storage ADD CONSTRAINT FK_830815D68E86A33E FOREIGN KEY (rack_id) REFERENCES rack (id)');
        $this->addSql('ALTER TABLE rack_storage ADD CONSTRAINT FK_830815D6D5B29D06 FOREIGN KEY (disk_form_factor_id) REFERENCES form_factor (id)');
        $this->addSql('ALTER TABLE rack_storage ADD CONSTRAINT FK_830815D616BD7E2 FOREIGN KEY (storage_connector_id) REFERENCES connector (id)');
        $this->addSql('ALTER TABLE raid_card ADD CONSTRAINT FK_2445047796F83576 FOREIGN KEY (input_to_motherboard_id) REFERENCES connector (id)');
        $this->addSql('ALTER TABLE raid_card_interface ADD CONSTRAINT FK_6A9E532B5525CBDA FOREIGN KEY (raid_card_id) REFERENCES raid_card (id)');
        $this->addSql('ALTER TABLE raid_card_interface ADD CONSTRAINT FK_6A9E532B4D085745 FOREIGN KEY (connector_id) REFERENCES connector (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE raid_card_level ADD CONSTRAINT FK_60FBFD055525CBDA FOREIGN KEY (raid_card_id) REFERENCES raid_card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE raid_card_level ADD CONSTRAINT FK_60FBFD055FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE disk DROP FOREIGN KEY FK_C74DD02AB0BE982');
        $this->addSql('ALTER TABLE motherboard_interface DROP FOREIGN KEY FK_36DC57AC4D085745');
        $this->addSql('ALTER TABLE rack_storage DROP FOREIGN KEY FK_830815D616BD7E2');
        $this->addSql('ALTER TABLE raid_card DROP FOREIGN KEY FK_2445047796F83576');
        $this->addSql('ALTER TABLE raid_card_interface DROP FOREIGN KEY FK_6A9E532B4D085745');
        $this->addSql('ALTER TABLE disk DROP FOREIGN KEY FK_C74DD02CD887EAF');
        $this->addSql('ALTER TABLE motherboard DROP FOREIGN KEY FK_7F7A0F2BCD887EAF');
        $this->addSql('ALTER TABLE rack_form_factor DROP FOREIGN KEY FK_9C80C0142FCF7EEF');
        $this->addSql('ALTER TABLE rack_storage DROP FOREIGN KEY FK_830815D6D5B29D06');
        $this->addSql('ALTER TABLE rack_indicator DROP FOREIGN KEY FK_5AC4F6A84402854A');
        $this->addSql('ALTER TABLE raid_card_level DROP FOREIGN KEY FK_60FBFD055FB14BA7');
        $this->addSql('ALTER TABLE motherboard_memory DROP FOREIGN KEY FK_AF8C44A1CCC80CB3');
        $this->addSql('ALTER TABLE motherboard_interface DROP FOREIGN KEY FK_36DC57AC6511E8A3');
        $this->addSql('ALTER TABLE motherboard_memory DROP FOREIGN KEY FK_AF8C44A16511E8A3');
        $this->addSql('ALTER TABLE motherboard_processor DROP FOREIGN KEY FK_2BE8FD216511E8A3');
        $this->addSql('ALTER TABLE rack_motherboard DROP FOREIGN KEY FK_C2CF7916511E8A3');
        $this->addSql('ALTER TABLE rack_power DROP FOREIGN KEY FK_1D8B5BECAB4FC384');
        $this->addSql('ALTER TABLE motherboard_processor DROP FOREIGN KEY FK_2BE8FD2137BAC19A');
        $this->addSql('ALTER TABLE rack_form_factor DROP FOREIGN KEY FK_9C80C0148E86A33E');
        $this->addSql('ALTER TABLE rack_indicator DROP FOREIGN KEY FK_5AC4F6A88E86A33E');
        $this->addSql('ALTER TABLE rack_motherboard DROP FOREIGN KEY FK_C2CF7918E86A33E');
        $this->addSql('ALTER TABLE rack_power DROP FOREIGN KEY FK_1D8B5BEC8E86A33E');
        $this->addSql('ALTER TABLE rack_storage DROP FOREIGN KEY FK_830815D68E86A33E');
        $this->addSql('ALTER TABLE raid_card_interface DROP FOREIGN KEY FK_6A9E532B5525CBDA');
        $this->addSql('ALTER TABLE raid_card_level DROP FOREIGN KEY FK_60FBFD055525CBDA');
        $this->addSql('DROP TABLE connector');
        $this->addSql('DROP TABLE disk');
        $this->addSql('DROP TABLE form_factor');
        $this->addSql('DROP TABLE indicator');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE memory');
        $this->addSql('DROP TABLE motherboard');
        $this->addSql('DROP TABLE motherboard_interface');
        $this->addSql('DROP TABLE motherboard_memory');
        $this->addSql('DROP TABLE motherboard_processor');
        $this->addSql('DROP TABLE power');
        $this->addSql('DROP TABLE processor');
        $this->addSql('DROP TABLE rack');
        $this->addSql('DROP TABLE rack_form_factor');
        $this->addSql('DROP TABLE rack_indicator');
        $this->addSql('DROP TABLE rack_motherboard');
        $this->addSql('DROP TABLE rack_power');
        $this->addSql('DROP TABLE rack_storage');
        $this->addSql('DROP TABLE raid_card');
        $this->addSql('DROP TABLE raid_card_interface');
        $this->addSql('DROP TABLE raid_card_level');
    }
}
