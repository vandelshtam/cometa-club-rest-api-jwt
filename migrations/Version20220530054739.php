<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220530054739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD user_id INT NOT NULL, ADD referral_link VARCHAR(255) NOT NULL, ADD personal_data_id INT DEFAULT NULL, ADD pesonal_code VARCHAR(255) DEFAULT NULL, ADD secret_code VARCHAR(255) NOT NULL, ADD locale VARCHAR(255) DEFAULT NULL, ADD pakage_status INT DEFAULT NULL, ADD pakage_id INT DEFAULT NULL, ADD multi_pakage INT DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP user_id, DROP referral_link, DROP personal_data_id, DROP pesonal_code, DROP secret_code, DROP locale, DROP pakage_status, DROP pakage_id, DROP multi_pakage, DROP created_at, DROP updated_at, CHANGE last_name last_name VARCHAR(255) NOT NULL');
    }
}
