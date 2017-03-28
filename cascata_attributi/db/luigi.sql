-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Creato il: Mar 28, 2017 alle 17:14
-- Versione del server: 5.6.26
-- Versione PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luigi`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_admincp`
--

CREATE TABLE IF NOT EXISTS `ec_admincp` (
  `id_admin` int(11) unsigned NOT NULL,
  `codice` varchar(255) DEFAULT NULL,
  `livello` int(10) unsigned NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `passCP` varchar(255) DEFAULT NULL,
  `ultimo_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `stato` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `gruppo` int(11) DEFAULT '0',
  `date_added` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `date_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip_utente` varchar(48) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_admincp`
--

INSERT INTO `ec_admincp` (`id_admin`, `codice`, `livello`, `cognome`, `nome`, `email`, `username`, `password`, `passCP`, `ultimo_login`, `stato`, `gruppo`, `date_added`, `date_updated`, `ip_utente`, `hostname`) VALUES
(1, '625725439412', 1, 'test', 'test', 'test@test.it', 'coder', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '2017-02-16 09:09:03', 0, 2, '2013-12-10 07:40:32', '2017-02-16 09:09:03', '::1', 'renegade');

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_admincp_log`
--

CREATE TABLE IF NOT EXISTS `ec_admincp_log` (
  `id_admin` int(11) NOT NULL,
  `ultimo_login` datetime NOT NULL,
  `ip_utente` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `hostname` varchar(250) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_admincp_log`
--

INSERT INTO `ec_admincp_log` (`id_admin`, `ultimo_login`, `ip_utente`, `hostname`) VALUES
(1, '2017-02-11 11:24:35', '::1', 'renegade'),
(1, '2017-02-11 13:27:07', '::1', 'renegade'),
(1, '2017-02-11 16:59:10', '::1', 'renegade'),
(1, '2017-02-12 02:05:10', '::1', 'renegade'),
(1, '2017-02-12 10:00:09', '::1', 'renegade'),
(1, '2017-02-12 11:54:45', '::1', 'renegade'),
(1, '2017-02-12 17:47:46', '::1', 'renegade'),
(1, '2017-02-13 00:54:39', '::1', 'renegade'),
(1, '2017-02-16 10:09:03', '::1', 'renegade');

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_aliquote_iva`
--

CREATE TABLE IF NOT EXISTS `ec_aliquote_iva` (
  `id_aliquote_iva` int(11) NOT NULL,
  `nome_aliquota` varchar(255) DEFAULT NULL,
  `valore_aliquota` int(11) DEFAULT '0',
  `stato` int(11) DEFAULT '1',
  `data_inserito` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `data_modifica` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_aliquote_iva`
--

INSERT INTO `ec_aliquote_iva` (`id_aliquote_iva`, `nome_aliquota`, `valore_aliquota`, `stato`, `data_inserito`, `data_modifica`) VALUES
(1, 'IVA 4 %', 4, 1, '2016-06-11 03:07:46', '2016-06-11 03:09:56'),
(2, 'IVA 22 %', 22, 1, '2016-08-23 08:50:30', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_attributi`
--

CREATE TABLE IF NOT EXISTS `ec_attributi` (
  `id_attributo` int(11) NOT NULL,
  `id_gruppo` int(11) DEFAULT '0',
  `nome_attributo` varchar(255) DEFAULT NULL,
  `stato` int(11) DEFAULT '1',
  `width` varchar(50) DEFAULT NULL,
  `height` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `est` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_attributi`
--

INSERT INTO `ec_attributi` (`id_attributo`, `id_gruppo`, `nome_attributo`, `stato`, `width`, `height`, `type`, `est`) VALUES
(1, 1, '8 GB', 1, '39', '39', '2', '.jpg'),
(2, 1, '16 GB', 1, '39', '39', '2', '.jpg'),
(3, 1, '32 GB', 1, '39', '39', '2', '.jpg'),
(4, 1, '64 GB', 1, '39', '39', '2', '.jpg'),
(5, 1, '128 GB', 1, '39', '39', '2', '.jpg'),
(6, 1, '256 GB', 1, '39', '39', '2', '.jpg'),
(8, 2, 'Oro', 1, '43', '43', '3', '.png'),
(9, 2, 'Oro rosa', 1, '43', '43', '3', '.png'),
(10, 2, 'jet black', 1, '43', '43', '3', '.png'),
(11, 2, 'nero opaco', 1, '45', '43', '3', '.png'),
(14, 2, 'Argento', 1, '43', '43', '3', '.png'),
(15, 9, 'Perfetto', 1, '43', '44', '3', '.png'),
(16, 9, 'Normale usura', 1, '43', '43', '3', '.png'),
(17, 9, 'Lievi danni', 1, '43', '44', '3', '.png'),
(18, 9, 'Danneggiato funzionante', 1, '44', '43', '3', '.png'),
(19, 9, 'Non funzionante', 1, '43', '43', '3', '.png'),
(20, 10, 'si', 1, '43', '44', '3', '.png'),
(21, 10, 'no', 1, '43', '43', '3', '.png'),
(22, 11, 'si', 1, '44', '43', '3', '.png'),
(23, 11, 'no', 1, '43', '42', '3', '.png'),
(24, 12, 'italia', 1, '44', '44', '3', '.png'),
(25, 12, 'estero', 1, '43', '44', '3', '.png');

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_attributi_gruppi`
--

CREATE TABLE IF NOT EXISTS `ec_attributi_gruppi` (
  `id_gruppo` int(11) NOT NULL,
  `nome_gruppo_attributo` varchar(255) NOT NULL,
  `id_nome_gruppo` int(11) DEFAULT '0',
  `stato` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_attributi_gruppi`
--

INSERT INTO `ec_attributi_gruppi` (`id_gruppo`, `nome_gruppo_attributo`, `id_nome_gruppo`, `stato`) VALUES
(1, 'ram', 1, 1),
(2, 'colore', 2, 1),
(3, 'wi-fi', 3, 1),
(4, 'dimensioni cassa', 4, 1),
(5, 'schermo', 5, 1),
(6, 'serie', 6, 1),
(7, 'processore', 7, 1),
(8, 'HD disco', 8, 1),
(9, 'condizioni', 9, 1),
(10, 'alimentatore', 10, 1),
(11, 'scatola', 11, 1),
(12, 'provenienza', 12, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_azienda`
--

CREATE TABLE IF NOT EXISTS `ec_azienda` (
  `id_azienda` int(11) NOT NULL,
  `nome_azienda` varchar(500) DEFAULT NULL,
  `ragione_sociale` varchar(500) DEFAULT NULL,
  `cognome` varchar(250) DEFAULT NULL,
  `nome` varchar(250) DEFAULT NULL,
  `cod_fiscale` varchar(250) DEFAULT NULL,
  `piva` varchar(250) DEFAULT NULL,
  `indirizzo` varchar(250) DEFAULT NULL,
  `cap` varchar(50) DEFAULT NULL,
  `nazione` varchar(255) DEFAULT NULL,
  `regione` varchar(255) DEFAULT NULL,
  `provincia` varchar(255) DEFAULT NULL,
  `sigla_provincia` varchar(255) DEFAULT NULL,
  `citta` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `cellulare` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sito` varchar(250) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(250) DEFAULT NULL,
  `googlepiu` varchar(250) DEFAULT NULL,
  `email_paypal` varchar(255) DEFAULT NULL,
  `logo_azienda` varchar(255) DEFAULT NULL,
  `width` varchar(255) DEFAULT NULL,
  `height` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `est` varchar(255) DEFAULT NULL,
  `data_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_azienda`
--

INSERT INTO `ec_azienda` (`id_azienda`, `nome_azienda`, `ragione_sociale`, `cognome`, `nome`, `cod_fiscale`, `piva`, `indirizzo`, `cap`, `nazione`, `regione`, `provincia`, `sigla_provincia`, `citta`, `telefono`, `cellulare`, `fax`, `email`, `sito`, `facebook`, `twitter`, `googlepiu`, `email_paypal`, `logo_azienda`, `width`, `height`, `type`, `est`, `data_update`) VALUES
(1, 'ombrellificio tozzi', 'kamalab', 'coder', 'lamp', 'codice fiscale', 'partita iva', 'via del mondo 666', '10098', 'italia', 'pienonte', 'Torino', 'TO', 'Torino', '111112', '111112', '111112', 'coderlamp@gmail.com', 'http://www.kamalab.com', '', '', '', '', 'ombrellificio-tozzi-logo', '', '', '', '.jpg', '2016-11-27 17:49:07');

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_backup`
--

CREATE TABLE IF NOT EXISTS `ec_backup` (
  `id_bk` int(11) NOT NULL,
  `nome_file` varchar(50) DEFAULT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `stato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_caratteristiche`
--

CREATE TABLE IF NOT EXISTS `ec_caratteristiche` (
  `id_caratteristica` int(11) NOT NULL,
  `stato` int(11) DEFAULT '1',
  `data_inserito` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `data_modifica` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_caratteristiche_lang`
--

CREATE TABLE IF NOT EXISTS `ec_caratteristiche_lang` (
  `id_tbl` int(11) NOT NULL,
  `id_caratteristica` int(11) NOT NULL,
  `id_lingua` int(11) DEFAULT '0',
  `nome_caratteristica` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_caratteristiche_prodotto`
--

CREATE TABLE IF NOT EXISTS `ec_caratteristiche_prodotto` (
  `id_tbl` int(11) NOT NULL,
  `id_prodotto` int(10) unsigned NOT NULL,
  `id_caratteristica` int(11) DEFAULT '0',
  `id_caratteristica_value` int(10) unsigned NOT NULL,
  `nome_caratteristica` varchar(255) DEFAULT NULL,
  `valore_caratteristica` varchar(255) DEFAULT NULL,
  `stato` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_caratteristiche_value_lang`
--

CREATE TABLE IF NOT EXISTS `ec_caratteristiche_value_lang` (
  `id_tbl` int(11) NOT NULL,
  `id_caratteristica` int(11) NOT NULL,
  `id_lingua` int(11) DEFAULT '0',
  `id_group_value` varchar(255) DEFAULT NULL,
  `value_caratteristica` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_categorie`
--

CREATE TABLE IF NOT EXISTS `ec_categorie` (
  `id_categoria` int(11) NOT NULL,
  `categoria_padre` int(10) NOT NULL DEFAULT '0',
  `tipo_categoria` int(11) DEFAULT '0',
  `titolo` varchar(250) DEFAULT NULL,
  `width` varchar(50) DEFAULT NULL,
  `height` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `est` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_categorie`
--

INSERT INTO `ec_categorie` (`id_categoria`, `categoria_padre`, `tipo_categoria`, `titolo`, `width`, `height`, `type`, `est`) VALUES
(1, 0, 1, 'iPhone', '120', '244', '3', '.png'),
(2, 0, 2, 'iPad', '164', '238', '3', '.png'),
(3, 0, 2, 'iPad mini', '201', '262', '3', '.png'),
(4, 0, 3, 'Apple watch', '400', '400', '3', '.png'),
(5, 0, 4, 'Mac', '316', '244', '3', '.png');

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_cron`
--

CREATE TABLE IF NOT EXISTS `ec_cron` (
  `id_tbl` int(11) NOT NULL,
  `operazione1` varchar(500) DEFAULT NULL,
  `operazione2` varchar(500) DEFAULT NULL,
  `operazione3` varchar(500) DEFAULT NULL,
  `operazione4` varchar(500) DEFAULT NULL,
  `operazione5` varchar(500) DEFAULT NULL,
  `operazione6` varchar(500) DEFAULT NULL,
  `data_run` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_hackeradmin`
--

CREATE TABLE IF NOT EXISTS `ec_hackeradmin` (
  `id` int(10) unsigned NOT NULL,
  `ip_utente` varchar(48) NOT NULL DEFAULT '',
  `hostname` varchar(255) NOT NULL DEFAULT '',
  `data_check` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logTipe` int(11) DEFAULT '0' COMMENT '1=admin | 2= user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_impostazioni`
--

CREATE TABLE IF NOT EXISTS `ec_impostazioni` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `val` mediumtext,
  `descr` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_impostazioni`
--

INSERT INTO `ec_impostazioni` (`id`, `name`, `val`, `descr`) VALUES
(1, 'nome_breve_sito', 'test', 'Nome breve del sito'),
(2, 'nome_sito', 'test', 'Nome del sito'),
(3, 'title_meta', 'test', 'Tag TITLE'),
(4, 'description_meta', 'test', 'Tag DESCRIPTION'),
(5, 'keywords_meta', 'test', 'Tag KEYWORDS'),
(6, 'valuta_default', 'EUR', 'Impostazione valuta default'),
(7, 'fuso', '0', 'fuso orario'),
(8, 'iva_corrente', '22', '% iva');

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_ip_autorizzati`
--

CREATE TABLE IF NOT EXISTS `ec_ip_autorizzati` (
  `id_ip` int(11) NOT NULL,
  `indirizzo_ip` varchar(250) DEFAULT NULL,
  `data_inserimento` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_ip_autorizzati`
--

INSERT INTO `ec_ip_autorizzati` (`id_ip`, `indirizzo_ip`, `data_inserimento`) VALUES
(47, '62.94.154.50', '2013-12-14 10:06:17');

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_navigazione_utente`
--

CREATE TABLE IF NOT EXISTS `ec_navigazione_utente` (
  `id` int(5) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `ip_user` varchar(48) DEFAULT NULL,
  `data_visita` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `host_visita` varchar(255) DEFAULT NULL,
  `browser` varchar(250) DEFAULT NULL,
  `sistema_operativo` varchar(250) DEFAULT NULL,
  `file` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_offline`
--

CREATE TABLE IF NOT EXISTS `ec_offline` (
  `offline_sito` int(11) NOT NULL DEFAULT '0',
  `offline_webscrivania` int(11) DEFAULT '0',
  `data_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_offline`
--

INSERT INTO `ec_offline` (`offline_sito`, `offline_webscrivania`, `data_update`) VALUES
(0, 1, '2014-01-01 11:45:54');

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_ordini`
--

CREATE TABLE IF NOT EXISTS `ec_ordini` (
  `id_ordine` int(10) unsigned NOT NULL,
  `cod_ordine` varchar(255) DEFAULT NULL,
  `id_carrello` int(11) DEFAULT '0',
  `id_utente` int(11) DEFAULT '0',
  `id_corriere` int(11) DEFAULT '0',
  `id_valuta` int(11) DEFAULT '0',
  `id_indirizzo_spedizione` int(11) DEFAULT '0',
  `id_indirizzo_fatturazione` int(11) DEFAULT '0',
  `totale_netto_prodotti` decimal(17,6) DEFAULT '0.000000',
  `totale_iva_prodotti` decimal(17,6) DEFAULT '0.000000',
  `totale_lordo` decimal(17,6) DEFAULT '0.000000',
  `totale_netto` decimal(17,6) DEFAULT '0.000000',
  `totale_iva` decimal(17,6) DEFAULT '0.000000',
  `totale_peso_ordine` float(8,2) DEFAULT '0.00',
  `spese_pagamento_scelto` decimal(17,6) DEFAULT '0.000000' COMMENT 'tassa fissa',
  `totale_spedizione` decimal(17,6) DEFAULT '0.000000',
  `totale_extra_spedizione` decimal(17,6) DEFAULT '0.000000',
  `sconto_applicato` decimal(17,6) DEFAULT '0.000000',
  `id_fattura` int(11) DEFAULT '0',
  `id_bolla` int(11) DEFAULT '0',
  `nota_acquirente` varchar(255) DEFAULT NULL,
  `stato` int(11) DEFAULT '0' COMMENT '1=pagato | 2=in lavorazione | 3= spedizione | 4=consegnato/chiuso | 5 = chiuso ma non pagato | 6= ordine aperto | 7 ordine rifiutato',
  `data_ordine` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `data_update` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_pagamento` int(11) DEFAULT '0',
  `metodo_pagamento` varchar(255) DEFAULT NULL,
  `cod_spedizione` varchar(255) DEFAULT NULL,
  `ip_utente` varchar(48) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `data_spedizione` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `data_consegna` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `data_reso` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_ordini_dettaglio`
--

CREATE TABLE IF NOT EXISTS `ec_ordini_dettaglio` (
  `id_tbl` int(11) NOT NULL,
  `id_ordine` int(11) DEFAULT '0',
  `id_prodotto` int(11) DEFAULT '0',
  `id_regime_iva` int(11) DEFAULT '0',
  `id_attributo_prodotto` int(11) DEFAULT '0',
  `id_fornitore` int(11) DEFAULT '0',
  `codice_prodotto` varchar(255) DEFAULT NULL,
  `costo_unitario` decimal(17,6) DEFAULT '0.000000',
  `totale_netto` decimal(17,6) DEFAULT '0.000000',
  `totale_iva` decimal(17,6) DEFAULT '0.000000',
  `totale_lordo` decimal(17,6) DEFAULT '0.000000',
  `nome_prodotto` varchar(250) DEFAULT NULL,
  `quantita` int(11) DEFAULT '0',
  `iva_applicata` int(11) DEFAULT '0',
  `peso` float(8,2) DEFAULT '0.00',
  `totale_tassa_consumo` decimal(17,6) DEFAULT '0.000000',
  `rimborsato` int(11) DEFAULT '0',
  `reso` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_ordini_note`
--

CREATE TABLE IF NOT EXISTS `ec_ordini_note` (
  `id_tbl` int(11) unsigned NOT NULL,
  `id_ordine` int(11) DEFAULT '0',
  `id_utente` int(11) DEFAULT '0' COMMENT 'utente affiliato',
  `nota_gestione` varchar(255) DEFAULT NULL,
  `nota_rifiutato` varchar(255) DEFAULT NULL,
  `nota_spedizione` varchar(255) DEFAULT NULL,
  `nota_consegnato` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_prodotti`
--

CREATE TABLE IF NOT EXISTS `ec_prodotti` (
  `id_prodotto` int(11) NOT NULL,
  `id_categoria` int(11) DEFAULT '0',
  `id_regime_iva` int(11) DEFAULT '0',
  `nome_prodotto` varchar(500) DEFAULT NULL,
  `breve_descrizione` varchar(500) DEFAULT NULL,
  `descrizione` text,
  `valore_iva_applicata` int(11) DEFAULT '0',
  `codice_prodotto` varchar(155) DEFAULT NULL,
  `quantita` int(11) DEFAULT '0',
  `prezzo_senza_iva` decimal(17,2) DEFAULT '0.00',
  `prezzo_con_iva` decimal(17,2) DEFAULT '0.00',
  `peso` float(8,2) DEFAULT '0.00',
  `largo` float(8,2) DEFAULT '0.00',
  `lungo` float(8,2) DEFAULT '0.00',
  `data_registrazione` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `data_aggiornamento` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `stato` int(11) DEFAULT '0',
  `width` varchar(50) DEFAULT NULL,
  `height` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `est` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_prodotti`
--

INSERT INTO `ec_prodotti` (`id_prodotto`, `id_categoria`, `id_regime_iva`, `nome_prodotto`, `breve_descrizione`, `descrizione`, `valore_iva_applicata`, `codice_prodotto`, `quantita`, `prezzo_senza_iva`, `prezzo_con_iva`, `peso`, `largo`, `lungo`, `data_registrazione`, `data_aggiornamento`, `stato`, `width`, `height`, `type`, `est`) VALUES
(1, 1, 2, 'iPhone 7', 'descrizione breve', 'descrizione completa', 22, '001', 0, '350.00', '427.00', 450.00, 5.00, 11.00, '2017-02-12 11:59:45', '2017-02-12 14:17:30', 1, '115', '244', '3', '.png'),
(2, 1, 2, 'iPhone 7plus', NULL, NULL, 22, '002', 0, '350.00', '427.00', 450.00, 5.00, 11.00, '2017-02-12 16:48:36', '0000-00-00 00:00:00', 1, '115', '244', '3', '.png'),
(3, 1, 2, 'iPhone 6', NULL, NULL, 22, '003', 0, '300.00', '366.00', 400.00, 4.00, 10.00, '2017-02-12 16:50:48', '0000-00-00 00:00:00', 1, '120', '244', '3', '.png'),
(4, 1, 2, 'iPhone 6plus', NULL, NULL, 22, '004', 0, '300.00', '366.00', 400.00, 4.00, 10.00, '2017-02-12 16:51:25', '0000-00-00 00:00:00', 1, '120', '244', '3', '.png');

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_prodotti_attribute`
--

CREATE TABLE IF NOT EXISTS `ec_prodotti_attribute` (
  `id_attributo_prodotto` int(11) NOT NULL,
  `id_prodotto` int(10) unsigned NOT NULL,
  `id_gruppo_attributo` int(11) DEFAULT '0',
  `id_attributo` int(11) DEFAULT '0',
  `codice_prodotto` varchar(255) DEFAULT NULL,
  `tipo_impatto_prezzo` int(11) DEFAULT '0',
  `impatto_prezzo` decimal(17,2) NOT NULL DEFAULT '0.00',
  `label_fascia` varchar(255) DEFAULT NULL,
  `tipo_attributo` int(11) DEFAULT '0',
  `default_on` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_prodotti_attribute`
--

INSERT INTO `ec_prodotti_attribute` (`id_attributo_prodotto`, `id_prodotto`, `id_gruppo_attributo`, `id_attributo`, `codice_prodotto`, `tipo_impatto_prezzo`, `impatto_prezzo`, `label_fascia`, `tipo_attributo`, `default_on`) VALUES
(1, 1, 1, 3, '001', 1, '15.00', '32 GB', 1, 0),
(2, 1, 1, 4, '001', 1, '40.00', '64 GB', 1, 1),
(4, 1, 1, 5, '001', 1, '70.00', '128 GB', 1, 0),
(5, 1, 2, 14, '001', -1, '0.00', 'Argento', 2, 0),
(6, 1, 2, 10, '001', -1, '0.00', 'jet black', 2, 0),
(7, 1, 9, 15, '001', 1, '10.00', 'Perfetto', 9, 0),
(8, 1, 9, 16, '001', -1, '0.00', 'Normale usura', 9, 0),
(9, 1, 9, 17, '001', 2, '10.00', 'Lievi danni', 9, 0),
(10, 1, 9, 18, '001', 2, '30.00', 'Danneggiato funzionante', 9, 0),
(11, 1, 10, 20, '001', 1, '10.00', 'si', 10, 0),
(12, 1, 10, 21, '001', 2, '25.00', 'no', 10, 0),
(13, 1, 11, 22, '001', 1, '10.00', 'si', 11, 0),
(14, 1, 11, 23, '001', 2, '25.00', 'no', 11, 0),
(15, 1, 12, 24, '001', 1, '12.00', 'italia', 12, 0),
(16, 1, 12, 25, '001', 2, '35.00', 'estero', 12, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_prodotti_caratteristiche`
--

CREATE TABLE IF NOT EXISTS `ec_prodotti_caratteristiche` (
  `id_caratteristica` int(11) unsigned NOT NULL,
  `id_prodotto` int(10) unsigned NOT NULL,
  `apertura` varchar(255) DEFAULT NULL,
  `dimensione` varchar(255) DEFAULT NULL,
  `diametro_copertura` varchar(255) DEFAULT NULL,
  `lunghezza` varchar(255) DEFAULT NULL,
  `tessuto` varchar(255) DEFAULT NULL,
  `intelaiatura` varchar(255) DEFAULT NULL,
  `asta_centrale` varchar(255) DEFAULT NULL,
  `impugnatura` varchar(255) DEFAULT NULL,
  `sistema_antivento` varchar(255) DEFAULT NULL,
  `sistema_anticrash` varchar(255) DEFAULT NULL,
  `id_foto` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_recensioni`
--

CREATE TABLE IF NOT EXISTS `ec_recensioni` (
  `id_tbl` int(11) NOT NULL,
  `id_utente` int(11) DEFAULT NULL,
  `id_prodotto` int(11) DEFAULT '0',
  `tipo_recensione` int(11) DEFAULT '0' COMMENT '1=vendita | 2=acquisto',
  `risposta` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_recensioni_righe`
--

CREATE TABLE IF NOT EXISTS `ec_recensioni_righe` (
  `id_tbl` int(11) NOT NULL,
  `id_recensione` int(11) NOT NULL,
  `testo_recensione` longtext NOT NULL,
  `data_recensione` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `stato` tinyint(4) NOT NULL DEFAULT '1',
  `punteggio` int(11) DEFAULT '0',
  `ip_utente` varchar(48) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_sessions`
--

CREATE TABLE IF NOT EXISTS `ec_sessions` (
  `session_id` varchar(32) NOT NULL DEFAULT '',
  `session_data` text NOT NULL,
  `session_expiration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_sessions`
--

INSERT INTO `ec_sessions` (`session_id`, `session_data`, `session_expiration`) VALUES
('6ob5p9jh2nsclvp8jpu04tdc10', 'yjM9SejIFLsneHblUfTjqBt_UmDt1xMQZtXeOB9usNm9qeL0E_5Of0X1P3hEW7ACpAN9ES4Dlvyc53THac4_XZ_s9ujrZAorMPltKoYeEF7f9IMtqURf0ah4U_iooIvCJkX5vGPUuh8AgHdaGz1FSg..', '2013-02-03 16:39:13');

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_setup`
--

CREATE TABLE IF NOT EXISTS `ec_setup` (
  `id_tbl` int(10) unsigned NOT NULL,
  `regime_iva` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_setup`
--

INSERT INTO `ec_setup` (`id_tbl`, `regime_iva`) VALUES
(1, 21);

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_utente_indirizzi`
--

CREATE TABLE IF NOT EXISTS `ec_utente_indirizzi` (
  `id_tbl` int(10) unsigned NOT NULL,
  `id_utente` int(11) DEFAULT '0',
  `tipo_indirizzo` int(11) DEFAULT '0' COMMENT '1=fatturazione| 2=spedizione',
  `imposta_default` int(11) DEFAULT '0',
  `id_nazione` varchar(255) DEFAULT NULL,
  `id_regione` varchar(255) DEFAULT NULL,
  `id_citta` int(11) DEFAULT '0',
  `nome` varchar(255) DEFAULT NULL,
  `cognome` varchar(255) DEFAULT NULL,
  `indirizzo` varchar(500) DEFAULT NULL,
  `cap` varchar(20) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `cellulare` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_utente_indirizzi`
--

INSERT INTO `ec_utente_indirizzi` (`id_tbl`, `id_utente`, `tipo_indirizzo`, `imposta_default`, `id_nazione`, `id_regione`, `id_citta`, `nome`, `cognome`, `indirizzo`, `cap`, `telefono`, `cellulare`, `fax`) VALUES
(1, 1, 2, 0, 'IT', '01', 1177780, 'pippo', 'baudo', 'via divisione cuneense 27', '12023', '3911104906', '3911104906', NULL),
(2, 1, 1, 0, 'IT', '12', 1195509, 'nome', 'cognome', 'indirizzo', '10100', '22222', '33333', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_utente_recensioni`
--

CREATE TABLE IF NOT EXISTS `ec_utente_recensioni` (
  `id_utente` int(10) unsigned NOT NULL,
  `id_prodotto` int(11) unsigned DEFAULT '0',
  `stato` int(11) unsigned DEFAULT '0',
  `voto` int(11) unsigned DEFAULT '0',
  `note` varchar(255) DEFAULT NULL,
  `data_inserito` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `ec_utenti`
--

CREATE TABLE IF NOT EXISTS `ec_utenti` (
  `id_utente` int(10) unsigned NOT NULL,
  `cod_utente` varchar(255) DEFAULT NULL,
  `tipo_utente` int(11) DEFAULT '0' COMMENT '1= privato | 2=azienda',
  `titolo` int(11) DEFAULT NULL,
  `cognome` varchar(255) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono_referente` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `password_chiaro` varchar(255) DEFAULT NULL,
  `newsletter` int(11) unsigned DEFAULT '0',
  `stato` int(11) unsigned DEFAULT '1',
  `stato_admin` int(11) DEFAULT '1',
  `data_registrazione` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `data_update` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `ragione_sociale` varchar(500) DEFAULT NULL,
  `rea` varchar(255) DEFAULT NULL,
  `piva` varchar(255) DEFAULT NULL,
  `cod_fiscale` varchar(255) DEFAULT NULL,
  `ultimo_login` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `ip_utente` varchar(48) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `nuovo_iscritto` int(11) DEFAULT '0',
  `deleted` int(11) DEFAULT '0',
  `codice_att` varchar(255) DEFAULT NULL,
  `sito_web` varchar(255) DEFAULT NULL,
  `stato_profilo` int(11) DEFAULT '0',
  `data_nascita` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ec_utenti`
--

INSERT INTO `ec_utenti` (`id_utente`, `cod_utente`, `tipo_utente`, `titolo`, `cognome`, `nome`, `email`, `telefono_referente`, `password`, `password_chiaro`, `newsletter`, `stato`, `stato_admin`, `data_registrazione`, `data_update`, `ragione_sociale`, `rea`, `piva`, `cod_fiscale`, `ultimo_login`, `ip_utente`, `hostname`, `nuovo_iscritto`, `deleted`, `codice_att`, `sito_web`, `stato_profilo`, `data_nascita`) VALUES
(1, '918425630914', 2, NULL, 'test', 'utente', 'test@test.it', '111111', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', 1, 1, 1, '2016-09-23 17:14:08', '2017-02-09 11:08:43', '', '', '', 'sadasd', '2017-01-18 09:01:42', '::1', 'renegade', 1, 0, 'PSIQC04263AEEF8', NULL, 0, NULL);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `ec_admincp`
--
ALTER TABLE `ec_admincp`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `employee_login` (`email`,`password`),
  ADD KEY `id_employee_passwd` (`id_admin`,`password`),
  ADD KEY `id_profile` (`livello`);

--
-- Indici per le tabelle `ec_aliquote_iva`
--
ALTER TABLE `ec_aliquote_iva`
  ADD PRIMARY KEY (`id_aliquote_iva`);

--
-- Indici per le tabelle `ec_attributi`
--
ALTER TABLE `ec_attributi`
  ADD PRIMARY KEY (`id_attributo`);

--
-- Indici per le tabelle `ec_attributi_gruppi`
--
ALTER TABLE `ec_attributi_gruppi`
  ADD PRIMARY KEY (`id_gruppo`);

--
-- Indici per le tabelle `ec_azienda`
--
ALTER TABLE `ec_azienda`
  ADD PRIMARY KEY (`id_azienda`);

--
-- Indici per le tabelle `ec_backup`
--
ALTER TABLE `ec_backup`
  ADD PRIMARY KEY (`id_bk`);

--
-- Indici per le tabelle `ec_caratteristiche`
--
ALTER TABLE `ec_caratteristiche`
  ADD PRIMARY KEY (`id_caratteristica`);

--
-- Indici per le tabelle `ec_caratteristiche_lang`
--
ALTER TABLE `ec_caratteristiche_lang`
  ADD PRIMARY KEY (`id_tbl`);

--
-- Indici per le tabelle `ec_caratteristiche_prodotto`
--
ALTER TABLE `ec_caratteristiche_prodotto`
  ADD PRIMARY KEY (`id_tbl`);

--
-- Indici per le tabelle `ec_caratteristiche_value_lang`
--
ALTER TABLE `ec_caratteristiche_value_lang`
  ADD PRIMARY KEY (`id_tbl`);

--
-- Indici per le tabelle `ec_categorie`
--
ALTER TABLE `ec_categorie`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indici per le tabelle `ec_cron`
--
ALTER TABLE `ec_cron`
  ADD PRIMARY KEY (`id_tbl`);

--
-- Indici per le tabelle `ec_hackeradmin`
--
ALTER TABLE `ec_hackeradmin`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `ec_impostazioni`
--
ALTER TABLE `ec_impostazioni`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `ec_ip_autorizzati`
--
ALTER TABLE `ec_ip_autorizzati`
  ADD PRIMARY KEY (`id_ip`);

--
-- Indici per le tabelle `ec_navigazione_utente`
--
ALTER TABLE `ec_navigazione_utente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_user_2` (`id_user`);

--
-- Indici per le tabelle `ec_offline`
--
ALTER TABLE `ec_offline`
  ADD PRIMARY KEY (`offline_sito`);

--
-- Indici per le tabelle `ec_ordini`
--
ALTER TABLE `ec_ordini`
  ADD PRIMARY KEY (`id_ordine`),
  ADD KEY `id_customer` (`id_utente`),
  ADD KEY `invoice_number` (`id_fattura`),
  ADD KEY `date_add` (`data_ordine`);

--
-- Indici per le tabelle `ec_ordini_dettaglio`
--
ALTER TABLE `ec_ordini_dettaglio`
  ADD PRIMARY KEY (`id_tbl`);

--
-- Indici per le tabelle `ec_ordini_note`
--
ALTER TABLE `ec_ordini_note`
  ADD PRIMARY KEY (`id_tbl`);

--
-- Indici per le tabelle `ec_prodotti`
--
ALTER TABLE `ec_prodotti`
  ADD PRIMARY KEY (`id_prodotto`);

--
-- Indici per le tabelle `ec_prodotti_attribute`
--
ALTER TABLE `ec_prodotti_attribute`
  ADD PRIMARY KEY (`id_attributo_prodotto`);

--
-- Indici per le tabelle `ec_prodotti_caratteristiche`
--
ALTER TABLE `ec_prodotti_caratteristiche`
  ADD PRIMARY KEY (`id_caratteristica`);

--
-- Indici per le tabelle `ec_recensioni`
--
ALTER TABLE `ec_recensioni`
  ADD PRIMARY KEY (`id_tbl`);

--
-- Indici per le tabelle `ec_recensioni_righe`
--
ALTER TABLE `ec_recensioni_righe`
  ADD PRIMARY KEY (`id_tbl`);

--
-- Indici per le tabelle `ec_sessions`
--
ALTER TABLE `ec_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indici per le tabelle `ec_setup`
--
ALTER TABLE `ec_setup`
  ADD PRIMARY KEY (`id_tbl`);

--
-- Indici per le tabelle `ec_utente_indirizzi`
--
ALTER TABLE `ec_utente_indirizzi`
  ADD PRIMARY KEY (`id_tbl`);

--
-- Indici per le tabelle `ec_utente_recensioni`
--
ALTER TABLE `ec_utente_recensioni`
  ADD PRIMARY KEY (`id_utente`);

--
-- Indici per le tabelle `ec_utenti`
--
ALTER TABLE `ec_utenti`
  ADD PRIMARY KEY (`id_utente`),
  ADD KEY `customer_email` (`email`),
  ADD KEY `customer_login` (`email`,`password`),
  ADD KEY `id_customer_passwd` (`id_utente`,`password`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `ec_admincp`
--
ALTER TABLE `ec_admincp`
  MODIFY `id_admin` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `ec_aliquote_iva`
--
ALTER TABLE `ec_aliquote_iva`
  MODIFY `id_aliquote_iva` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT per la tabella `ec_attributi`
--
ALTER TABLE `ec_attributi`
  MODIFY `id_attributo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT per la tabella `ec_attributi_gruppi`
--
ALTER TABLE `ec_attributi_gruppi`
  MODIFY `id_gruppo` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT per la tabella `ec_azienda`
--
ALTER TABLE `ec_azienda`
  MODIFY `id_azienda` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `ec_backup`
--
ALTER TABLE `ec_backup`
  MODIFY `id_bk` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `ec_caratteristiche`
--
ALTER TABLE `ec_caratteristiche`
  MODIFY `id_caratteristica` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `ec_caratteristiche_lang`
--
ALTER TABLE `ec_caratteristiche_lang`
  MODIFY `id_tbl` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `ec_categorie`
--
ALTER TABLE `ec_categorie`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT per la tabella `ec_prodotti`
--
ALTER TABLE `ec_prodotti`
  MODIFY `id_prodotto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT per la tabella `ec_prodotti_attribute`
--
ALTER TABLE `ec_prodotti_attribute`
  MODIFY `id_attributo_prodotto` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
