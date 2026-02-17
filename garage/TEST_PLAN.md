# Plan de Test - AKVA-Auto

## Tests à Effectuer

### 1. Authentification

- [ ] Inscription d'un nouveau client
    - Vérifier que le champ `password_confirmation` fonctionne
    - Vérifier que le client est créé dans `utilisateurs` et `clients`
    - Vérifier que le hash de mot de passe est correct
- [ ] Connexion Admin
    - Email: `admin@akva-auto.tg`
    - Mot de passe: `admin123`
    - Vérifier la redirection vers `/admin/dashboard`
- [ ] Connexion Client
    - Utiliser un client du seeder ou nouvellement créé
    - Vérifier la redirection vers `/client/dashboard`
- [ ] Connexion Technicien
    - Email: `kofi.mensah@akva-auto.tg`
    - Mot de passe: `technicien123`
    - Vérifier la redirection vers `/technicien/dashboard`

### 2. Dashboard Administrateur

- [ ] Vérifier les statistiques
    - Nombre total de clients
    - Nombre total de techniciens
    - Nombre total de réparations
    - Nombre de réparations en cours
- [ ] Vérifier les listes paginées
    - Clients
    - Techniciens
    - Réparations récentes

### 3. CRUD Réparations

- [ ] Créer une réparation
    - Sélectionner un véhicule existant
    - Sélectionner un technicien
    - Vérifier que le client est automatiquement rempli
- [ ] Afficher une réparation
    - Voir les détails complets
    - Voir les interventions du technicien
- [ ] Éditer une réparation
    - Changer le statut
    - Ajouter un coût final
    - Changer la date fin réelle
- [ ] Supprimer une réparation
    - Vérifier que les interventions associées sont supprimées

### 4. CRUD Clients

- [ ] Créer un client
    - Avec ou sans véhicule
    - Vérifier la création du profil `Client`
    - Vérifier la création de l'utilisateur
- [ ] Afficher un client
    - Voir ses véhicules
    - Voir ses réparations
- [ ] Éditer un client
    - Modifier adresse, ville, code postal
- [ ] Supprimer un client
    - Vérifier que l'utilisateur est aussi supprimé

### 5. CRUD Techniciens

- [ ] Créer un technicien
    - Avec spécialité et taux horaire
    - Vérifier la création du profil `Technicien`
- [ ] Afficher un technicien
    - Voir ses interventions
- [ ] Éditer un technicien
    - Modifier spécialité et taux horaire
- [ ] Supprimer un technicien
    - Vérifier que l'utilisateur est aussi supprimé

### 6. CRUD Véhicules

- [ ] Créer un véhicule
    - Vérifier que la plaque d'immatriculation est unique
    - Vérifier que l'énergie correspond à une valeur valide
- [ ] Afficher un véhicule
    - Voir les réparations associées
- [ ] Éditer un véhicule
    - Modifier kilométrage et couleur
- [ ] Supprimer un véhicule
    - Vérifier que les réparations restent (cascade)

### 7. Affectation de Techniciens

- [ ] Affecter un technicien à une réparation
    - Via la vue `admin/reparations/assign`
    - Vérifier la création de l'intervention
- [ ] Retirer un technicien
    - Via le bouton de suppression
    - Vérifier la suppression de l'intervention

### 8. Services d'Export

- [ ] Exporter les réparations en CSV
    - Vérifier que les noms de colonnes sont corrects
    - Vérifier que les données sont complètes
- [ ] Exporter les véhicules en CSV
    - Vérifier que `plaque_immatriculation` est affichée
    - Vérifier que le client est affiché
- [ ] Exporter les techniciens en CSV
    - Vérifier que les noms proviennent de `utilisateur`

### 9. Formulaire de Contact

- [ ] Soumettre un message de contact
    - Vérifier que le message est sauvegardé en base
    - Vérifier que l'email est requis
    - Vérifier que le message a au moins 10 caractères

### 10. Permissions par Rôle

- [ ] Admin peut accéder à `/admin/dashboard` ✅
- [ ] Admin ne peut pas accéder à `/client/dashboard` (redirect) ✅
- [ ] Client ne peut pas accéder à `/admin/dashboard` (redirect) ✅
- [ ] Technicien ne peut pas accéder à `/admin/dashboard` (redirect) ✅

---

## Instructions de Test

### 1. Préparer la base de données

```bash
php artisan migrate:fresh --seed
```

### 2. Démarrer le serveur

```bash
php artisan serve
```

### 3. Accéder à l'application

```
http://localhost:8000
```

### 4. Tester chaque scénario ci-dessus

---

## Utilisation des Comptes de Test

| Rôle         | Email                           | Mot de passe  |
| ------------ | ------------------------------- | ------------- |
| Admin        | admin@akva-auto.tg              | admin123      |
| Client 1     | jean.koffi@email.tg             | client123     |
| Client 2     | marie.mensah@email.tg           | client123     |
| Technicien 1 | kofi.mensah@akva-auto.tg        | technicien123 |
| Technicien 2 | gbedegbe.edokpadzi@akva-auto.tg | technicien123 |
| Technicien 3 | kossi.agbégabé@akva-auto.tg     | technicien123 |

---

## Problèmes Connus à Vérifier

Aucun problème connu. Tous les problèmes identifiés lors de la révision ont été corrigés.

---

**Status:** Prêt pour les tests
**Date:** 1 février 2026
