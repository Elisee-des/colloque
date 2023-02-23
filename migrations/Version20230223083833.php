<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223083833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD presence_resumer TINYINT(1) DEFAULT NULL, ADD presence_image_payement TINYINT(1) DEFAULT NULL, DROP image_payement, DROP communication, DROP resume');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` ADD image_payement VARCHAR(255) DEFAULT NULL, ADD communication VARCHAR(255) DEFAULT NULL, ADD resume VARCHAR(255) DEFAULT NULL, DROP presence_resumer, DROP presence_image_payement');
    }
}
