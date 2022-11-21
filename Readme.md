# Bienvenu sur le projet PHP de Samuel Guillemet

## Entités :

Vous trouverez un détail des entités sur l'issue suivante : https://github.com/SamuelGuillemet/bookShelf/issues/2

Si vous n'avez pas la force de cliquer sur le lien on a :

- Livre - `objet`
- Bibliothèque - `inventaire`
- Vitrine - `gallery`
- membre - `membre`
- auteur - `categorie`
  > theme
- type - `categorie`
  > public_cible

---

# Charger les datafixtures :

Le script `LoadData.sh` permet de créer la base de donnée et de la peupler avec les données.

Le projet étant hébergé sur GitHub, la DB n'est pas sauvegradée pour des raisons de taille de stockage !

# Utilisateurs :

| mail            | password | role       |
| --------------- | -------- | ---------- |
| sam@localhost   | sam      | ROLE_USER  |
| admin@localhost | admin    | ROLE_ADMIN |
