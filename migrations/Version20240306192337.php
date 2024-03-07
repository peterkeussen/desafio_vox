<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306192337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE empresa_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE socio_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE empresa (id INT NOT NULL, nome VARCHAR(100) NOT NULL, razao_social VARCHAR(100) NOT NULL, cnpj VARCHAR(18) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE empresa_socio (empresa_id INT NOT NULL, socio_id INT NOT NULL, PRIMARY KEY(empresa_id, socio_id))');
        $this->addSql('CREATE INDEX IDX_BC6D4E80521E1991 ON empresa_socio (empresa_id)');
        $this->addSql('CREATE INDEX IDX_BC6D4E80DA04E6A9 ON empresa_socio (socio_id)');
        $this->addSql('CREATE TABLE socio (id INT NOT NULL, nome VARCHAR(100) NOT NULL, cpf VARCHAR(14) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE empresa_socio ADD CONSTRAINT FK_BC6D4E80521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE empresa_socio ADD CONSTRAINT FK_BC6D4E80DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE empresa_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE socio_id_seq CASCADE');
        $this->addSql('ALTER TABLE empresa_socio DROP CONSTRAINT FK_BC6D4E80521E1991');
        $this->addSql('ALTER TABLE empresa_socio DROP CONSTRAINT FK_BC6D4E80DA04E6A9');
        $this->addSql('DROP TABLE empresa');
        $this->addSql('DROP TABLE empresa_socio');
        $this->addSql('DROP TABLE socio');
    }
}
