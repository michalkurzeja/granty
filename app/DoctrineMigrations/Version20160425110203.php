<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160425110203 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE app_user ADD first_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE app_user ADD last_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE app_user ADD degree VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE app_user ADD date_of_birth DATE NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE app_user DROP first_name');
        $this->addSql('ALTER TABLE app_user DROP last_name');
        $this->addSql('ALTER TABLE app_user DROP degree');
        $this->addSql('ALTER TABLE app_user DROP date_of_birth');
    }
}
