-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 17 fév. 2026 à 12:18
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `garage`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis_clients`
--

CREATE TABLE `avis_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `reparation_id` bigint(20) UNSIGNED NOT NULL,
  `note` int(11) NOT NULL,
  `commentaire` text DEFAULT NULL,
  `date_avis` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `avis_clients`
--

INSERT INTO `avis_clients` (`id`, `client_id`, `reparation_id`, `note`, `commentaire`, `date_avis`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, 'Techniciens compétents et aimables.', '2026-01-03 11:21:14', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(2, 1, 2, 4, 'Très satisfait de la réparation, à bientôt.', '2026-01-27 11:21:14', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(3, 1, 3, 4, 'Très satisfait de la réparation, à bientôt.', '2026-02-14 11:21:14', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(4, 5, 8, 4, 'Travail impeccable, merci!', '2025-12-10 11:21:14', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(5, 2, 12, 4, 'Très satisfait de la réparation, à bientôt.', '2025-11-21 11:21:14', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(6, 3, 13, 4, 'Service rapide et efficace.', '2025-11-28 11:21:14', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(7, 3, 14, 5, 'Réparation bien faite, prix raisonnable.', '2025-12-17 11:21:14', '2026-02-16 11:21:14', '2026-02-16 11:21:14');

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `utilisateur_id` bigint(20) UNSIGNED NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `code_postal` varchar(255) DEFAULT NULL,
  `numero_client` varchar(255) DEFAULT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `utilisateur_id`, `adresse`, `ville`, `code_postal`, `numero_client`, `date_inscription`, `created_at`, `updated_at`) VALUES
(1, 2, 'Avenue de France, Lomé', 'Lomé', '00228', NULL, '2026-02-16 12:21:10', '2026-02-16 11:21:10', '2026-02-16 11:21:10'),
(2, 3, 'Boulevard de la Paix, Lomé', 'Lomé', '00228', NULL, '2026-02-16 12:21:10', '2026-02-16 11:21:10', '2026-02-16 11:21:10'),
(3, 4, 'Rue du Marché, Lomé', 'Lomé', '00228', NULL, '2026-02-16 12:21:11', '2026-02-16 11:21:11', '2026-02-16 11:21:11'),
(4, 5, 'Avenue de Coolona, Lomé', 'Lomé', '00228', NULL, '2026-02-16 12:21:11', '2026-02-16 11:21:11', '2026-02-16 11:21:11'),
(5, 6, 'Rue de la Gare, Lomé', 'Lomé', '00228', NULL, '2026-02-16 12:21:11', '2026-02-16 11:21:11', '2026-02-16 11:21:11');

-- --------------------------------------------------------

--
-- Structure de la table `conseils`
--

CREATE TABLE `conseils` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `statut` enum('brouillon','publie') NOT NULL DEFAULT 'publie',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `conseils`
--

INSERT INTO `conseils` (`id`, `titre`, `contenu`, `categorie`, `image`, `statut`, `created_at`, `updated_at`) VALUES
(1, 'Révision régulière pour une meilleure longévité', 'Une révision régulière de votre véhicule est essentielle pour maintenir ses performances et sa sécurité. Nous recommandons une révision tous les 15 000 km ou tous les 6 mois.', 'Entretien', NULL, 'publie', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(2, 'Comment prendre soin de vos pneus', 'Vérifiez régulièrement la pression de vos pneus, l\'usure de la bande de roulement et l\'alignement de vos roues. Des pneus bien entretenus garantissent votre sécurité et une meilleure économie de carburant.', 'Sécurité', NULL, 'publie', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(3, 'L\'importance de la batterie', 'La batterie est le cœur de votre véhicule. Assurez-vous qu\'elle est bien chargée et vérifiez ses bornes régulièrement. Une batterie faible peut causer de nombreux problèmes de démarrage.', 'Électricité', NULL, 'publie', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(4, 'Économies de carburant: nos conseils', 'Pour économiser du carburant: maintenez une vitesse stable, évitez les accélérations brusques, assurez-vous que la pression des pneus est correcte et maintenez votre véhicule en bon état.', 'Consommation', NULL, 'publie', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(5, 'Climatisation: comment l\'entretenir', 'Faites vérifier votre climatisation au moins une fois par an. Un système de climatisation bien entretenu refroidit mieux et consomme moins d\'énergie.', 'Climatisation', NULL, 'publie', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(6, 'Freins: un élément crucial pour la sécurité', 'Vérifiez l\'état de vos plaquettes et disques de frein régulièrement. Si vous remarquez une usure anormale ou des bruits, faites réviser votre système de freinage immédiatement.', 'Sécurité', NULL, 'publie', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(7, 'Huile moteur: le cœur du moteur', 'Changez votre huile moteur selon le kilométrage recommandé par le fabricant. Une bonne lubrification du moteur est essentielle pour sa longévité.', 'Entretien', NULL, 'publie', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(8, 'Préparation avant un long voyage', 'Avant un long trajet: vérifiez les niveaux de fluides, l\'état des pneus, des freins, et assurez-vous que tous les feux fonctionnent correctement.', 'Voyages', NULL, 'publie', '2026-02-16 11:21:14', '2026-02-16 11:21:14');

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

CREATE TABLE `devis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reparation_id` bigint(20) UNSIGNED NOT NULL,
  `description_travaux` text NOT NULL,
  `montant_total` decimal(10,2) NOT NULL,
  `date_emission` timestamp NOT NULL DEFAULT current_timestamp(),
  `validite_jours` int(11) NOT NULL DEFAULT 15,
  `statut` enum('brouillon','envoye','accepte','refuse','depasse') NOT NULL DEFAULT 'brouillon',
  `date_acceptation` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `interventions_technicien`
--

CREATE TABLE `interventions_technicien` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reparation_id` bigint(20) UNSIGNED NOT NULL,
  `technicien_id` bigint(20) UNSIGNED NOT NULL,
  `date_debut` timestamp NULL DEFAULT NULL,
  `date_fin` timestamp NULL DEFAULT NULL,
  `duree_minutes` int(11) NOT NULL DEFAULT 0,
  `commentaires` text DEFAULT NULL,
  `cout_intervention` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `interventions_technicien`
--

INSERT INTO `interventions_technicien` (`id`, `reparation_id`, `technicien_id`, `date_debut`, `date_fin`, `duree_minutes`, `commentaires`, `cout_intervention`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-01-12 11:21:13', NULL, 1259, NULL, 0.00, '2026-02-16 11:21:13', '2026-02-16 11:21:13'),
(2, 2, 3, '2026-01-19 11:21:14', NULL, 1903, NULL, 0.00, '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(3, 3, 1, '2025-12-20 11:21:14', NULL, 2345, NULL, 0.00, '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(4, 5, 2, '2026-01-04 11:21:14', '2026-01-15 11:21:14', 2232, NULL, 0.00, '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(5, 6, 2, '2026-02-15 11:21:14', '2026-02-16 11:21:14', 526, NULL, 0.00, '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(6, 7, 1, '2026-02-01 11:21:14', '2026-02-06 11:21:14', 1262, NULL, 0.00, '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(7, 8, 2, '2026-02-04 11:21:14', '2026-02-19 11:21:14', 1299, NULL, 0.00, '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(8, 11, 3, '2026-02-06 11:21:14', NULL, 386, NULL, 0.00, '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(9, 12, 3, '2026-01-08 11:21:14', NULL, 1783, NULL, 0.00, '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(10, 13, 2, '2026-01-14 11:21:14', '2026-01-16 11:21:14', 1310, NULL, 0.00, '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(11, 14, 3, '2025-12-31 11:21:14', '2026-01-09 11:21:14', 503, NULL, 0.00, '2026-02-16 11:21:14', '2026-02-16 11:21:14');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages_contact`
--

CREATE TABLE `messages_contact` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `sujet` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `statut` enum('non_lu','lu','repondu') NOT NULL DEFAULT 'non_lu',
  `date_message` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '0001_01_01_000005_add_affectation_to_interventions', 1),
(5, '2026_01_15_000100_create_akva_auto_tables', 1);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `utilisateur_id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'info',
  `reparation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date_lecture` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recus`
--

CREATE TABLE `recus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reparation_id` bigint(20) UNSIGNED NOT NULL,
  `numero_recu` varchar(255) NOT NULL,
  `montant_total` decimal(10,2) NOT NULL,
  `methode_paiement` enum('especes','cheque','carte','virement','mobile_money') DEFAULT NULL,
  `details` text DEFAULT NULL,
  `date_paiement` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reparations`
--

CREATE TABLE `reparations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicule_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `date_depot` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_fin_prevue` timestamp NULL DEFAULT NULL,
  `date_fin_reelle` timestamp NULL DEFAULT NULL,
  `description_panne` text NOT NULL,
  `statut` enum('en_attente','en_cours','termine','livree','annulee') NOT NULL DEFAULT 'en_attente',
  `estimation_cout` decimal(10,2) DEFAULT NULL,
  `cout_final` decimal(10,2) DEFAULT NULL,
  `notes_admin` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reparations`
--

INSERT INTO `reparations` (`id`, `vehicule_id`, `client_id`, `date_depot`, `date_fin_prevue`, `date_fin_reelle`, `description_panne`, `statut`, `estimation_cout`, `cout_final`, `notes_admin`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-01-12 11:21:13', '2026-01-17 11:21:13', NULL, 'Réparation climatisation', 'en_cours', 3436.06, NULL, 'Test', '2026-02-16 11:21:13', '2026-02-16 11:21:13'),
(2, 1, 1, '2026-01-19 11:21:14', '2026-01-24 11:21:14', NULL, 'Réparation climatisation', 'en_cours', 3745.20, NULL, 'Test', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(3, 1, 1, '2025-12-20 11:21:14', '2025-12-25 11:21:14', NULL, 'Changement courroie de distribution', 'en_cours', 3715.74, NULL, 'Test', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(4, 2, 2, '2025-12-18 11:21:14', '2025-12-23 11:21:14', NULL, 'Changement courroie de distribution', 'en_attente', 1402.62, NULL, 'Test', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(5, 2, 2, '2026-01-04 11:21:14', '2026-01-09 11:21:14', '2026-01-15 11:21:14', 'Changement batterie', 'livree', 2760.30, 4260.42, 'Test', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(6, 3, 3, '2026-02-15 11:21:14', '2026-02-20 11:21:14', '2026-02-16 11:21:14', 'Réparation électrique', 'termine', 1630.25, 729.17, 'Test', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(7, 4, 4, '2026-02-01 11:21:14', '2026-02-06 11:21:14', '2026-02-06 11:21:14', 'Remplacement des pneus', 'livree', 4639.71, 4152.92, 'Test', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(8, 5, 5, '2026-02-04 11:21:14', '2026-02-09 11:21:14', '2026-02-19 11:21:14', 'Remplacement amortisseurs', 'livree', 3163.39, 1761.16, 'Test', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(9, 6, 1, '2025-12-26 11:21:14', '2025-12-31 11:21:14', NULL, 'Réparation électrique', 'en_attente', 4464.58, NULL, 'Test', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(10, 6, 1, '2026-01-29 11:21:14', '2026-02-03 11:21:14', NULL, 'Réparation climatisation', 'en_attente', 667.57, NULL, 'Test', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(11, 7, 2, '2026-02-06 11:21:14', '2026-02-11 11:21:14', NULL, 'Diagnostic moteur', 'en_cours', 2254.76, NULL, 'Test', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(12, 7, 2, '2026-01-08 11:21:14', '2026-01-13 11:21:14', NULL, 'Réparation climatisation', 'en_cours', 1378.55, NULL, 'Test', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(13, 8, 3, '2026-01-14 11:21:14', '2026-01-19 11:21:14', '2026-01-16 11:21:14', 'Réparation climatisation', 'livree', 2809.29, 1870.83, 'Test', '2026-02-16 11:21:14', '2026-02-16 11:21:14'),
(14, 8, 3, '2025-12-31 11:21:14', '2026-01-05 11:21:14', '2026-01-09 11:21:14', 'Réparation climatisation', 'termine', 4807.28, 1003.47, 'Test', '2026-02-16 11:21:14', '2026-02-16 11:21:14');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7sSElUI3zoEatlgpWipiC99oSATaaBJiZHEfwvYK', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ2pWeERLQTZ2SjNnN3NoWm0zWnM5TEg2WlBCbFc4T1FvbndkZWdMNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1771244658),
('tML54DO5fjkFpa8p02xWnYZpl0PAwHdT4e4lxJSX', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid2hPeUFrQjhXbjQ2NjZmeTJMV3dBWlpUNzJXV3draGZuSml3Y1Q5VCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90ZWNobmljaWVuL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoyMDoidGVjaG5pY2llbi5kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo4O30=', 1771253843);

-- --------------------------------------------------------

--
-- Structure de la table `techniciens`
--

CREATE TABLE `techniciens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `utilisateur_id` bigint(20) UNSIGNED NOT NULL,
  `specialite` varchar(255) DEFAULT NULL,
  `taux_horaire` decimal(8,2) NOT NULL DEFAULT 0.00,
  `competences` text DEFAULT NULL,
  `statut` enum('disponible','occupe','conge') NOT NULL DEFAULT 'disponible',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `techniciens`
--

INSERT INTO `techniciens` (`id`, `utilisateur_id`, `specialite`, `taux_horaire`, `competences`, `statut`, `created_at`, `updated_at`) VALUES
(1, 7, 'Mécanique générale', 26.00, NULL, 'disponible', '2026-02-16 11:21:12', '2026-02-16 11:21:12'),
(2, 8, 'Électricité automobile', 23.00, NULL, 'disponible', '2026-02-16 11:21:12', '2026-02-16 11:21:12'),
(3, 9, 'Carrosserie et peinture', 15.00, NULL, 'disponible', '2026-02-16 11:21:13', '2026-02-16 11:21:13');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `type_utilisateur` enum('client','technicien','admin') NOT NULL DEFAULT 'client',
  `statut` enum('actif','inactif','suspendu') NOT NULL DEFAULT 'actif',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `telephone`, `password`, `type_utilisateur`, `statut`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'AKVA', 'admin@akva-auto.tg', '+228 90000000', '$2y$12$rMY9bH75z1VdDS4IIZRlyOM8se9SAyRGNfrETQPxec5dQTFh9eHbC', 'admin', 'actif', NULL, NULL, '2026-02-16 11:21:09', '2026-02-16 11:21:09'),
(2, 'Koffi', 'Jean', 'jean.koffi@email.tg', '+228 90123456', '$2y$12$CJjKHWRARzNeb8Yrvc9LvuI8jK/Zwt8hKo/WwTQdMYM05ugiVjEji', 'client', 'actif', NULL, NULL, '2026-02-16 11:21:10', '2026-02-16 11:21:10'),
(3, 'Mensah', 'Marie', 'marie.mensah@email.tg', '+228 90234567', '$2y$12$hJufnGwImTyfFVVweTAlZ.0.2zYrlpWkEfV967ORbUazyJpT/TEkC', 'client', 'actif', NULL, NULL, '2026-02-16 11:21:10', '2026-02-16 11:21:10'),
(4, 'Agbo', 'Pierre', 'pierre.agbo@email.tg', '+228 90345678', '$2y$12$shnDG3XYLm6HceEmHguSheJxwpQwmM7JV1JaIpu1Rs6H7VEPUj/He', 'client', 'actif', NULL, NULL, '2026-02-16 11:21:11', '2026-02-16 11:21:11'),
(5, 'Nossow', 'Yvette', 'yvette.nossow@email.tg', '+228 90456789', '$2y$12$jRwmYWoH1yAaGR7XlCjqKeHn8WdenPx8zMvx8KPwsms.BruASRUw2', 'client', 'actif', NULL, NULL, '2026-02-16 11:21:11', '2026-02-16 11:21:11'),
(6, 'Kodjo', 'André', 'andre.kodjo@email.tg', '+228 90567890', '$2y$12$ya8JgYBz2fjEv9WAAl/l.uewVDe8TWmpP8KXwurU57MeqlTTCHXCO', 'client', 'actif', NULL, NULL, '2026-02-16 11:21:11', '2026-02-16 11:21:11'),
(7, 'Mensah', 'Kofi', 'kofi.mensah@akva-auto.tg', '+228 90111111', '$2y$12$YZ1rIWCYdpGG3qUFCqVL.upKeGQVU0T9OM0YNyk05aQCMx5P.Gpeq', 'technicien', 'actif', NULL, NULL, '2026-02-16 11:21:12', '2026-02-16 11:21:12'),
(8, 'Edokpadzi', 'Gbedegbe', 'gbedegbe.edokpadzi@akva-auto.tg', '+228 90222222', '$2y$12$37Wjl6jQ/LIFdGTztiQpwenbkfS4Dx9uIQgtslpMHemGNYbLhwQyC', 'technicien', 'actif', NULL, NULL, '2026-02-16 11:21:12', '2026-02-16 11:21:12'),
(9, 'Agbégabé', 'Kossi', 'kossi.agbégabé@akva-auto.tg', '+228 90333333', '$2y$12$Vc2I6GxZjZUQrnO2waKGYO1FcLbl.EZaO/HKcUdE/ZPkuVXiXukZa', 'technicien', 'actif', NULL, NULL, '2026-02-16 11:21:13', '2026-02-16 11:21:13');

-- --------------------------------------------------------

--
-- Structure de la table `vehicules`
--

CREATE TABLE `vehicules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `marque` varchar(255) NOT NULL,
  `modele` varchar(255) NOT NULL,
  `plaque_immatriculation` varchar(255) NOT NULL,
  `couleur` varchar(255) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `kilometrage` int(11) NOT NULL DEFAULT 0,
  `type_carrosserie` varchar(255) DEFAULT NULL,
  `energie` enum('Essence','Diesel','Hybride','Électrique','Autre') NOT NULL DEFAULT 'Essence',
  `numero_chassis` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vehicules`
--

INSERT INTO `vehicules` (`id`, `client_id`, `marque`, `modele`, `plaque_immatriculation`, `couleur`, `annee`, `kilometrage`, `type_carrosserie`, `energie`, `numero_chassis`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Toyota', 'Corolla', 'TG-001-AA', 'Rouge', 2020, 126527, NULL, 'Essence', 'VIN-30BB97CA35', NULL, '2026-02-16 11:21:13', '2026-02-16 11:21:13'),
(2, 2, 'Honda', 'Civic', 'TG-002-AA', 'Blanc', 2021, 75249, NULL, 'Essence', 'VIN-30BB97E322', NULL, '2026-02-16 11:21:13', '2026-02-16 11:21:13'),
(3, 3, 'Peugeot', '308', 'TG-003-AA', 'Bleu', 2019, 65797, NULL, 'Diesel', 'VIN-30BB9825D4', NULL, '2026-02-16 11:21:13', '2026-02-16 11:21:13'),
(4, 4, 'Renault', 'Clio', 'TG-004-AA', 'Blanc', 2022, 117050, NULL, 'Essence', 'VIN-30BB983C73', NULL, '2026-02-16 11:21:13', '2026-02-16 11:21:13'),
(5, 5, 'Hyundai', 'i20', 'TG-005-AA', 'Argent', 2020, 16778, NULL, 'Essence', 'VIN-30BB9854C3', NULL, '2026-02-16 11:21:13', '2026-02-16 11:21:13'),
(6, 1, 'Mercedes', 'C-Class', 'TG-006-AA', 'Bleu', 2021, 49067, NULL, 'Diesel', 'VIN-30BB987E3E', NULL, '2026-02-16 11:21:13', '2026-02-16 11:21:13'),
(7, 2, 'BMW', '320i', 'TG-007-AA', 'Argent', 2020, 143616, NULL, 'Essence', 'VIN-30BB98900C', NULL, '2026-02-16 11:21:13', '2026-02-16 11:21:13'),
(8, 3, 'Toyota', 'Yaris', 'TG-008-AA', 'Gris', 2019, 42996, NULL, 'Essence', 'VIN-30BB9927DC', NULL, '2026-02-16 11:21:13', '2026-02-16 11:21:13');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis_clients`
--
ALTER TABLE `avis_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `avis_clients_client_id_foreign` (`client_id`),
  ADD KEY `avis_clients_reparation_id_foreign` (`reparation_id`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_numero_client_unique` (`numero_client`),
  ADD KEY `clients_utilisateur_id_foreign` (`utilisateur_id`);

--
-- Index pour la table `conseils`
--
ALTER TABLE `conseils`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `devis`
--
ALTER TABLE `devis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devis_reparation_id_foreign` (`reparation_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `interventions_technicien`
--
ALTER TABLE `interventions_technicien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interventions_technicien_reparation_id_foreign` (`reparation_id`),
  ADD KEY `interventions_technicien_technicien_id_foreign` (`technicien_id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages_contact`
--
ALTER TABLE `messages_contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_utilisateur_id_foreign` (`utilisateur_id`),
  ADD KEY `notifications_reparation_id_foreign` (`reparation_id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `recus`
--
ALTER TABLE `recus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `recus_numero_recu_unique` (`numero_recu`),
  ADD KEY `recus_reparation_id_foreign` (`reparation_id`);

--
-- Index pour la table `reparations`
--
ALTER TABLE `reparations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reparations_vehicule_id_foreign` (`vehicule_id`),
  ADD KEY `reparations_client_id_foreign` (`client_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `techniciens`
--
ALTER TABLE `techniciens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `techniciens_utilisateur_id_foreign` (`utilisateur_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `utilisateurs_email_unique` (`email`);

--
-- Index pour la table `vehicules`
--
ALTER TABLE `vehicules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicules_plaque_immatriculation_unique` (`plaque_immatriculation`),
  ADD KEY `vehicules_client_id_foreign` (`client_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis_clients`
--
ALTER TABLE `avis_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `conseils`
--
ALTER TABLE `conseils`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `devis`
--
ALTER TABLE `devis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `interventions_technicien`
--
ALTER TABLE `interventions_technicien`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages_contact`
--
ALTER TABLE `messages_contact`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `recus`
--
ALTER TABLE `recus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reparations`
--
ALTER TABLE `reparations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `techniciens`
--
ALTER TABLE `techniciens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `vehicules`
--
ALTER TABLE `vehicules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis_clients`
--
ALTER TABLE `avis_clients`
  ADD CONSTRAINT `avis_clients_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `avis_clients_reparation_id_foreign` FOREIGN KEY (`reparation_id`) REFERENCES `reparations` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_utilisateur_id_foreign` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `devis`
--
ALTER TABLE `devis`
  ADD CONSTRAINT `devis_reparation_id_foreign` FOREIGN KEY (`reparation_id`) REFERENCES `reparations` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `interventions_technicien`
--
ALTER TABLE `interventions_technicien`
  ADD CONSTRAINT `interventions_technicien_reparation_id_foreign` FOREIGN KEY (`reparation_id`) REFERENCES `reparations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interventions_technicien_technicien_id_foreign` FOREIGN KEY (`technicien_id`) REFERENCES `techniciens` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_reparation_id_foreign` FOREIGN KEY (`reparation_id`) REFERENCES `reparations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `notifications_utilisateur_id_foreign` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `recus`
--
ALTER TABLE `recus`
  ADD CONSTRAINT `recus_reparation_id_foreign` FOREIGN KEY (`reparation_id`) REFERENCES `reparations` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reparations`
--
ALTER TABLE `reparations`
  ADD CONSTRAINT `reparations_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reparations_vehicule_id_foreign` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicules` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `techniciens`
--
ALTER TABLE `techniciens`
  ADD CONSTRAINT `techniciens_utilisateur_id_foreign` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `vehicules`
--
ALTER TABLE `vehicules`
  ADD CONSTRAINT `vehicules_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
