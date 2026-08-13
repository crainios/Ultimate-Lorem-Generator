<?php

declare(strict_types=1);

require __DIR__ . '/../src/Theme.php';
require __DIR__ . '/../src/OutputFormat.php';
require __DIR__ . '/../src/Lexicons.php';
require __DIR__ . '/../src/Generator.php';

use UltimateLoremGenerator\Generator;

function check(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

function countWords(string $text): int
{
    preg_match_all("/[\\p{L}]+(?:[-'][\\p{L}]+)*/u", $text, $matches);
    return count($matches[0]);
}

$generator = new Generator();

foreach (Generator::themes() as $theme) {
    $text = $generator->generate(101, 4, $theme);
    check(is_string($text), "$theme doit produire une chaîne.");
    check(countWords($text) === 101, "$theme doit produire exactement 101 mots.");
    check(count(explode("\n\n", $text)) === 4, "$theme doit produire 4 paragraphes.");
}

$plain = $generator->generate(30, 2);
check(!preg_match('/[,.!?]/', $plain), 'La ponctuation doit être désactivée par défaut.');

$punctuated = $generator->generate(30, 2, 'fantasy', true);
check(countWords($punctuated) === 30, 'La ponctuation ne doit pas modifier le nombre de mots.');
check(str_contains($punctuated, '.'), 'La sortie ponctuée doit contenir des fins de phrases.');

$reflection = new ReflectionClass($generator);
$uppercaseFirst = $reflection->getMethod('uppercaseFirst');
check($uppercaseFirst->invoke($generator, 'écorêve') === 'Écorêve', 'Une initiale accentuée doit être mise en majuscule.');
check($uppercaseFirst->invoke($generator, 'azur') === 'Azur', 'Une initiale ASCII doit être mise en majuscule.');

$hasFrenchMark = false;
for ($attempt = 0; $attempt < 20; $attempt++) {
    $sample = $generator->generate(200, 1, 'botanique', true);
    check(!preg_match('/(?<!\x{00A0})[!?]/u', $sample), 'Les points ! et ? doivent être précédés d’une espace insécable.');
    $hasFrenchMark = $hasFrenchMark || (bool) preg_match('/\x{00A0}[!?]/u', $sample);
}
check($hasFrenchMark, 'Le test doit rencontrer au moins un point ! ou ? français.');

$array = $generator->generate(12, 3, format: 'array');
check(is_array($array) && count($array) === 3, 'Le format array doit retourner trois éléments.');

$html = $generator->generateHtml(12, 3);
check(substr_count($html, '<p>') === 3, 'generateHtml doit produire trois éléments p.');
check(countWords(strip_tags($html)) === 12, 'generateHtml doit conserver le nombre de mots.');

foreach ([[-1, 1], [10, 0], [2, 3]] as [$words, $paragraphs]) {
    try {
        $generator->generate($words, $paragraphs);
        throw new RuntimeException('Une entrée invalide aurait dû être rejetée.');
    } catch (InvalidArgumentException) {
    }
}

echo "Tous les tests sont passés.\n";
