<?php

declare(strict_types=1);

namespace UltimateLoremGenerator;

use InvalidArgumentException;

final class Generator
{
    /**
     * @return string|list<string>
     */
    public function generate(
        int $words,
        int $paragraphs,
        Theme|string $theme = Theme::BOTANIQUE,
        bool $punctuation = false,
        OutputFormat|string $format = OutputFormat::TEXT,
    ): string|array {
        $theme = $this->resolveTheme($theme);
        $format = $this->resolveFormat($format);
        $this->validate($words, $paragraphs);

        $lexicon = Lexicons::all()[$theme->value];
        $result = [];
        $previousWord = null;

        foreach ($this->distribute($words, $paragraphs) as $size) {
            [$paragraph, $previousWord] = $this->paragraph($size, $lexicon, $punctuation, $previousWord);
            $result[] = $paragraph;
        }

        return $this->format($result, $format);
    }

    public function generateHtml(
        int $words,
        int $paragraphs,
        Theme|string $theme = Theme::BOTANIQUE,
        bool $punctuation = false,
    ): string {
        $paragraphs = $this->generate($words, $paragraphs, $theme, $punctuation, OutputFormat::ARRAY);

        return implode("\n", array_map(
            static fn (string $paragraph): string => '<p>'
                . htmlspecialchars($paragraph, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8')
                . '</p>',
            $paragraphs,
        ));
    }

    /** @return list<string> */
    public static function themes(): array
    {
        return array_column(Theme::cases(), 'value');
    }

    /** @return list<string> */
    public static function formats(): array
    {
        return array_column(OutputFormat::cases(), 'value');
    }

    private function validate(int $words, int $paragraphs): void
    {
        if ($words < 1) {
            throw new InvalidArgumentException('Le nombre de mots doit être supérieur à zéro.');
        }
        if ($paragraphs < 1) {
            throw new InvalidArgumentException('Le nombre de paragraphes doit être supérieur à zéro.');
        }
        if ($paragraphs > $words) {
            throw new InvalidArgumentException('Le nombre de paragraphes ne peut pas dépasser le nombre de mots.');
        }
    }

    /** @return list<int> */
    private function distribute(int $words, int $paragraphs): array
    {
        $base = intdiv($words, $paragraphs);
        $remainder = $words % $paragraphs;
        $sizes = array_fill(0, $paragraphs, $base);

        for ($i = 0; $i < $remainder; $i++) {
            $sizes[$i]++;
        }

        return $sizes;
    }

    /**
     * @param list<string> $lexicon
     * @return array{string, string}
     */
    private function paragraph(int $size, array $lexicon, bool $punctuation, ?string $previous): array
    {
        $words = [];
        for ($i = 0; $i < $size; $i++) {
            do {
                $word = $lexicon[array_rand($lexicon)];
            } while ($word === ($words[$i - 1] ?? $previous));
            $words[] = $word;
        }

        if (!$punctuation) {
            return [implode(' ', $words), $words[array_key_last($words)]];
        }

        return [$this->punctuate($words), $words[array_key_last($words)]];
    }

    /** @param list<string> $words */
    private function punctuate(array $words): string
    {
        $result = '';
        $sentenceLength = random_int(7, 13);
        $sentencePosition = 0;

        foreach ($words as $index => $word) {
            if ($sentencePosition === 0) {
                $word = ucfirst($word);
            }

            $sentencePosition++;
            $isLast = $index === array_key_last($words);
            $isSentenceEnd = $sentencePosition >= $sentenceLength || $isLast;

            if ($isSentenceEnd) {
                $word .= $isLast ? '.' : ['.', '!', '?'][array_rand(['.', '!', '?'])];
                $sentencePosition = 0;
                $sentenceLength = random_int(7, 13);
            } elseif ($sentencePosition >= 3 && random_int(1, 6) === 1) {
                $word .= ',';
            }

            $result .= ($result === '' ? '' : ' ') . $word;
        }

        return $result;
    }

    /**
     * @param list<string> $paragraphs
     * @return string|list<string>
     */
    private function format(array $paragraphs, OutputFormat $format): string|array
    {
        return match ($format) {
            OutputFormat::TEXT, OutputFormat::MARKDOWN => implode("\n\n", $paragraphs),
            OutputFormat::ARRAY => $paragraphs,
            OutputFormat::HTML => implode("\n", array_map(
                static fn (string $paragraph): string => '<p>'
                    . htmlspecialchars($paragraph, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8')
                    . '</p>',
                $paragraphs,
            )),
        };
    }

    private function resolveTheme(Theme|string $theme): Theme
    {
        if ($theme instanceof Theme) {
            return $theme;
        }

        return Theme::tryFrom($theme)
            ?? throw new InvalidArgumentException('Thème inconnu : ' . $theme . '.');
    }

    private function resolveFormat(OutputFormat|string $format): OutputFormat
    {
        if ($format instanceof OutputFormat) {
            return $format;
        }

        return OutputFormat::tryFrom($format)
            ?? throw new InvalidArgumentException('Format inconnu : ' . $format . '.');
    }
}
