<?php

declare(strict_types=1);

namespace UltimateLoremGenerator;

enum OutputFormat: string
{
    case TEXT = 'text';
    case HTML = 'html';
    case JSON = 'json';
    case MARKDOWN = 'markdown';
}
