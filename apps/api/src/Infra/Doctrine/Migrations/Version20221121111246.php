<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221121111246 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('DROP INDEX unique_name ON channel');
        $this->addSql('CREATE UNIQUE INDEX unique_name ON channel (station_id, name)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX unique_name ON channel');
        $this->addSql('CREATE UNIQUE INDEX unique_name ON channel (name)');
    }
}
