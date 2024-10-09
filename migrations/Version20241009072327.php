<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009072327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE compartment (id INT AUTO_INCREMENT NOT NULL, medecine_box_id INT DEFAULT NULL, state TINYINT(1) NOT NULL, pill_number INT NOT NULL, UNIQUE INDEX UNIQ_CF1E91C64B001634 (medecine_box_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE drug (id INT AUTO_INCREMENT NOT NULL, cis CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, dosage VARCHAR(255) NOT NULL, indication VARCHAR(255) DEFAULT NULL, contraindication VARCHAR(255) DEFAULT NULL, secondary_effect VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medecine_box (id INT AUTO_INCREMENT NOT NULL, drug_id INT NOT NULL, usr_id INT DEFAULT NULL, treatment_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, expiration_date DATE NOT NULL, conditioning INT DEFAULT NULL, price INT DEFAULT NULL, manufacturer VARCHAR(255) DEFAULT NULL, INDEX IDX_65B347B7AABCA765 (drug_id), INDEX IDX_65B347B7C69D3FB (usr_id), INDEX IDX_65B347B7471C0366 (treatment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE treatment (id INT AUTO_INCREMENT NOT NULL, frequency INT NOT NULL, last_taking_time DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE treatment_time (id INT AUTO_INCREMENT NOT NULL, treatment_id INT NOT NULL, time TIME NOT NULL, INDEX IDX_AC575454471C0366 (treatment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, height INT DEFAULT NULL, weight INT DEFAULT NULL, birth_date DATE NOT NULL, phone_number VARCHAR(10) DEFAULT NULL, emergency_phone_number VARCHAR(10) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compartment ADD CONSTRAINT FK_CF1E91C64B001634 FOREIGN KEY (medecine_box_id) REFERENCES medecine_box (id)');
        $this->addSql('ALTER TABLE medecine_box ADD CONSTRAINT FK_65B347B7AABCA765 FOREIGN KEY (drug_id) REFERENCES drug (id)');
        $this->addSql('ALTER TABLE medecine_box ADD CONSTRAINT FK_65B347B7C69D3FB FOREIGN KEY (usr_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE medecine_box ADD CONSTRAINT FK_65B347B7471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id)');
        $this->addSql('ALTER TABLE treatment_time ADD CONSTRAINT FK_AC575454471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compartment DROP FOREIGN KEY FK_CF1E91C64B001634');
        $this->addSql('ALTER TABLE medecine_box DROP FOREIGN KEY FK_65B347B7AABCA765');
        $this->addSql('ALTER TABLE medecine_box DROP FOREIGN KEY FK_65B347B7C69D3FB');
        $this->addSql('ALTER TABLE medecine_box DROP FOREIGN KEY FK_65B347B7471C0366');
        $this->addSql('ALTER TABLE treatment_time DROP FOREIGN KEY FK_AC575454471C0366');
        $this->addSql('DROP TABLE compartment');
        $this->addSql('DROP TABLE drug');
        $this->addSql('DROP TABLE medecine_box');
        $this->addSql('DROP TABLE treatment');
        $this->addSql('DROP TABLE treatment_time');
        $this->addSql('DROP TABLE `user`');
    }
}
