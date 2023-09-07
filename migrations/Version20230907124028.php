<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230907124028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bill (id INT AUTO_INCREMENT NOT NULL, paiment_id INT DEFAULT NULL, user_id INT DEFAULT NULL, number INT NOT NULL, amount INT NOT NULL, INDEX IDX_7A2119E378789290 (paiment_id), INDEX IDX_7A2119E3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, link VARCHAR(191) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_product (images_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_4C371ACFD44F05E5 (images_id), INDEX IDX_4C371ACF4584665A (product_id), PRIMARY KEY(images_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE platform (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE platform_product (platform_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_C67ACEFFFFE6496F (platform_id), INDEX IDX_C67ACEFF4584665A (product_id), PRIMARY KEY(platform_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, bill_id INT DEFAULT NULL, title VARCHAR(191) NOT NULL, quantity INT NOT NULL, release_date DATETIME DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, description LONGTEXT NOT NULL, rate INT DEFAULT NULL, productcontent LONGTEXT DEFAULT NULL, requiredspecs LONGTEXT DEFAULT NULL, edition VARCHAR(191) DEFAULT NULL, INDEX IDX_D34A04AD1A8C12F5 (bill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `system` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE system_platform (system_id INT NOT NULL, platform_id INT NOT NULL, INDEX IDX_50B86149D0952FA5 (system_id), INDEX IDX_50B86149FFE6496F (platform_id), PRIMARY KEY(system_id, platform_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_product (tag_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_E17B2907BAD26311 (tag_id), INDEX IDX_E17B29074584665A (product_id), PRIMARY KEY(tag_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(191) DEFAULT NULL, age INT DEFAULT NULL, isadmin TINYINT(1) NOT NULL, image VARCHAR(191) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E378789290 FOREIGN KEY (paiment_id) REFERENCES paiment (id)');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE images_product ADD CONSTRAINT FK_4C371ACFD44F05E5 FOREIGN KEY (images_id) REFERENCES images (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images_product ADD CONSTRAINT FK_4C371ACF4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE platform_product ADD CONSTRAINT FK_C67ACEFFFFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE platform_product ADD CONSTRAINT FK_C67ACEFF4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD1A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id)');
        $this->addSql('ALTER TABLE system_platform ADD CONSTRAINT FK_50B86149D0952FA5 FOREIGN KEY (system_id) REFERENCES `system` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE system_platform ADD CONSTRAINT FK_50B86149FFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_product ADD CONSTRAINT FK_E17B2907BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_product ADD CONSTRAINT FK_E17B29074584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E378789290');
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E3A76ED395');
        $this->addSql('ALTER TABLE images_product DROP FOREIGN KEY FK_4C371ACFD44F05E5');
        $this->addSql('ALTER TABLE images_product DROP FOREIGN KEY FK_4C371ACF4584665A');
        $this->addSql('ALTER TABLE platform_product DROP FOREIGN KEY FK_C67ACEFFFFE6496F');
        $this->addSql('ALTER TABLE platform_product DROP FOREIGN KEY FK_C67ACEFF4584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD1A8C12F5');
        $this->addSql('ALTER TABLE system_platform DROP FOREIGN KEY FK_50B86149D0952FA5');
        $this->addSql('ALTER TABLE system_platform DROP FOREIGN KEY FK_50B86149FFE6496F');
        $this->addSql('ALTER TABLE tag_product DROP FOREIGN KEY FK_E17B2907BAD26311');
        $this->addSql('ALTER TABLE tag_product DROP FOREIGN KEY FK_E17B29074584665A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F92F3E70');
        $this->addSql('DROP TABLE bill');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE images_product');
        $this->addSql('DROP TABLE paiment');
        $this->addSql('DROP TABLE platform');
        $this->addSql('DROP TABLE platform_product');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE `system`');
        $this->addSql('DROP TABLE system_platform');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_product');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
