<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702143934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE serie_id_seq INCREMENT BY 100 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE campus (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9D0968116C6E55B5 ON campus (nom)');
        $this->addSql('CREATE TABLE etat (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_55CAF762A4D60759 ON etat (libelle)');
        $this->addSql('CREATE TABLE lieu (id INT NOT NULL, ville_id INT NOT NULL, nom VARCHAR(255) NOT NULL, rue VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2F577D59A73F0036 ON lieu (ville_id)');
        $this->addSql('CREATE TABLE participant (id INT NOT NULL, campus_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, pseudo VARCHAR(255) DEFAULT NULL, telephone VARCHAR(12) DEFAULT NULL, mail VARCHAR(180) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, administrateur BOOLEAN NOT NULL, actif BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D79F6B1186CC499D ON participant (pseudo)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D79F6B115126AC48 ON participant (mail)');
        $this->addSql('CREATE INDEX IDX_D79F6B11AF5D55E1 ON participant (campus_id)');
        $this->addSql('CREATE TABLE sortie (id INT NOT NULL, lieu_id INT NOT NULL, etat_id INT NOT NULL, organisateur_id INT NOT NULL, campus_id INT NOT NULL, nom VARCHAR(255) NOT NULL, date_heure_debut TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, duree INT DEFAULT NULL, date_limite_inscription DATE DEFAULT NULL, nb_inscriptions_max INT DEFAULT NULL, infos_sortie TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3C3FD3F26AB213CC ON sortie (lieu_id)');
        $this->addSql('CREATE INDEX IDX_3C3FD3F2D5E86FF ON sortie (etat_id)');
        $this->addSql('CREATE INDEX IDX_3C3FD3F2D936B2FA ON sortie (organisateur_id)');
        $this->addSql('CREATE INDEX IDX_3C3FD3F2AF5D55E1 ON sortie (campus_id)');
        $this->addSql('CREATE TABLE sortie_participant (sortie_id INT NOT NULL, participant_id INT NOT NULL, PRIMARY KEY(sortie_id, participant_id))');
        $this->addSql('CREATE INDEX IDX_E6D4CDADCC72D953 ON sortie_participant (sortie_id)');
        $this->addSql('CREATE INDEX IDX_E6D4CDAD9D1C3019 ON sortie_participant (participant_id)');
        $this->addSql('CREATE TABLE ville (id INT NOT NULL, nom VARCHAR(255) NOT NULL, code_postal VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D59A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F26AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2D936B2FA FOREIGN KEY (organisateur_id) REFERENCES participant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sortie_participant ADD CONSTRAINT FK_E6D4CDADCC72D953 FOREIGN KEY (sortie_id) REFERENCES sortie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sortie_participant ADD CONSTRAINT FK_E6D4CDAD9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE serie_id_seq CASCADE');
        $this->addSql('ALTER TABLE lieu DROP CONSTRAINT FK_2F577D59A73F0036');
        $this->addSql('ALTER TABLE participant DROP CONSTRAINT FK_D79F6B11AF5D55E1');
        $this->addSql('ALTER TABLE sortie DROP CONSTRAINT FK_3C3FD3F26AB213CC');
        $this->addSql('ALTER TABLE sortie DROP CONSTRAINT FK_3C3FD3F2D5E86FF');
        $this->addSql('ALTER TABLE sortie DROP CONSTRAINT FK_3C3FD3F2D936B2FA');
        $this->addSql('ALTER TABLE sortie DROP CONSTRAINT FK_3C3FD3F2AF5D55E1');
        $this->addSql('ALTER TABLE sortie_participant DROP CONSTRAINT FK_E6D4CDADCC72D953');
        $this->addSql('ALTER TABLE sortie_participant DROP CONSTRAINT FK_E6D4CDAD9D1C3019');
        $this->addSql('DROP TABLE campus');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE sortie');
        $this->addSql('DROP TABLE sortie_participant');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
