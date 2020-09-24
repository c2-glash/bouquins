<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200924144211 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE propriete DROP FOREIGN KEY FK_73A85B9337D925CB');
        $this->addSql('ALTER TABLE propriete DROP FOREIGN KEY FK_73A85B93FB88E14F');
        $this->addSql('ALTER TABLE propriete ADD CONSTRAINT FK_73A85B9337D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE propriete ADD CONSTRAINT FK_73A85B93FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE propriete DROP FOREIGN KEY FK_73A85B9337D925CB');
        $this->addSql('ALTER TABLE propriete DROP FOREIGN KEY FK_73A85B93FB88E14F');
        $this->addSql('ALTER TABLE propriete ADD CONSTRAINT FK_73A85B9337D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE propriete ADD CONSTRAINT FK_73A85B93FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }
}
