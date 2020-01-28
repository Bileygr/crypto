/*
  * Script de création de la base de données du projet "Soteria" pour le module de SQL.
  * Par Matthieu Drisse et Cheik-Siramakan Keita
  * Pour monsieur Palacios
  * 2019-2020
*/

DROP TABLE IF EXISTS authentification;
CREATE TABLE IF NOT EXISTS authentification (
  utilisateur_id integer NOT NULL UNIQUE,
  authentification_mot_de_passe varchar(64) NOT NULL,
  authentification_cle_secrete varchar(20) NOT NULL,
  PRIMARY KEY (utilisateur_id)
);

DROP TABLE IF EXISTS consultation;
CREATE TABLE IF NOT EXISTS consultation (
  consultation_id SERIAL,
  consultation_doc_id integer NOT NULL,
  consultation_patient_id integer NOT NULL,
  diagnostique_id integer NOT NULL,
  consultation_prix float NOT NULL,
  consultation_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (consultation_id)
);

DROP TABLE IF EXISTS diagnostique;
CREATE TABLE IF NOT EXISTS diagnostique(
  consultation_id integer NOT NULL UNIQUE,
  maladie_id integer,
  diagnostique_note text,
  diagnostique_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (consultation_id)
);

DROP TABLE IF EXISTS liste_des_medicaments;
CREATE TABLE IF NOT EXISTS liste_des_medicaments (
  traitement_id integer,
  medicament_id integer NOT NULL,
  medicament_dose float NOT NULL
);

DROP TABLE IF EXISTS liste_des_symptomes;
CREATE TABLE IF NOT EXISTS liste_des_symptomes (
  maladie_id integer NOT NULL,
  symptome_id integer NOT NULL
);

DROP TABLE IF EXISTS maladie;
CREATE TABLE IF NOT EXISTS maladie (
  maladie_id SERIAL,
  maladie_nom varchar(50) NOT NULL,
  maladie_description text NOT NULL,
  traitement_id integer NOT NULL,
  PRIMARY KEY (maladie_id)
);

DROP TABLE IF EXISTS medicament;
CREATE TABLE IF NOT EXISTS medicament (
  medicament_id SERIAL,
  medicament_nom varchar(50) NOT NULL,
  PRIMARY KEY (medicament_id)
);

DROP TABLE IF EXISTS role;
CREATE TABLE IF NOT EXISTS role (
  role_id SERIAL,
  role_nom varchar(50) NOT NULL,
  PRIMARY KEY (role_id)
);

INSERT INTO role(role_id, role_nom) VALUES
(1, 'Patient'),
(2, 'Paramédical'),
(3, 'Médecin'),
(4, 'Administration'),
(5, 'Chercheur');

DROP TABLE IF EXISTS symptome;
CREATE TABLE IF NOT EXISTS symptome (
  symptome_id SERIAL,
  symptome_nom varchar(50) NOT NULL,
  symptome_description text NOT NULL,
  PRIMARY KEY (symptome_id)
);

DROP TABLE IF EXISTS specialisation;
CREATE TABLE specialisation(
  specialisation_id serial,
  specialisation_nom varchar(50) UNIQUE,
  PRIMARY KEY (specialisation_id)
);

DROP TABLE IF EXISTS traitement;
CREATE TABLE IF NOT EXISTS traitement (
  traitement_id SERIAL,
  traitement_description text,
  PRIMARY KEY (traitement_id)
);

DROP TABLE IF EXISTS utilisateur;
CREATE TABLE IF NOT EXISTS utilisateur (
  utilisateur_id SERIAL,
  utilisatuer_actif boolean,
  role_id integer NOT NULL,
  specialisation_id integer,
  utilisateur_nom varchar(50) NOT NULL,
  utilisateur_prenom varchar(50) NOT NULL,
  utilisateur_email varchar(50) NOT NULL,
  utilisateur_telephone varchar(20) NOT NULL,
  utilisateur_numero_de_rue integer NOT NULL,
  utilisateur_rue varchar(75) NOT NULL,
  utilisateur_ville varchar(75) NOT NULL,
  utilisateur_code_postal integer NOT NULL,
  utilisateur_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (utilisateur_id)
);

ALTER TABLE authentification
  ADD CONSTRAINT fk_authentification_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (utilisateur_id) ON DELETE CASCADE;

ALTER TABLE consultation
  ADD CONSTRAINT fk_consultation_doc FOREIGN KEY (consultation_doc_id) REFERENCES utilisateur (utilisateur_id) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT fk_consultation_patient FOREIGN KEY (consultation_patient_id) REFERENCES utilisateur (utilisateur_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE diagnostique
  ADD CONSTRAINT fk_diagnostique_consultation FOREIGN KEY (consultation_id) REFERENCES consultation (consultation_id) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE liste_des_medicaments
ADD CONSTRAINT fk_liste_des_medicaments_traitement FOREIGN KEY (traitement_id) REFERENCES traitement (traitement_id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT fk_liste_des_medicaments_medicament FOREIGN KEY (medicament_id) REFERENCES medicament (medicament_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE liste_des_symptomes
  ADD CONSTRAINT fk_liste_des_symptomes_maladie FOREIGN KEY (maladie_id) REFERENCES maladie (maladie_id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_liste_des_symptomes_symptome FOREIGN KEY (symptome_id) REFERENCES symptome (symptome_id) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE maladie
  ADD CONSTRAINT fk_maladie_traitement FOREIGN KEY (traitement_id) REFERENCES traitement (traitement_id) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE utilisateur
  ADD CONSTRAINT fk_utilisateur_role FOREIGN KEY (role_id) REFERENCES role (role_id) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT fk_utilisateur_specialisation FOREIGN KEY (specialisation_id) REFERENCES specialisation (specialisation_id) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;