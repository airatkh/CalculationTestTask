<?php

use yii\db\Schema;
use yii\db\Migration;
use yii\db\Expression;

class m170812_210951_InitCalculationCodes extends Migration
{

    /**
     *
     * CREATE TABLE IF NOT EXISTS `uremont`.`calculation` (
     *   `id` INT(11) NOT NULL AUTO_INCREMENT,
     *   `name` VARCHAR(125) NULL DEFAULT NULL,
     *   `calculation` BLOB NULL DEFAULT NULL,
     *   `created_at` DATETIME NULL DEFAULT NULL,
     *   `updated_at` DATETIME NULL DEFAULT NULL,
     *   `NE = InnoDB
     * AUTOdeleted_at` DATETIME NULL DEFAULT NULL,
     *   PRIMARY KEY (`id`))
     * ENGI_INCREMENT = 9
     * DEFAULT CHARACTER SET = utf8
     *
     *
     * CREATE TABLE IF NOT EXISTS `uremont`.`code` (
     *   `id` INT(11) NOT NULL AUTO_INCREMENT,
     *   `code` INT(11) NULL DEFAULT NULL,
     *   `created_at` DATETIME NULL DEFAULT NULL,
     *   `updated_at` DATETIME NULL DEFAULT NULL,
     *   `deleted_at` DATETIME NULL DEFAULT NULL,
     *   PRIMARY KEY (`id`))
     * ENGINE = InnoDB
     * AUTO_INCREMENT = 12
     * DEFAULT CHARACTER SET = utf8
     *
     *
     * CREATE TABLE IF NOT EXISTS `uremont`.`calculation_code` (
     *   `id` INT(11) NOT NULL AUTO_INCREMENT,
     *   `calculation_id` INT(11) NOT NULL,
     *   `code_id` INT(11) NOT NULL,
     *   PRIMARY KEY (`id`),
     *   INDEX `fk_calculation_code_calculation_idx` (`calculation_id` ASC),
     *   INDEX `fk_calculation_code_code1_idx` (`code_id` ASC),
     *   CONSTRAINT `fk_calculation_code_calculation`
     *     FOREIGN KEY (`calculation_id`)
     *     REFERENCES `uremont`.`calculation` (`id`)
     *     ON DELETE NO ACTION
     *     ON UPDATE NO ACTION,
     *   CONSTRAINT `fk_calculation_code_code1`
     *     FOREIGN KEY (`code_id`)
     *     REFERENCES `uremont`.`code` (`id`)
     *     ON DELETE NO ACTION
     *     ON UPDATE NO ACTION)
     * ENGINE = InnoDB
     * AUTO_INCREMENT = 19
     * DEFAULT CHARACTER SET = utf8
     *
     *
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable("calculation", [
            'id' => Schema::TYPE_PK,
            'name'=>Schema::TYPE_STRING."(125) COLLATE utf8_unicode_ci NULL",
            'calculation'=>Schema::TYPE_TEXT." COLLATE utf8_unicode_ci DEFAULT NULL",
            'created_at' => Schema::TYPE_DATETIME . " NOT NULL",
            'updated_at' => Schema::TYPE_DATETIME,
            'deleted_at' => Schema::TYPE_DATETIME,
        ], $tableOptions);

        $this->createTable("code", [
            'id' => Schema::TYPE_PK,
            'code'=>Schema::TYPE_INTEGER."(11) DEFAULT NULL",
            'created_at' => Schema::TYPE_DATETIME . " NOT NULL",
            'updated_at' => Schema::TYPE_DATETIME,
            'deleted_at' => Schema::TYPE_DATETIME,
        ], $tableOptions);


        $this->createTable("calculation_code", [
            'id' => Schema::TYPE_PK,
            'calculation_id' => Schema::TYPE_INTEGER,
            'code_id' => Schema::TYPE_INTEGER,
            'code'=>Schema::TYPE_INTEGER."(11) DEFAULT NULL",
            'created_at' => Schema::TYPE_DATETIME . " NOT NULL",
            'updated_at' => Schema::TYPE_DATETIME,
            'deleted_at' => Schema::TYPE_DATETIME,
        ], $tableOptions);
        $this->addForeignKey('fk_calculation_code_calculation', 'calculation_code', ['calculation_id'], '{{%calculation}}', ['id']);
        $this->addForeignKey('fk_calculation_code_code1', 'calculation_code', ['code_id'], '{{%code}}', ['id']);

    }

    public function safeDown()
    {
        $this->dropTable("calculation_code");
        $this->dropTable("calculation");
        $this->dropTable("code");
        return true;
    }
}
