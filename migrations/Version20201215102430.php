<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201215102430 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stack_stack_type (stack_id INT NOT NULL, stack_type_id INT NOT NULL, INDEX IDX_E59CBFF337C70060 (stack_id), INDEX IDX_E59CBFF38E9CB736 (stack_type_id), PRIMARY KEY(stack_id, stack_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stack_stack_type ADD CONSTRAINT FK_E59CBFF337C70060 FOREIGN KEY (stack_id) REFERENCES stack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stack_stack_type ADD CONSTRAINT FK_E59CBFF38E9CB736 FOREIGN KEY (stack_type_id) REFERENCES stack_type (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE stack_stack_type');
    }
}
