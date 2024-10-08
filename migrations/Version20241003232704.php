<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241003232704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clasificacion_decimal_dewey (id INT AUTO_INCREMENT NOT NULL, numero_cdd VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE libro ADD numero_cdd_id INT NOT NULL, ADD ubicacion_fisica VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE libro ADD CONSTRAINT FK_5799AD2B26936296 FOREIGN KEY (numero_cdd_id) REFERENCES clasificacion_decimal_dewey (id)');
        $this->addSql('CREATE INDEX IDX_5799AD2B26936296 ON libro (numero_cdd_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE libro DROP FOREIGN KEY FK_5799AD2B26936296');
        $this->addSql('DROP TABLE clasificacion_decimal_dewey');
        $this->addSql('DROP INDEX IDX_5799AD2B26936296 ON libro');
        $this->addSql('ALTER TABLE libro DROP numero_cdd_id, DROP ubicacion_fisica');
    }
}
