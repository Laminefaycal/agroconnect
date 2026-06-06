# Conception du projet AgroConnect

Ce dossier contient l’ensemble des artefacts de conception du projet **AgroConnect**.  
La modélisation suit une architecture en couches (domaine, application, infrastructure) et trois niveaux de vues : conceptuelle, spécification et implémentation.


## Cas d’usage (`cas-usage`)

Ces diagrammes décrivent les interactions entre les acteurs (consommateur, agriculteur, transporteur) et le système.

| Fichier | Description |
|---------|-------------|
| `1 - scenario-du-consommateur.puml` | Parcours d’un consommateur : recherche de produits, commande, suivi de livraison. |
| `2 - scenario-de-agriculteur.puml` | Actions de l’agriculteur : mise en vente, gestion des stocks, réception des commandes. |
| `3 - scenario-du-transporteur.puml` | Rôle du transporteur : prise en charge des livraisons, mise à jour du statut. |

---

## Diagrammes de classes (`digramme-classes`)

Trois vues progressives (du conceptuel au code) et, pour chacune, une découpe par couches hexagonales/DDD.

### 1 – Vue conceptuelle

Modélisation métier de haut niveau, indépendante de toute technologie.

| Fichier | Contenu |
|---------|---------|
| `1 - structure.puml` | Entités principales et leurs relations (agrégats, value objects). |
| `info.txt` | Notes et explications complémentaires sur la vue conceptuelle. |

### 2 – Vue spécification

Détail des interfaces, contrats et dépendances entre les couches.

| Fichier | Rôle |
|---------|------|
| `1 - domaine.puml` | Spécification du cœur métier (entités, événements, règles). |
| `2 - application.puml` | Services applicatifs, use cases, ports entrants. |
| `3 - infrastructure.puml` | Ports sortants (repositories, services externes). |
| `info.txt` | Précisions sur les choix d’architecture. |

### 3 – Vue implémentation

Modèle proche du code réel (classes avec attributs, méthodes, types concrets).

| Fichier | Description |
|---------|-------------|
| `1 - domaine.puml` | Implémentation des entités et value objects. |
| `2 - application.puml` | Implémentation des services applicatifs. |
| `3 - infrastructure.puml` | Détails techniques (ORM, API clients, etc.). |
| `info.txt` | Indications sur les frameworks / bibliothèques utilisés. |

---

## Visualisation des diagrammes

Les fichiers `.puml` sont au format **PlantUML**. Pour les visualiser :

- **En local** : installez PlantUML (ou l’extension VS Code) et générez les images.
- **En ligne** : copiez le contenu sur [PlantUML Web Server](http://www.plantuml.com/plantuml/uml/).
- **Sur GitHub** : utilisez un rendu avec `![](http://www.plantuml.com/plantuml/png/...` ou l’intégration via ````puml` (selon les extensions du dépôt).

> 💡 *Conseil* : pour faciliter la lecture, vous pouvez générer une version PDF ou image de chaque diagramme et les stocker dans un sous-dossier `images/`.

---

## Évolution de la documentation

Ce dossier de conception doit rester synchronisé avec le code.  
À chaque modification architecturale majeure, mettez à jour les fichiers `.puml` correspondants et le fichier `info.txt` associé.
