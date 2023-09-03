<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230903120120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE price_quantity (id INT AUTO_INCREMENT NOT NULL, dish_or_drink_id INT NOT NULL, price NUMERIC(10, 2) NOT NULL, quantity VARCHAR(255) NOT NULL, INDEX IDX_FD452D217665AF28 (dish_or_drink_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE price_quantity ADD CONSTRAINT FK_FD452D217665AF28 FOREIGN KEY (dish_or_drink_id) REFERENCES dish_or_drink (id)');
        $this->addSql('ALTER TABLE dish_or_drink ADD type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE price_quantity DROP FOREIGN KEY FK_FD452D217665AF28');
        $this->addSql('DROP TABLE price_quantity');
        $this->addSql('ALTER TABLE dish_or_drink DROP type');
    }
}
