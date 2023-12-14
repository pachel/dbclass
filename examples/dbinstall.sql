CREATE DATABASE `dbclass_test` COLLATE 'utf8_general_ci';
USE `dbclass_test`;
CREATE TABLE `__users` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL DEFAULT '0',
	`type` SMALLINT(2) NOT NULL DEFAULT '0',
	`email` VARCHAR(50) NOT NULL DEFAULT '0',
	`inserted` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
)
ENGINE=InnoDB
AUTO_INCREMENT=1;


INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Sárga Laci','9','Sárga@Laci.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Zöld Ildi','9','Zöld@Ildi.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Fehér Niki','7','Fehér@Niki.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Kék Réka','4','Kék@Réka.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Fekete Réka','5','Fekete@Réka.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Fehér Piros','3','Fehér@Piros.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Barna Imi','5','Barna@Imi.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Piros Piros','8','Piros@Piros.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Lila Géza','10','Lila@Géza.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Fekete Gizi','6','Fekete@Gizi.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Barna Piros','9','Barna@Piros.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Sárga Gizi','7','Sárga@Gizi.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Fehér Niki','10','Fehér@Niki.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Zöld Anna','6','Zöld@Anna.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Fekete Laci','2','Fekete@Laci.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Fekete Lili','6','Fekete@Lili.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Kék Piros','1','Kék@Piros.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Barna Anna','5','Barna@Anna.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Zöld Lili','10','Zöld@Lili.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Sárga Feri','2','Sárga@Feri.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Rózsaszín Imi','10','Rózsaszín@Imi.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Zöld Laci','5','Zöld@Laci.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Rózsaszín Ildi','9','Rózsaszín@Ildi.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Lila Anna','6','Lila@Anna.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Lila Feri','8','Lila@Feri.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Rózsaszín Lili','9','Rózsaszín@Lili.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Piros Anna','6','Piros@Anna.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Zöld Réka','8','Zöld@Réka.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Zöld Imi','10','Zöld@Imi.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Piros Anna','5','Piros@Anna.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Piros Feri','8','Piros@Feri.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Sárga Géza','8','Sárga@Géza.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Lila Ildi','7','Lila@Ildi.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Zöld Laci','9','Zöld@Laci.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Zöld Réka','4','Zöld@Réka.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Rózsaszín Lili','4','Rózsaszín@Lili.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Zöld Niki','10','Zöld@Niki.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Kék Anna','8','Kék@Anna.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Lila Imi','8','Lila@Imi.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Barna Niki','7','Barna@Niki.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Lila Sanya','6','Lila@Sanya.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Barna Niki','1','Barna@Niki.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Fekete Géza','5','Fekete@Géza.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Rózsaszín Anna','5','Rózsaszín@Anna.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Fehér Ildi','2','Fehér@Ildi.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Rózsaszín Imi','7','Rózsaszín@Imi.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Fehér Anna','2','Fehér@Anna.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Fekete Réka','8','Fekete@Réka.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Kék Laci','10','Kék@Laci.fake');
INSERT INTO `__users` (`name`,`type`,`email`) VALUES ('Sárga Niki','9','Sárga@Niki.fake');