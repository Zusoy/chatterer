<?php

declare(strict_types=1);

namespace Infra\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230621142436 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users_channels DROP FOREIGN KEY FK_8855C96C72F5A1AA');
        $this->addSql('ALTER TABLE users_channels DROP FOREIGN KEY FK_8855C96CA76ED395');
        $this->addSql('DROP TABLE users_channels');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE users_channels (user_id CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:uuid)\', channel_id CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:uuid)\', INDEX IDX_8855C96CA76ED395 (user_id), INDEX IDX_8855C96C72F5A1AA (channel_id), PRIMARY KEY(user_id, channel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE users_channels ADD CONSTRAINT FK_8855C96C72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_channels ADD CONSTRAINT FK_8855C96CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
