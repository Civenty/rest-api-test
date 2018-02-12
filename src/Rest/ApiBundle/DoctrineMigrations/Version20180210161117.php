<?php

namespace Rest\ApiBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180210161117 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE campaign_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE campaign_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE campaign (id INT NOT NULL, users_id INT DEFAULT NULL, campaign_type_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1F1512DD67B3B43D ON campaign (users_id)');
        $this->addSql('CREATE INDEX IDX_1F1512DD6DF610BF ON campaign (campaign_type_id)');
        $this->addSql('CREATE TABLE campaign_type (id INT NOT NULL, status BOOLEAN DEFAULT \'true\' NOT NULL, name VARCHAR(255) NOT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, name VARCHAR(255) NOT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_updated TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E992FC23A8 ON users (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9A0D96FBF ON users (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9C05FB297 ON users (confirmation_token)');
        $this->addSql('COMMENT ON COLUMN users.roles IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE campaign ADD CONSTRAINT FK_1F1512DD67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE campaign ADD CONSTRAINT FK_1F1512DD6DF610BF FOREIGN KEY (campaign_type_id) REFERENCES campaign_type (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE campaign DROP CONSTRAINT FK_1F1512DD6DF610BF');
        $this->addSql('ALTER TABLE campaign DROP CONSTRAINT FK_1F1512DD67B3B43D');
        $this->addSql('DROP SEQUENCE campaign_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE campaign_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP TABLE campaign');
        $this->addSql('DROP TABLE campaign_type');
        $this->addSql('DROP TABLE users');
    }
}
