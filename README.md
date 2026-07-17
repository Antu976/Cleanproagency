# Clean Pro Agency — Plateforme de réservation & modèle de données

> Création d'un site de A à Z, et pousser la chose plus loin en générant des données et les étudier 

Ainsi ce dépot sert de support de démonstration d'un profil orienté Data, 
---

## Module Data Analytics

En complément de l'application, un **module d'analyse de données** exploite les
rendez-vous, de la donnée brute à la décision — voir `analytics`.

- **Dataset générée** : 500 clients · 2 371 rendez-vous · 983 avis (18 mois).
- **Pack SQL** : 12 requêtes analytiques [`analytics/sql/analyses.sql`].
- **Notebook Python** (pandas + matplotlib) : [`analytics/notebook/analyse_cleanpro.ipynb`].
- **Tableau de bord interactif** (Chart.js) : [`analytics/dashboard/dashboard.html`].

## Sommaire

1. aperçu-fonctionnel
2. stack-technique
3. architecture-applicative
4. modèle-de-données
5. qualité--intégrité-des-données
6. exploitation-analytique-kpis--sql
7. installation--exécution
8. structure-du-projet
9. pistes-damélioration



## 1. Aperçu fonctionnel

- **Navigation libre** : accueil, pages par service, à propos, mentions légales.
- **Comptes clients** : inscription et connexion (mots de passe hachés `bcrypt`).
- **Réservation encadrée** : sélection d'un service, d'une fréquence, d'une
  quantité, d'une **date ouvrée** et d'un **créneau horaire** issu d'un planning
  temps réel (créneaux déjà pris grisés).
- **Gestion des rendez-vous** : consultation, modification et suppression,
  réservées à l'utilisateur connecté.
- **Contrôle d'accès** : la réservation et la gestion exigent un compte ;
  l'utilisateur non connecté est redirigé vers la connexion puis **ramené
  automatiquement** à l'action demandée.



## 2. Stack technique

| Couche | Technologie |
|---|---|
| Langage serveur | PHP 8 (PDO, requêtes préparées) |
| Base de données | MariaDB 10.9 |
| Serveur web | Apache 2 |
| Administration BDD | phpMyAdmin |
| Conteneurisation | Docker / Docker Compose (stack **DAMP**) |
| Front | HTML5, CSS3 (design system maison), JavaScript (validation & planning) |
| Donnée externe | API officielle **geo.api.gouv.fr** (référentiel des communes) |



## 3. Architecture applicative

Organisation de type **MVC léger** — la logique, l'accès aux données et
l'affichage sont séparés :

```
Contrôleur (rdv.php, inscription.php, …)
   ├── Modèle   (model/*.php)      → accès BDD via PDO préparé
   └── Vue      (view/*.php)       → présentation, aucune requête SQL
```

Chaque page suit le même flux : `contrôleur` → inclusion de la `vue` d'en-tête,
du contenu, puis du pied de page.



## 4. Modèle de données

Base `cleanpro` — schéma relationnel Le cœur applicatif s'appuie sur `client` et `rdv` ; 
le schéma
complet prévoit la gestion des prestataires, devis, services et avis.

### Diagramme entités-associations

```mermaid
erDiagram
    CLIENT{ RDV : "réserve"
            DEVIS : "demande"
            COMMENTAIRE : "publie"
    SERVICE{ RDV : "concerné par"
             COMMENTAIRE : "évalué par"
             PRESTATAIRE_SERVICE : "assuré par"
             DEVIS : "redaction"
             COMMENTAIRE : "appreciation"
    RDV{ PRESTATAIRE_SERVICE : "honorer"

    CLIENT {
        int id_client PK
        varchar name_client
        varchar prenom_client
        varchar email_client UK
        int telephone
        varchar adresse
        int code_postale
        varchar ville_rdv
        varchar mdp
    }
    RDV {
        int id PK
        varchar service_rdv
        varchar frequence
        int nbr_article
        date date_rdv
        time heure_rdv
        varchar services_supplementaire
        int id_client FK
        int id_service FK
    }
    SERVICE {
        int id_service PK
        varchar type_service
        float prix
        varchar description_service
    }
    DEVIS {
        int id_devis PK
        date date_demande
        float prix_estime
        int id_client FK
    }
    PRESTATAIRE_SERVICE {
        int id_prestataire PK
        varchar email_prestataire UK
        int id_service FK
    }
    COMMENTAIRE {
        int id_commentaire PK
        int note
        date date_publication
        int id_client FK
        int id_service FK
    }
```

### Tables principales

| Table | Rôle | Points clés |
|---|---|---|
| `client` | Comptes utilisateurs | `email_client` **UNIQUE**, mot de passe **haché** |
| `rdv` | Rendez-vous | `date_rdv` (DATE) + `heure_rdv` (TIME), clés vers `client` et `service` |
| `service` | Catalogue de prestations | `prix` (base de tout calcul de CA) |
| `prestataire_service` | Intervenants | rattachés à un `service` |
| `devis` | Demandes de devis | `prix_estime`, rattaché au `client` |
| `commentaire` | Avis clients | `note` (satisfaction), `date_publication` |

Les tables `redaction`, `honorer`, `appreciation` matérialisent les
**associations N–N** (service⇄devis, rendez-vous⇄prestataire, service⇄avis).

---

## 5. Qualité & intégrité des données

La collecte est verrouillée à **trois niveaux** pour éviter toute donnée erronée
(« garbage in, garbage out ») :

**Au niveau base**
- Intégrité référentielle par **clés étrangères** (FK).
- **Unicité** de l'email client.
- Typage strict des colonnes (DATE, TIME, INT…).

**Au niveau serveur (PHP, non contournable)**
- Requêtes **préparées** (PDO) → protection contre l'injection SQL.
- Email validé (`FILTER_VALIDATE_EMAIL`) et **unicité vérifiée** avant insertion.
- Téléphone français normalisé et validé (`^(?:\+33|0)[1-9]\d{8}$`).
- Code postal à **5 chiffres**.
- Nom / prénom / ville : **lettres uniquement** (regex Unicode `\p{L}`).
- Mot de passe haché en **bcrypt** (`password_hash`).
- Règles métier de réservation : date non passée, **jour d'ouverture**
  (mardi–samedi), créneau horaire valide, **unicité du créneau** (anti double
  réservation).

**Via une source de données externe**
- Cohérence **code postal ↔ ville** vérifiée en temps réel contre le
  **référentiel officiel des communes** (`geo.api.gouv.fr`). En cas de
  non-correspondance, les communes valides sont proposées à l'utilisateur.

**Au niveau client (UX)**
- Contrôles immédiats (formats, planning des créneaux, blocage de la soumission
  tant que les données sont invalides).

---

## 6. Exploitation analytique (KPIs & SQL)

Les données de réservation constituent une base directement **exploitable pour
le pilotage de l'activité**. Exemples de requêtes analytiques :

**Volume de rendez-vous par service**
```sql
SELECT service_rdv, COUNT(*) AS nb_rdv
FROM rdv
GROUP BY service_rdv
ORDER BY nb_rdv DESC;
```

**Taux d'occupation par créneau horaire**
```sql
SELECT HOUR(heure_rdv) AS heure, COUNT(*) AS reservations
FROM rdv
GROUP BY HOUR(heure_rdv)
ORDER BY heure;
```

**Charge par jour de la semaine**
```sql
SELECT DAYNAME(date_rdv) AS jour, COUNT(*) AS nb_rdv
FROM rdv
GROUP BY DAYNAME(date_rdv)
ORDER BY nb_rdv DESC;
```

**Répartition des fréquences (fidélisation)**
```sql
SELECT frequence, COUNT(*) AS nb,
       ROUND(100 * COUNT(*) / (SELECT COUNT(*) FROM rdv), 1) AS pct
FROM rdv
GROUP BY frequence;
```

**Top des villes clientes**
```sql
SELECT ville_rdv, COUNT(*) AS nb_clients
FROM client
GROUP BY ville_rdv
ORDER BY nb_clients DESC
LIMIT 10;
```

**Chiffre d'affaires estimé par service** (jointure `rdv` × `service`)
```sql
SELECT s.type_service,
       COUNT(r.id)              AS nb_rdv,
       SUM(r.nbr_article * s.prix) AS ca_estime
FROM rdv r
JOIN service s ON s.id_service = r.id_service
GROUP BY s.type_service
ORDER BY ca_estime DESC;
```

**Satisfaction moyenne par service** (jointure `commentaire` × `service`)
```sql
SELECT s.type_service, ROUND(AVG(c.note), 2) AS note_moyenne, COUNT(*) AS nb_avis
FROM commentaire c
JOIN service s ON s.id_service = c.id_service
GROUP BY s.type_service
ORDER BY note_moyenne DESC;
```

> Ces indicateurs (volume, occupation, saisonnalité, CA, satisfaction) peuvent
> être branchés sur un outil de visualisation (Power BI, Metabase, Looker
> Studio) pour un **tableau de bord de pilotage**.

Un **module d'analyse complet** est disponible dans [`analytics/`](analytics/README.md) :
jeu de données réaliste, pack SQL, notebook Python (pandas + graphiques) et
**tableau de bord interactif** (Chart.js).

---

## 7. Installation & exécution

**Prérequis** : Docker Desktop.

```bash
# 1. Lancer la stack (Windows) : double-cliquer sur
startup.bat
```

Le script démarre les conteneurs et expose :

| Service | URL |
|---|---|
| Site (PHP/Apache) | http://localhost:8080 |
| phpMyAdmin | http://localhost:9090 |
| MariaDB | localhost:3306 |

Identifiants BDD par défaut : `root` / `root`.

**Initialiser le schéma** : importer `data/htdocs/utils/ma_base.sql` dans
phpMyAdmin (crée la base `cleanpro` et ses tables).

> Sans Docker, la stack fonctionne aussi sous XAMPP / Laragon en plaçant le
> contenu de `data/htdocs/` dans le répertoire web et en adaptant la connexion
> (`utils/bdd.php`) à `localhost`.

---

## 8. Structure du projet

```
data/htdocs/
├── index.php, rdv.php, service.php, recap.php, modifier.php …   # contrôleurs
├── model/        # accès aux données (PDO)
├── view/         # gabarits d'affichage (header, footer, pages)
├── style/        # feuilles de style (theme.css = design system)
├── script/       # JS (carrousel, planning, validations)
├── img/          # visuels
└── utils/
    ├── bdd.php       # connexion PDO
    └── ma_base.sql   # schéma de la base
```

---

## 9. Pistes d'amélioration

- **Qualité des données** : stocker `telephone` et `code_postale` en `VARCHAR`
  plutôt qu'en `INT` (les types entiers suppriment les zéros initiaux, ex.
  `01000` → `1000`).
- **Normalisation** : rattacher `rdv.id_service` au catalogue `service` (plutôt
  qu'un libellé texte `service_rdv`) pour des jointures et un calcul de CA fiables.
- **Traçabilité** : ajouter des colonnes `created_at` / `updated_at` pour
  l'analyse temporelle.
- **Dashboard** : exposer les KPIs ci-dessus dans un outil de BI.
- **Tests** : ajouter des jeux de données de test et des contrôles automatisés.

---

_Projet réalisé dans une démarche produit **et** données : de la modélisation à
la validation, jusqu'à l'exploitation analytique._
