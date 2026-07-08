<?php

declare(strict_types=1);

namespace App\Composer;

use Composer\Script\Event;
use Symfony\Component\Process\ExecutableFinder;

class BinaryChecker
{
    public static function check(Event $event): void
    {
        $extra = $event->getComposer()->getPackage()->getExtra();
        $requiredBinaries = $extra['required-binaries'] ?? [];

        if (empty($requiredBinaries)) {
            return;
        }

        $finder = new ExecutableFinder();
        $missingBinaries = [];

        foreach ($requiredBinaries as $binary) {
            if ($finder->find($binary) === null) {
                $missingBinaries[] = $binary;
            }
        }

        if (empty($missingBinaries)) {
            return;
        }

        $message = sprintf(
            "The following system binaries are required but were not found in your PATH: %s.\n"
            . "These are external system dependencies and must be installed manually "
            . "(they are not managed by Composer).",
            implode(', ', $missingBinaries)
        );

        fwrite(STDERR, "\033[31m" . $message . "\033[0m\n");

        exit(1);
    }
}
