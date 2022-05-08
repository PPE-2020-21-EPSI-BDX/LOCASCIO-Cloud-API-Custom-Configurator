<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220508121340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE barebone (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, availability VARCHAR(10) DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) DEFAULT NULL, url VARCHAR(255) NOT NULL, price NUMERIC(14, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE barebone_motherboard (barebone_id INT NOT NULL, motherboard_id INT NOT NULL, INDEX IDX_BB59A5F54D3586AB (barebone_id), INDEX IDX_BB59A5F56511E8A3 (motherboard_id), PRIMARY KEY(barebone_id, motherboard_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE firewall (id INT AUTO_INCREMENT NOT NULL, form_factor_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, nbr_wan_ports INT DEFAULT NULL, nbr_lan_ports INT DEFAULT NULL, wan_port_throughput VARCHAR(255) DEFAULT NULL, lan_port_throughput VARCHAR(255) DEFAULT NULL, weight INT DEFAULT NULL, is_for_professional INT DEFAULT NULL, url VARCHAR(255) NOT NULL, price NUMERIC(14, 2) DEFAULT NULL, dimensions VARCHAR(255) DEFAULT NULL, INDEX IDX_48011B7ECD887EAF (form_factor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE form_factor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE m2 (id INT AUTO_INCREMENT NOT NULL, interface_id INT DEFAULT NULL, form_factor_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, availability VARCHAR(10) DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) DEFAULT NULL, url VARCHAR(255) NOT NULL, price NUMERIC(14, 2) DEFAULT NULL, INDEX IDX_595D5695AB0BE982 (interface_id), INDEX IDX_595D5695CD887EAF (form_factor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE memory (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, brand VARCHAR(50) NOT NULL, availability VARCHAR(10) DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) DEFAULT NULL, capacity VARCHAR(50) DEFAULT NULL, cas VARCHAR(50) DEFAULT NULL, number INT DEFAULT NULL, type VARCHAR(50) DEFAULT NULL, freq VARCHAR(50) DEFAULT NULL, ecc TINYINT(1) NOT NULL, application VARCHAR(255) DEFAULT NULL, url VARCHAR(255) NOT NULL, price NUMERIC(14, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motherboard (id INT AUTO_INCREMENT NOT NULL, form_factor_id INT DEFAULT NULL, raid_support_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, dimension VARCHAR(255) DEFAULT NULL, processor_note LONGTEXT DEFAULT NULL, mem_slots INT NOT NULL, nbr_max_sata INT DEFAULT NULL, stata_speed VARCHAR(10) DEFAULT NULL, lan VARCHAR(255) DEFAULT NULL, usb VARCHAR(255) DEFAULT NULL, video_output VARCHAR(255) DEFAULT NULL, dom VARCHAR(255) DEFAULT NULL, tpm VARCHAR(255) DEFAULT NULL, availability VARCHAR(10) DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, price NUMERIC(14, 2) DEFAULT NULL, INDEX IDX_7F7A0F2BCD887EAF (form_factor_id), INDEX IDX_7F7A0F2BC13074D5 (raid_support_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motherboard_processor (motherboard_id INT NOT NULL, processor_id INT NOT NULL, INDEX IDX_2BE8FD216511E8A3 (motherboard_id), INDEX IDX_2BE8FD2137BAC19A (processor_id), PRIMARY KEY(motherboard_id, processor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motherboard_memory (motherboard_id INT NOT NULL, memory_id INT NOT NULL, INDEX IDX_AF8C44A16511E8A3 (motherboard_id), INDEX IDX_AF8C44A1CCC80CB3 (memory_id), PRIMARY KEY(motherboard_id, memory_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motherboard_pcie (motherboard_id INT NOT NULL, pcie_id INT NOT NULL, INDEX IDX_CB9BB9276511E8A3 (motherboard_id), INDEX IDX_CB9BB927FEBE7C8E (pcie_id), PRIMARY KEY(motherboard_id, pcie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motherboard_m2 (motherboard_id INT NOT NULL, m2_id INT NOT NULL, INDEX IDX_8375D9666511E8A3 (motherboard_id), INDEX IDX_8375D96664A268E9 (m2_id), PRIMARY KEY(motherboard_id, m2_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pcie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, version INT NOT NULL, format VARCHAR(4) DEFAULT NULL, availability VARCHAR(10) DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) DEFAULT NULL, url VARCHAR(255) NOT NULL, price NUMERIC(14, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE processor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, brand VARCHAR(100) DEFAULT NULL, availability VARCHAR(10) DEFAULT NULL, delivery DATETIME DEFAULT NULL, provider_reference VARCHAR(50) DEFAULT NULL, socket VARCHAR(50) DEFAULT NULL, upi INT DEFAULT NULL, cores INT DEFAULT NULL, threads INT DEFAULT NULL, tdp VARCHAR(20) DEFAULT NULL, base_freq VARCHAR(50) DEFAULT NULL, boost_freq VARCHAR(50) DEFAULT NULL, cache VARCHAR(50) DEFAULT NULL, max_mem_capacity VARCHAR(50) DEFAULT NULL, max_mem_speed VARCHAR(50) DEFAULT NULL, mem_type VARCHAR(50) DEFAULT NULL, ecc TINYINT(1) NOT NULL, grafics_processor TINYINT(1) NOT NULL, application VARCHAR(50) DEFAULT NULL, url VARCHAR(255) NOT NULL, price NUMERIC(14, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raid (id INT AUTO_INCREMENT NOT NULL, pcie_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, raid_level VARCHAR(50) DEFAULT NULL, interface_support VARCHAR(255) DEFAULT NULL, data_transfer_rate VARCHAR(50) DEFAULT NULL, nbr_port_sas INT NOT NULL, nbr_port_sata INT NOT NULL, INDEX IDX_578763B3FEBE7C8E (pcie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE barebone_motherboard ADD CONSTRAINT FK_BB59A5F54D3586AB FOREIGN KEY (barebone_id) REFERENCES barebone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE barebone_motherboard ADD CONSTRAINT FK_BB59A5F56511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE firewall ADD CONSTRAINT FK_48011B7ECD887EAF FOREIGN KEY (form_factor_id) REFERENCES form_factor (id)');
        $this->addSql('ALTER TABLE m2 ADD CONSTRAINT FK_595D5695AB0BE982 FOREIGN KEY (interface_id) REFERENCES pcie (id)');
        $this->addSql('ALTER TABLE m2 ADD CONSTRAINT FK_595D5695CD887EAF FOREIGN KEY (form_factor_id) REFERENCES form_factor (id)');
        $this->addSql('ALTER TABLE motherboard ADD CONSTRAINT FK_7F7A0F2BCD887EAF FOREIGN KEY (form_factor_id) REFERENCES form_factor (id)');
        $this->addSql('ALTER TABLE motherboard ADD CONSTRAINT FK_7F7A0F2BC13074D5 FOREIGN KEY (raid_support_id) REFERENCES raid (id)');
        $this->addSql('ALTER TABLE motherboard_processor ADD CONSTRAINT FK_2BE8FD216511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_processor ADD CONSTRAINT FK_2BE8FD2137BAC19A FOREIGN KEY (processor_id) REFERENCES processor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_memory ADD CONSTRAINT FK_AF8C44A16511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_memory ADD CONSTRAINT FK_AF8C44A1CCC80CB3 FOREIGN KEY (memory_id) REFERENCES memory (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_pcie ADD CONSTRAINT FK_CB9BB9276511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_pcie ADD CONSTRAINT FK_CB9BB927FEBE7C8E FOREIGN KEY (pcie_id) REFERENCES pcie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_m2 ADD CONSTRAINT FK_8375D9666511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE motherboard_m2 ADD CONSTRAINT FK_8375D96664A268E9 FOREIGN KEY (m2_id) REFERENCES m2 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE raid ADD CONSTRAINT FK_578763B3FEBE7C8E FOREIGN KEY (pcie_id) REFERENCES pcie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE barebone_motherboard DROP FOREIGN KEY FK_BB59A5F54D3586AB');
        $this->addSql('ALTER TABLE firewall DROP FOREIGN KEY FK_48011B7ECD887EAF');
        $this->addSql('ALTER TABLE m2 DROP FOREIGN KEY FK_595D5695CD887EAF');
        $this->addSql('ALTER TABLE motherboard DROP FOREIGN KEY FK_7F7A0F2BCD887EAF');
        $this->addSql('ALTER TABLE motherboard_m2 DROP FOREIGN KEY FK_8375D96664A268E9');
        $this->addSql('ALTER TABLE motherboard_memory DROP FOREIGN KEY FK_AF8C44A1CCC80CB3');
        $this->addSql('ALTER TABLE barebone_motherboard DROP FOREIGN KEY FK_BB59A5F56511E8A3');
        $this->addSql('ALTER TABLE motherboard_processor DROP FOREIGN KEY FK_2BE8FD216511E8A3');
        $this->addSql('ALTER TABLE motherboard_memory DROP FOREIGN KEY FK_AF8C44A16511E8A3');
        $this->addSql('ALTER TABLE motherboard_pcie DROP FOREIGN KEY FK_CB9BB9276511E8A3');
        $this->addSql('ALTER TABLE motherboard_m2 DROP FOREIGN KEY FK_8375D9666511E8A3');
        $this->addSql('ALTER TABLE m2 DROP FOREIGN KEY FK_595D5695AB0BE982');
        $this->addSql('ALTER TABLE motherboard_pcie DROP FOREIGN KEY FK_CB9BB927FEBE7C8E');
        $this->addSql('ALTER TABLE raid DROP FOREIGN KEY FK_578763B3FEBE7C8E');
        $this->addSql('ALTER TABLE motherboard_processor DROP FOREIGN KEY FK_2BE8FD2137BAC19A');
        $this->addSql('ALTER TABLE motherboard DROP FOREIGN KEY FK_7F7A0F2BC13074D5');
        $this->addSql('DROP TABLE barebone');
        $this->addSql('DROP TABLE barebone_motherboard');
        $this->addSql('DROP TABLE firewall');
        $this->addSql('DROP TABLE form_factor');
        $this->addSql('DROP TABLE m2');
        $this->addSql('DROP TABLE memory');
        $this->addSql('DROP TABLE motherboard');
        $this->addSql('DROP TABLE motherboard_processor');
        $this->addSql('DROP TABLE motherboard_memory');
        $this->addSql('DROP TABLE motherboard_pcie');
        $this->addSql('DROP TABLE motherboard_m2');
        $this->addSql('DROP TABLE pcie');
        $this->addSql('DROP TABLE processor');
        $this->addSql('DROP TABLE raid');
    }
}
