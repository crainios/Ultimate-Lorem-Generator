<?php

declare(strict_types=1);

namespace UltimateLoremGenerator;

final class Lexicons
{
    /** @return array<string, list<string>> */
    public static function all(): array
    {
        return [
            Theme::BOTANIQUE->value => [
                'ambracine', 'arborêve', 'brumélia', 'calyflore', 'chlorélune', 'dendrisse',
                'écorêve', 'floréon', 'frondélia', 'glycéliane', 'herbeline', 'irisphère',
                'lianombre', 'mousselune', 'nectarive', 'opalfeuille', 'pollenuit', 'racinaire',
                'sèvebrume', 'silvélia', 'sporéole', 'tigréane', 'verdélis', 'xylophore', 'zéphyrine',
            ],
            Theme::SCIENCE_FICTION->value => [
                'astromatrice', 'bioquanta', 'chronopulse', 'cybernacre', 'exolune', 'fluxion',
                'galaxium', 'héliocode', 'hypernova', 'ionosphère', 'lumicœur', 'métanéon',
                'nanorêve', 'nébularis', 'orbitron', 'photomnésie', 'plasmécho', 'quantara',
                'sidéroïde', 'singularium', 'stellacode', 'tachybrume', 'téléphase', 'xénolithe', 'zéroflux',
            ],
            Theme::CUISINE->value => [
                'amandine', 'basilune', 'beurrélis', 'caramiel', 'citronnelle', 'croustille',
                'épicerêve', 'farinelle', 'flambéole', 'framboisine', 'gingembrume', 'mijotine',
                'muscadine', 'noisettine', 'paprikâme', 'pistachère', 'poivrélia', 'pralinuit',
                'safranor', 'salicorne', 'sorbeline', 'sucrélune', 'vanilline', 'veloutance', 'zestélis',
            ],
            Theme::FANTASY->value => [
                'aetheris', 'arcanombre', 'brumegarde', 'cristalune', 'drakélys', 'elféride',
                'enchantrelle', 'faërune', 'glyphéon', 'grimoire', 'légendaris', 'luminécrom',
                'manaflore', 'mithralis', 'ombresort', 'oréclat', 'runiance', 'sylphéide',
                'talisombre', 'valdragon', 'wyrmelia', 'xanthar', 'ysalune', 'zéphyrim', 'étoilâme',
            ],
            Theme::OCEAN->value => [
                'abysselle', 'algécume', 'azurmarée', 'baleinance', 'coralline', 'courantine',
                'écumélis', 'embrunelle', 'fjordélia', 'houlebrume', 'lagunéon', 'marélys',
                'médusine', 'nacréole', 'nautilune', 'océambre', 'ondaline', 'perlisandre',
                'récifère', 'sirénade', 'thalassine', 'vaguelune', 'ventsalin', 'xiphocéan', 'zéphyrécume',
            ],
            Theme::RETROFUTURISME->value => [
                'aérochrome', 'automéca', 'bakélite', 'carborama', 'chrométher', 'cuivronique',
                'électroplume', 'futurama', 'galvanor', 'héliomètre', 'mécanimbus', 'néonographe',
                'pistonnelle', 'radiorêve', 'rétrocosme', 'robotine', 'spatiophone', 'spiralium',
                'télévox', 'thermoclock', 'turbovapeur', 'vintagium', 'voltophone', 'xénochrome', 'zénithron',
            ],
        ];
    }

    private function __construct()
    {
    }
}
