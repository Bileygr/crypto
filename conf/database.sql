-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 24, 2020 at 06:49 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

/*
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
*/

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `soteria`
--

-- --------------------------------------------------------

--
-- Table structure for table `authentification`
--

DROP TABLE IF EXISTS authentification;
CREATE TABLE IF NOT EXISTS authentification (
  id SERIAL,
  utilisateur_id integer NOT NULL,
  mot_de_passe varchar(64) NOT NULL,
  cle_secrete varchar(20) NOT NULL,
  PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

DROP TABLE IF EXISTS consultation;
CREATE TABLE IF NOT EXISTS consultation (
  id SERIAL,
  doc_id integer NOT NULL,
  patient_id integer NOT NULL,
  maladie_id integer NOT NULL,
  prix float NOT NULL,
  date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table `docteur`
--

DROP TABLE IF EXISTS docteur;
CREATE TABLE IF NOT EXISTS docteur (
  utilisateur_id integer NOT NULL,
  role_id integer NOT NULL,
  specialisation_id integer NOT NULL,
  date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (utilisateur_id)
);

-- --------------------------------------------------------

--
-- Table structure for table `entreprise`
--

DROP TABLE IF EXISTS entreprise;
CREATE TABLE IF NOT EXISTS entreprise (
  id SERIAL,
  siret integer,
  nom varchar(50) NOT NULL,
  email varchar(50) NOT NULL,
  telephone varchar(20) NOT NULL,
  date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

--
-- Dumping data for table `entreprise`
--

INSERT INTO entreprise (siret, nom, email, telephone) VALUES
(12345678, 'KeitaCorp', 'cheiksiramakankeita@gmail.com', '0605557802');

-- --------------------------------------------------------

--
-- Table structure for table `liste_des_medicaments`
--

DROP TABLE IF EXISTS liste_des_medicaments;
CREATE TABLE IF NOT EXISTS liste_des_medicaments (
  id SERIAL,
  medicament_id integer NOT NULL,
  dose float NOT NULL,
  PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table `liste_des_symptomes`
--

DROP TABLE IF EXISTS liste_des_symptomes;
CREATE TABLE IF NOT EXISTS liste_des_symptomes (
  id SERIAL,
  symptome_id integer NOT NULL,
  maladie_id integer NOT NULL,
  PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table `maladie`
--

DROP TABLE IF EXISTS maladie;
CREATE TABLE IF NOT EXISTS maladie (
  id SERIAL,
  nom varchar(50) NOT NULL,
  liste_des_symptomes_id integer NOT NULL,
  description text NOT NULL,
  traitement_id integer NOT NULL,
  PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table `medicament`
--

DROP TABLE IF EXISTS medicament;
CREATE TABLE IF NOT EXISTS medicament (
  id SERIAL,
  nom varchar(50) NOT NULL,
  PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS role;
CREATE TABLE IF NOT EXISTS role (
  id SERIAL,
  titre varchar(50) NOT NULL,
  PRIMARY KEY (id)
);

--
-- Dumping data for table `role`
--

INSERT INTO role(id, titre) VALUES
(1, 'Paramédical'),
(2, 'Docteur'),
(3, 'Administration'),
(4, 'Statique'),
(5, 'Super administrateur');

-- --------------------------------------------------------

--
-- Table structure for table `specialisation`
--

DROP TABLE IF EXISTS specialisation;
CREATE TABLE IF NOT EXISTS specialisation (
  id SERIAL,
  titre varchar(50) NOT NULL,
  PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table `symptome`
--

DROP TABLE IF EXISTS symptome;
CREATE TABLE IF NOT EXISTS symptome (
  id SERIAL,
  nom varchar(50) NOT NULL,
  Description text NOT NULL,
  PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table `traitement`
--

DROP TABLE IF EXISTS traitement;
CREATE TABLE IF NOT EXISTS traitement (
  id SERIAL,
  liste_des_medicaments_id integer NOT NULL,
  PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS utilisateur;
CREATE TABLE IF NOT EXISTS utilisateur (
  id SERIAL,
  actif boolean,
  entreprise_id integer DEFAULT NULL,
  role_id integer NOT NULL,
  nom varchar(50) NOT NULL,
  prenom varchar(50) NOT NULL,
  email varchar(50) NOT NULL,
  telephone varchar(20) NOT NULL,
  date_ajout timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authentification`
--
ALTER TABLE authentification
  ADD CONSTRAINT fk_utilisateur_id FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE;

--
-- Constraints for table `consultation`
--
ALTER TABLE consultation
  ADD CONSTRAINT fk_consultation_doc FOREIGN KEY (doc_id) REFERENCES utilisateur (id) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT fk_consultation_maladie FOREIGN KEY (maladie_id) REFERENCES maladie (id) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT fk_consultation_patient FOREIGN KEY (patient_id) REFERENCES utilisateur (id) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `docteur`
--
ALTER TABLE docteur
  ADD CONSTRAINT fk_docteur_role_id FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE,
  ADD CONSTRAINT fk_docteur_specialisation_id FOREIGN KEY (specialisation_id) REFERENCES specialisation (id) ON DELETE CASCADE,
  ADD CONSTRAINT fk_docteur_utilisateur_id FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE;

--
-- Constraints for table `liste_des_medicaments`
--
ALTER TABLE liste_des_medicaments
  ADD CONSTRAINT fk_liste_des_medicaments_medicament FOREIGN KEY (medicament_id) REFERENCES medicament (id) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `liste_des_symptomes`
--
ALTER TABLE liste_des_symptomes
  ADD CONSTRAINT fk_liste_des_symptomes_maladie FOREIGN KEY (maladie_id) REFERENCES maladie (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_liste_des_symptomes_symptome FOREIGN KEY (symptome_id) REFERENCES symptome (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `maladie`
--
ALTER TABLE maladie
  ADD CONSTRAINT fk_maladie_liste_des_symptomes FOREIGN KEY (liste_des_symptomes_id) REFERENCES liste_des_symptomes (id) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT fk_maladie_traitement FOREIGN KEY (traitement_id) REFERENCES traitement (id) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `traitement`
--
ALTER TABLE traitement
  ADD CONSTRAINT fk_traitement_liste_des_medicaments FOREIGN KEY (liste_des_medicaments_id) REFERENCES liste_des_medicaments (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `utilisateur`
--
ALTER TABLE utilisateur
  ADD CONSTRAINT fk_utilisateur_entreprise FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
