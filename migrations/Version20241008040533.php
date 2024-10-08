<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241008040533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $turnos = [
            "Mañana",
            "Tarde"
        ];

        foreach ($turnos as $turno) {
            $this->addSql("INSERT INTO turno(nombre) VALUES('$turno')");
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM turno');
    }
}
