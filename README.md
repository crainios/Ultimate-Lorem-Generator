# Ultimate Lorem Generator

Générateur de faux texte PHP, sans dépendance, proposant six univers lexicaux originaux et plusieurs formats de sortie.

**Démo en ligne :** [Tester Ultimate Lorem Generator](https://anshare.net/crainios/Ultimate-Lorem-Generator/)

## Prérequis

- PHP 8.1 ou supérieur
- Composer, uniquement pour l'installation et l'autoloading

## Installation

```bash
composer require crainios/ultimate-lorem-generator
```

## Utilisation PHP

```php
use UltimateLoremGenerator\Generator;

$generator = new Generator();

// 120 mots, 4 paragraphes, thème botanique, sans ponctuation, texte brut.
echo $generator->generate(120, 4);

// Les cinq paramètres.
echo $generator->generate(120, 4, 'science-fiction', 'french', 'markdown');
```

La signature principale est :

```php
generate(
    int $words,
    int $paragraphs,
    Theme|string $theme = Theme::BOTANIQUE,
    PunctuationStyle|string|bool $punctuation = false,
    OutputFormat|string $format = OutputFormat::TEXT,
): string
```

Le nombre de mots demandé est exact et réparti aussi équitablement que possible entre les paragraphes.

### Ponctuation

- `standard` : aucune espace avant `!` et `?`
- `french` : espace insécable avant `!` et `?`
- `spanish` : signes ouvrants `¡` et `¿`, signes fermants sans espace
- `false` : aucune ponctuation (valeur par défaut)

Pour préserver la compatibilité, `true` équivaut au style `french`. La première lettre
de chaque phrase est mise en majuscule, y compris si elle est accentuée.

Les styles disponibles peuvent servir à construire une liste de choix :

```php
$styles = Generator::punctuationStyles();
// ['standard', 'french', 'spanish']
```

### Thèmes

- `botanique` (défaut)
- `science-fiction`
- `cuisine`
- `fantasy`
- `ocean`
- `retrofuturisme`

### Formats

- `text` (défaut) : paragraphes séparés par une ligne vide
- `html` : éléments `<p>` dont le contenu est échappé
- `json` : chaîne JSON contenant un tableau de paragraphes
- `markdown` : paragraphes séparés par une ligne vide

Le format JSON peut être affiché ou transmis directement, sans provoquer d’erreur de
conversion de tableau en chaîne :

```php
echo $generator->generate(40, 1, 'botanique', 'french', 'json');
```

### HTML sécurisé

```php
echo $generator->generateHtml(80, 3, 'ocean', 'spanish');
```

`generateHtml()` échappe chaque paragraphe avec `htmlspecialchars()` avant de l'insérer dans un élément `<p>`.

## Ligne de commande

Le script fonctionne avec ou sans installation préalable de Composer :

```bash
php bin/ultimate-lorem --words=120 --paragraphs=4
php bin/ultimate-lorem --words=80 --paragraphs=3 --theme=fantasy --punctuation
php bin/ultimate-lorem --words=80 --paragraphs=3 --theme=fantasy --punctuation=spanish
php bin/ultimate-lorem --words=40 --paragraphs=2 --theme=ocean --format=html
```

Après une installation globale avec Composer, la commande `ultimate-lorem` est également disponible.

## Tests

```bash
composer test
# ou
php tests/run.php
```

## Transparence sur le développement

Le projet est initié, dirigé et validé par François Milhiet. Sa conception
et son développement sont réalisés en collaboration avec ChatGPT
d’OpenAI, au fil d’une longue série de prompts, d’analyses, d’itérations
et de validations.

Les orientations fonctionnelles, les choix d’architecture, les arbitrages,
les essais sur serveur et la validation finale restent conduits par
l’initiateur du projet. ChatGPT intervient comme assistant de conception,
de programmation, de documentation et de contrôle. Cette méthode de
développement assisté par intelligence artificielle est présentée
explicitement dans un souci de transparence.

## Licence

Ultimate Lorem Generator est distribué sous licence GNU Affero General Public License v3.0 (AGPL-3.0). Consultez [LICENSE](LICENSE).
