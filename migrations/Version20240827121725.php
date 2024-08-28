<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240827121725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE piece (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, category_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_44CA0B23A76ED395 (user_id), INDEX IDX_44CA0B2312469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE piece ADD CONSTRAINT FK_44CA0B23A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE piece ADD CONSTRAINT FK_44CA0B2312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE piece DROP FOREIGN KEY FK_44CA0B23A76ED395');
        $this->addSql('ALTER TABLE piece DROP FOREIGN KEY FK_44CA0B2312469DE2');
        $this->addSql('DROP TABLE piece');
    }
}
