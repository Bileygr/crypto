/*
  * Script de création des tables de la base de données du projet "crypto" pour le module SQL.
  * Par Matthieu Drisse et Cheik-Siramakan Keita
  * Pour monsieur Palacios
  * 2019-2020
*/

/*
  DROP DATABASE IF EXISTS telemedecine;
  CREATE DATABASE telemedecine CHARACTER SET utf8 COLLATE utf8_general_ci;

  USE telemedecine;
*/

DROP TABLE IF EXISTS authentification CASCADE;
CREATE TABLE IF NOT EXISTS authentification (
  utilisateur_id integer NOT NULL UNIQUE,
  authentification_mot_de_passe varchar(64) NOT NULL,
  authentification_cle_secrete varchar(20) NOT NULL,
  PRIMARY KEY (utilisateur_id)
);
INSERT INTO authentification(utilisateur_id, authentification_mot_de_passe, authentification_cle_secrete) VALUES
(1, '$2y$10$PGsC94HRkR4kFeilkFdYU.pVd3PpzFP0tdny/ibXbZ8EX2zTnpWp.', 'UYQO3LQ3OGGMVQHE'),
(2, '$2y$10$.FG2csQDlzvSYKvNnskAdelHoCllG73Ve.WE5/i8v3VTUYpJLemBi', 'SXUXAOU47ZJFTTDP');

DROP TABLE IF EXISTS entreprise CASCADE;
CREATE TABLE IF NOT EXISTS entreprise (
	entreprise_siren varchar(9) NOT NULL,
	entreprise_activation boolean NOT NULL,
	entreprise_nom varchar(150) NOT NULL,
	entreprise_telephone varchar(15) NOT NULL,
	entreprise_email varchar(50) NOT NULL,
	entreprise_numero_de_rue integer NOT NULL,
	entreprise_rue varchar(150) NOT NULL,
	entreprise_ville varchar(100) NOT NULL,
	entreprise_code_postal varchar(5) NOT NULL,
  entreprise_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (entreprise_siren)
);

INSERT INTO entreprise(entreprise_siren, entreprise_activation, entreprise_nom, entreprise_telephone,
	entreprise_email, entreprise_numero_de_rue, entreprise_rue, entreprise_ville, entreprise_code_postal) VALUES
('123456789', TRUE, 'PalaciosCorp', '0100000000', 'masvirtual@gmail.com', '93', 'Rue Barrault', 'Paris', '75013'),
('012345678', TRUE, 'DrisseCorp', '0100000001', 'mattdrisse@gmail.com', '8', 'Rue de la Mitrie', 'Nantes', '44000'),
('123456788', TRUE, 'KeitaCorp',  '0100000002', 'cheiksiramakankeita@gmail.com', '2', 'Rue de Monbret', 'Rouen', '76000'),
('112345676', TRUE, 'DialloCorp',  '0100000003', 'ibenz82@gmail.com', '26', 'Rue de la Métallurgie', 'Lyon', '69003'),
('231454658', TRUE, 'MaigrotCorp',  '0100000004', 'maigalex91@gmail.com', '3', 'Rue Palaprat', 'Toulouse', '31000');

DROP TABLE IF EXISTS examen CASCADE;
CREATE TABLE IF NOT EXISTS examen (
  examen_id SERIAL,
  docteur_id integer NOT NULL,
  patient_id integer NOT NULL,
  interpretation_id integer NOT NULL,
  examen_prix float NOT NULL,
  examen_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (examen_id)
);

DROP TABLE IF EXISTS liste_des_medicaments CASCADE;
CREATE TABLE IF NOT EXISTS liste_des_medicaments (
  traitement_id integer,
  medicament_id integer NOT NULL,
  medicament_dose float NOT NULL
);

DROP TABLE IF EXISTS interpretation CASCADE;
CREATE TABLE IF NOT EXISTS interpretation(
  examen_id integer NOT NULL UNIQUE,
  docteur_id integer NOT NULL,
  maladie_id integer,
  interpretation_note text,
  interpretation_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (examen_id)
);

DROP TABLE IF EXISTS liste_des_symptomes CASCADE;
CREATE TABLE IF NOT EXISTS liste_des_symptomes (
  maladie_id integer NOT NULL,
  symptome_id integer NOT NULL
);

DROP TABLE IF EXISTS maladie CASCADE;
CREATE TABLE IF NOT EXISTS maladie (
  maladie_id SERIAL,
  maladie_nom varchar(50) NOT NULL,
  maladie_description text NOT NULL,
  traitement_id integer NOT NULL,
  PRIMARY KEY (maladie_id)
);

DROP TABLE IF EXISTS medicament CASCADE;
CREATE TABLE IF NOT EXISTS medicament (
  medicament_id SERIAL,
  medicament_nom varchar(50) NOT NULL,
  PRIMARY KEY (medicament_id)
);

DROP TABLE IF EXISTS patient CASCADE;
CREATE TABLE IF NOT EXISTS patient (
  patient_id SERIAL,
  patient_nom varchar(50) NOT NULL,
  patient_prenom varchar(50) NOT NULL,
  patient_email varchar(50) NOT NULL,
  patient_telephone varchar(20) NOT NULL,
  patient_numero_de_rue integer NOT NULL,
  patient_rue varchar(75) NOT NULL,
  patient_ville varchar(75) NOT NULL,
  patient_code_postal integer NOT NULL,
  patient_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (patient_id)
);

DROP TABLE IF EXISTS role CASCADE;
CREATE TABLE IF NOT EXISTS role (
  role_id SERIAL,
  role_nom varchar(50) NOT NULL,
  PRIMARY KEY (role_id)
);

INSERT INTO role(role_id, role_nom) VALUES
(1, 'Paramédical'),
(2, 'Médecin'),
(3, 'Administration'),
(4, 'Statistiques'),
(5, 'Super user'),
(6, 'Superviseur'),
(7, 'SSII');

DROP TABLE IF EXISTS symptome CASCADE;
CREATE TABLE IF NOT EXISTS symptome (
  symptome_id SERIAL,
  symptome_nom varchar(50) NOT NULL,
  symptome_description text NOT NULL,
  PRIMARY KEY (symptome_id)
);

DROP TABLE IF EXISTS specialisation CASCADE;
CREATE TABLE specialisation(
  specialisation_id serial,
  specialisation_nom varchar(250) UNIQUE,
  PRIMARY KEY (specialisation_id)
);

INSERT INTO specialisation(specialisation_id, specialisation_nom) VALUES
(1, ''),
(2, 'Allergologie'),
(3, 'Anesthésie-Réanimation'),
(4, 'Anatomie et Cytologie pathologiques'),
(5, 'Biologie médicale'),
(6, 'Chirurgie Maxillo-Faciale'),
(7, 'Chirurgie Orale'),
(8, 'Chirurgie Orthopédique et traumatologique'),
(9, 'Chirurgie Pédiatrique'),
(10, 'Chirurgie plastique, reconstructrice et esthétique'),
(11, 'Chirurgie Thoracique et Cardio-Vasculaire'),
(12, 'Chirurgie Vasculaire'),
(13, 'Chirurgie Viscérale et Digestive'),
(14, 'Dermatologie – Vénérologie'),
(15, 'Endocrinologie, diabétologie et nutrition'),
(16, 'Génétique médicale'),
(17, 'Gériatrie'),
(18, 'Gynécologie médicale'),
(19, 'Gynécologie – Obstétrique'),
(20, 'Hématologie'),
(21, 'Hépato-gastro-entérologie'),
(22, 'Maladies Infectieuses et Tropicales'),
(23, 'Médecine Cardiovasculaire'),
(24, 'Médecine Générale'),
(25, 'Médecine Intensive-Réanimation'),
(26, 'Médecine Interne et Immunologie clinique'),
(27, 'Médecine Légale et expertise médicale'),
(28, 'Médecine Nucléaire'),
(29, 'Médecine Physique et Réadaptation'),
(30, 'Médecine et Santé au Travail'),
(31, 'Médecine Vasculaire'),
(32, 'Médecine d’Urgence'),
(33, 'Néphrologie'),
(34, 'Neurochirurgie'),
(35, 'Neurologie'),
(36, 'Oncologie : Option précoce – Oncologie Médicale'),
(37, 'Oncologie : Option précoce – Radiothérapie'),
(38, 'Ophtalmologie'),
(39, 'Oto-rhino-laryngologie et chirurgie cervico-faciale'),
(40, 'Pédiatrie'),
(41, 'Pneumologie'),
(42, 'Psychiatrie'),
(43, 'Radiologie et Imagerie Médicale'),
(44, 'Rhumatologie'),
(45, 'Santé publique'),
(46, 'Urologie');

DROP TABLE IF EXISTS traitement CASCADE;
CREATE TABLE IF NOT EXISTS traitement (
  traitement_id SERIAL,
  traitement_nom varchar(10),
  traitement_description text,
  PRIMARY KEY (traitement_id)
);

DROP TABLE IF EXISTS utilisateur CASCADE;
CREATE TABLE IF NOT EXISTS utilisateur (
  utilisateur_id SERIAL,
  entreprise_siren varchar(9) NOT NULL,
  utilisateur_activation boolean NOT NULL,
  role_id integer NOT NULL,
  specialisation_id integer,
  utilisateur_nom varchar(50) NOT NULL,
  utilisateur_prenom varchar(50) NOT NULL,
  utilisateur_email varchar(50) NOT NULL UNIQUE,
  utilisateur_telephone varchar(20) NOT NULL UNIQUE,
  utilisateur_numero_de_rue integer NOT NULL,
  utilisateur_rue varchar(75) NOT NULL,
  utilisateur_ville varchar(75) NOT NULL,
  utilisateur_code_postal varchar(5) NOT NULL,
  utilisateur_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (utilisateur_id)
);

INSERT INTO utilisateur(utilisateur_id, entreprise_siren, utilisateur_activation, role_id, specialisation_id, utilisateur_nom, utilisateur_prenom, utilisateur_email, utilisateur_telephone, 
  utilisateur_numero_de_rue, utilisateur_rue, utilisateur_ville, utilisateur_code_postal) VALUES
(1, '123456788', True, 6, 1, 'Keita', 'Cheik-Siramakan', 'cheiksiramakankeita@gmail.com', '0605557802', 57, 'Boulevard de l Yerres', 'Evry-Courcouronnes', 91000),
(2, '012345678', True, 6, 6, 'Drisse', 'Matthieu', 'mattdrisse@gmail.com', '0600000000', 1, 'Je ne sais pas', 'Campagne', 91000);

ALTER TABLE authentification
  ADD CONSTRAINT fk_authentification_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (utilisateur_id) ON DELETE CASCADE;

ALTER TABLE examen
  ADD CONSTRAINT fk_examen_docteur FOREIGN KEY (docteur_id) REFERENCES utilisateur (utilisateur_id) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT fk_examen_patient FOREIGN KEY (patient_id) REFERENCES patient (patient_id) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE interpretation
  ADD CONSTRAINT fk_interpretation_examen FOREIGN KEY (examen_id) REFERENCES examen (examen_id) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT fk_interpretation_maladie FOREIGN KEY (maladie_id) REFERENCES maladie (maladie_id) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT fk_interpretation_docteur FOREIGN KEY (docteur_id) REFERENCES utilisateur (utilisateur_id) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE liste_des_medicaments
ADD CONSTRAINT fk_liste_des_medicaments_traitement FOREIGN KEY (traitement_id) REFERENCES traitement (traitement_id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT fk_liste_des_medicaments_medicament FOREIGN KEY (medicament_id) REFERENCES medicament (medicament_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE liste_des_symptomes
  ADD CONSTRAINT fk_liste_des_symptomes_maladie FOREIGN KEY (maladie_id) REFERENCES maladie (maladie_id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_liste_des_symptomes_symptome FOREIGN KEY (symptome_id) REFERENCES symptome (symptome_id) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE maladie
  ADD CONSTRAINT fk_maladie_traitement FOREIGN KEY (traitement_id) REFERENCES traitement (traitement_id) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE utilisateur
  ADD CONSTRAINT fk_utilisateur_entreprise FOREIGN KEY (entreprise_siren) REFERENCES entreprise (entreprise_siren) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT fk_utilisateur_role FOREIGN KEY (role_id) REFERENCES role (role_id) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT fk_utilisateur_specialisation FOREIGN KEY (specialisation_id) REFERENCES specialisation (specialisation_id) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;