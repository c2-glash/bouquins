<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200925093529 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emprunt (id INT AUTO_INCREMENT NOT NULL, propriete_id INT NOT NULL, utilisateur_id INT NOT NULL, date_emprunt DATETIME NOT NULL, date_rendu DATETIME DEFAULT NULL, INDEX IDX_364071D718566CAF (propriete_id), INDEX IDX_364071D7FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D718566CAF FOREIGN KEY (propriete_id) REFERENCES propriete (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE propriete DROP FOREIGN KEY FK_73A85B9337D925CB');
        $this->addSql('ALTER TABLE propriete DROP FOREIGN KEY FK_73A85B93FB88E14F');
        $this->addSql('ALTER TABLE propriete ADD CONSTRAINT FK_73A85B9337D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE propriete ADD CONSTRAINT FK_73A85B93FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE emprunt');
        $this->addSql('ALTER TABLE propriete DROP FOREIGN KEY FK_73A85B9337D925CB');
        $this->addSql('ALTER TABLE propriete DROP FOREIGN KEY FK_73A85B93FB88E14F');
        $this->addSql('ALTER TABLE propriete ADD CONSTRAINT FK_73A85B9337D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE propriete ADD CONSTRAINT FK_73A85B93FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }
}
