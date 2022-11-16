<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221109124441 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE users_channels (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', channel_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_8855C96CA76ED395 (user_id), INDEX IDX_8855C96C72F5A1AA (channel_id), PRIMARY KEY(user_id, channel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_channels ADD CONSTRAINT FK_8855C96CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_channels ADD CONSTRAINT FK_8855C96C72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users_channels DROP FOREIGN KEY FK_8855C96CA76ED395');
        $this->addSql('ALTER TABLE users_channels DROP FOREIGN KEY FK_8855C96C72F5A1AA');
        $this->addSql('DROP TABLE users_channels');
    }
}
