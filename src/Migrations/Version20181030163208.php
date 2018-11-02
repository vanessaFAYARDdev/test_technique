<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181030163208 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contract (id INT AUTO_INCREMENT NOT NULL, interim_id INT NOT NULL, status_id INT NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, INDEX IDX_E98F285929C96BD8 (interim_id), INDEX IDX_E98F28596BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interim (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(30) NOT NULL, last_name VARCHAR(30) NOT NULL, zip_code VARCHAR(5) NOT NULL, city VARCHAR(40) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission_tracking (id INT AUTO_INCREMENT NOT NULL, contract_id INT NOT NULL, interim_id INT NOT NULL, status_id INT NOT NULL, score SMALLINT NOT NULL, UNIQUE INDEX UNIQ_A08063A52576E0FD (contract_id), INDEX IDX_A08063A529C96BD8 (interim_id), INDEX IDX_A08063A56BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F285929C96BD8 FOREIGN KEY (interim_id) REFERENCES interim (id)');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F28596BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE mission_tracking ADD CONSTRAINT FK_A08063A52576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE mission_tracking ADD CONSTRAINT FK_A08063A529C96BD8 FOREIGN KEY (interim_id) REFERENCES interim (id)');
        $this->addSql('ALTER TABLE mission_tracking ADD CONSTRAINT FK_A08063A56BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mission_tracking DROP FOREIGN KEY FK_A08063A52576E0FD');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F285929C96BD8');
        $this->addSql('ALTER TABLE mission_tracking DROP FOREIGN KEY FK_A08063A529C96BD8');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F28596BF700BD');
        $this->addSql('ALTER TABLE mission_tracking DROP FOREIGN KEY FK_A08063A56BF700BD');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE interim');
        $this->addSql('DROP TABLE mission_tracking');
        $this->addSql('DROP TABLE status');
    }
}
