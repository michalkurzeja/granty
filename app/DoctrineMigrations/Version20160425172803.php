<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160425172803 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE application_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE application (id INT NOT NULL, user_id INT DEFAULT NULL, year INT NOT NULL, topic VARCHAR(255) NOT NULL, meritoric_justification TEXT DEFAULT NULL, current_knowledge TEXT DEFAULT NULL, scientific_achievements TEXT DEFAULT NULL, applicants_projects TEXT DEFAULT NULL, forseeable_goals TEXT DEFAULT NULL, schedule_of_work TEXT DEFAULT NULL, external_financing BOOLEAN NOT NULL, planned_expenses_total DOUBLE PRECISION NOT NULL, planned_expenses_in_current_year DOUBLE PRECISION NOT NULL, expenses_explanation TEXT DEFAULT NULL, project_director VARCHAR(255) NOT NULL, organization_director VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A45BDDC1A76ED395 ON application (user_id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE application_id_seq CASCADE');
        $this->addSql('DROP TABLE application');
    }
}
