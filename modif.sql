ALTER TABLE  `voucher` ADD  `id_dest` INT UNSIGNED NOT NULL AFTER  `id_client` ;

CREATE TABLE IF NOT EXISTS `promo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_promo` enum('euro','pourcentage') NOT NULL,
  `is_global` enum('1','0') NOT NULL,
  `taux` int(10) unsigned NOT NULL,
  `titre` varchar(100) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `promo_salle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_salle` int(10) unsigned NOT NULL,
  `id_promo` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
