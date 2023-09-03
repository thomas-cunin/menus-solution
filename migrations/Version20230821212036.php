<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230821212036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_dish_or_drink (category_id INT NOT NULL, dish_or_drink_id INT NOT NULL, INDEX IDX_267D05B212469DE2 (category_id), INDEX IDX_267D05B27665AF28 (dish_or_drink_id), PRIMARY KEY(category_id, dish_or_drink_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dish_or_drink (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, prices LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, place_id INT DEFAULT NULL, INDEX IDX_7D053A93DA6A219 (place_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_dish_or_drink (menu_id INT NOT NULL, dish_or_drink_id INT NOT NULL, INDEX IDX_9E65756FCCD7E912 (menu_id), INDEX IDX_9E65756F7665AF28 (dish_or_drink_id), PRIMARY KEY(menu_id, dish_or_drink_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_dish_or_drink ADD CONSTRAINT FK_267D05B212469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_dish_or_drink ADD CONSTRAINT FK_267D05B27665AF28 FOREIGN KEY (dish_or_drink_id) REFERENCES dish_or_drink (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE menu_dish_or_drink ADD CONSTRAINT FK_9E65756FCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_dish_or_drink ADD CONSTRAINT FK_9E65756F7665AF28 FOREIGN KEY (dish_or_drink_id) REFERENCES dish_or_drink (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD place_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649DA6A219 ON user (place_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649DA6A219');
        $this->addSql('ALTER TABLE category_dish_or_drink DROP FOREIGN KEY FK_267D05B212469DE2');
        $this->addSql('ALTER TABLE category_dish_or_drink DROP FOREIGN KEY FK_267D05B27665AF28');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93DA6A219');
        $this->addSql('ALTER TABLE menu_dish_or_drink DROP FOREIGN KEY FK_9E65756FCCD7E912');
        $this->addSql('ALTER TABLE menu_dish_or_drink DROP FOREIGN KEY FK_9E65756F7665AF28');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_dish_or_drink');
        $this->addSql('DROP TABLE dish_or_drink');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_dish_or_drink');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP INDEX IDX_8D93D649DA6A219 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP place_id');
    }
}
