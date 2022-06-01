<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220531113115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction_table (id INT AUTO_INCREMENT NOT NULL, network_id INT DEFAULT NULL, user_id INT DEFAULT NULL, pakage_id INT DEFAULT NULL, cash INT DEFAULT NULL, direct DOUBLE PRECISION DEFAULT NULL, withdrawal_to_wallet DOUBLE PRECISION DEFAULT NULL, withdrawal DOUBLE PRECISION DEFAULT NULL, application_withdrawal DOUBLE PRECISION DEFAULT NULL, application_withdrawal_status INT DEFAULT NULL, network_activation_id INT DEFAULT NULL, type INT DEFAULT NULL, pakage_price INT DEFAULT NULL, wallet_id INT DEFAULT NULL, somme DOUBLE PRECISION DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE transaction_table');
    }
}
