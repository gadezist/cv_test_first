<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220129140444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE click_link (id INT AUTO_INCREMENT NOT NULL, link_id INT NOT NULL, ip VARCHAR(255) DEFAULT NULL, user_agent VARCHAR(255) DEFAULT NULL, click_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D96FA933ADA40271 (link_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link (id INT AUTO_INCREMENT NOT NULL, long_url VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, tags JSON DEFAULT NULL, short_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE click_link ADD CONSTRAINT FK_D96FA933ADA40271 FOREIGN KEY (link_id) REFERENCES link (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE click_link DROP FOREIGN KEY FK_D96FA933ADA40271');
        $this->addSql('DROP TABLE click_link');
        $this->addSql('DROP TABLE link');
    }
}
