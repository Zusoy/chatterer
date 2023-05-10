<?php

declare(strict_types=1);

namespace Infra\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221107170755 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE users_stations (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', station_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_DCB65E33A76ED395 (user_id), INDEX IDX_DCB65E3321BDB235 (station_id), PRIMARY KEY(user_id, station_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_stations ADD CONSTRAINT FK_DCB65E33A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_stations ADD CONSTRAINT FK_DCB65E3321BDB235 FOREIGN KEY (station_id) REFERENCES station (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users_stations DROP FOREIGN KEY FK_DCB65E33A76ED395');
        $this->addSql('ALTER TABLE users_stations DROP FOREIGN KEY FK_DCB65E3321BDB235');
        $this->addSql('DROP TABLE users_stations');
    }
}
