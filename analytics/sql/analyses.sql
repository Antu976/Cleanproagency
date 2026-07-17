-- =====================================================================
--  Clean Pro Agency — Pack de requêtes analytiques
--  Base : cleanpro (MariaDB)
--  Objectif : indicateurs de pilotage à partir des rendez-vous.
--  NB : selon la version, la table `rdv` peut contenir un libellé texte
--       (`service_rdv`) et/ou une clé `id_service` vers `service`.
--       Les requêtes ci-dessous s'appuient sur `service_rdv`, `date_rdv`,
--       `heure_rdv`, `frequence`, `nbr_article`.
-- =====================================================================

USE cleanpro;

-- ---------------------------------------------------------------------
-- 1. Volume de rendez-vous par service
-- ---------------------------------------------------------------------
SELECT service_rdv                                   AS service,
       COUNT(*)                                      AS nb_rdv,
       ROUND(100 * COUNT(*) / SUM(COUNT(*)) OVER (), 1) AS part_pct
FROM   rdv
GROUP  BY service_rdv
ORDER  BY nb_rdv DESC;

-- ---------------------------------------------------------------------
-- 2. Chiffre d'affaires par service (quantité x prix unitaire)
--    Jointure avec le catalogue `service`.
-- ---------------------------------------------------------------------
SELECT s.type_service,
       COUNT(r.id)                     AS nb_rdv,
       SUM(r.nbr_article)              AS articles,
       ROUND(SUM(r.nbr_article * s.prix), 2) AS ca_estime
FROM   rdv r
JOIN   service s ON s.id_service = r.id_service
GROUP  BY s.type_service
ORDER  BY ca_estime DESC;

-- ---------------------------------------------------------------------
-- 3. Évolution mensuelle du volume (saisonnalité)
-- ---------------------------------------------------------------------
SELECT DATE_FORMAT(date_rdv, '%Y-%m') AS mois,
       COUNT(*)                       AS nb_rdv
FROM   rdv
GROUP  BY DATE_FORMAT(date_rdv, '%Y-%m')
ORDER  BY mois;

-- ---------------------------------------------------------------------
-- 4. Taux d'occupation par créneau horaire
-- ---------------------------------------------------------------------
SELECT HOUR(heure_rdv)  AS heure,
       COUNT(*)         AS reservations
FROM   rdv
GROUP  BY HOUR(heure_rdv)
ORDER  BY heure;

-- ---------------------------------------------------------------------
-- 5. Charge par jour de la semaine (lundi = fermé)
-- ---------------------------------------------------------------------
SELECT DAYNAME(date_rdv) AS jour,
       COUNT(*)          AS nb_rdv
FROM   rdv
GROUP  BY DAYOFWEEK(date_rdv), DAYNAME(date_rdv)
ORDER  BY DAYOFWEEK(date_rdv);

-- ---------------------------------------------------------------------
-- 6. Répartition des fréquences (indicateur de récurrence / fidélité)
-- ---------------------------------------------------------------------
SELECT frequence,
       COUNT(*)                                      AS nb,
       ROUND(100 * COUNT(*) / SUM(COUNT(*)) OVER (), 1) AS pct
FROM   rdv
GROUP  BY frequence
ORDER  BY nb DESC;

-- ---------------------------------------------------------------------
-- 7. Top 10 des villes clientes
-- ---------------------------------------------------------------------
SELECT ville_rdv        AS ville,
       COUNT(*)         AS nb_clients
FROM   client
GROUP  BY ville_rdv
ORDER  BY nb_clients DESC
LIMIT  10;

-- ---------------------------------------------------------------------
-- 8. Panier moyen (nombre d'articles moyen par rendez-vous)
-- ---------------------------------------------------------------------
SELECT service_rdv                        AS service,
       ROUND(AVG(nbr_article), 2)         AS articles_moyens,
       MAX(nbr_article)                   AS articles_max
FROM   rdv
GROUP  BY service_rdv
ORDER  BY articles_moyens DESC;

-- ---------------------------------------------------------------------
-- 9. Clients les plus actifs (top 10 par nombre de rendez-vous)
-- ---------------------------------------------------------------------
SELECT c.id_client,
       c.prenom_client,
       c.name_client,
       COUNT(r.id) AS nb_rdv
FROM   client c
JOIN   rdv r ON r.id_client = c.id_client
GROUP  BY c.id_client, c.prenom_client, c.name_client
ORDER  BY nb_rdv DESC
LIMIT  10;

-- ---------------------------------------------------------------------
-- 10. Nouveaux clients par mois (acquisition)
--     (nécessite une colonne de date d'inscription ; sinon 1er RDV)
-- ---------------------------------------------------------------------
SELECT DATE_FORMAT(MIN(r.date_rdv), '%Y-%m') AS mois_1er_rdv,
       COUNT(DISTINCT r.id_client)           AS nb_nouveaux_clients
FROM   rdv r
GROUP  BY r.id_client;   -- à agréger ensuite par mois côté BI

-- ---------------------------------------------------------------------
-- 11. Satisfaction moyenne par service (table `commentaire`)
-- ---------------------------------------------------------------------
SELECT s.type_service,
       ROUND(AVG(c.note), 2) AS note_moyenne,
       COUNT(*)              AS nb_avis
FROM   commentaire c
JOIN   service s ON s.id_service = c.id_service
GROUP  BY s.type_service
ORDER  BY note_moyenne DESC;

-- ---------------------------------------------------------------------
-- 12. Taux d'annulation (si la colonne `statut` existe)
-- ---------------------------------------------------------------------
-- SELECT statut, COUNT(*) AS nb,
--        ROUND(100 * COUNT(*) / SUM(COUNT(*)) OVER (), 1) AS pct
-- FROM   rdv
-- GROUP  BY statut;
