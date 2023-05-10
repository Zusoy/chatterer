<?php

declare(strict_types=1);

namespace Infra\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221107165724 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE invitation (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', station_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', token_value VARCHAR(255) NOT NULL, INDEX IDX_F11D61A221BDB235 (station_id), UNIQUE INDEX unique_token (token_value), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A221BDB235 FOREIGN KEY (station_id) REFERENCES station (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A221BDB235');
        $this->addSql('DROP TABLE invitation');
    }
}
