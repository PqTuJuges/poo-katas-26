<?php

declare(strict_types=1);

// Tous les fichiers *Test.php de tests/ sont des tests PHPUnit classiques.
pest()->extend(PHPUnit\Framework\TestCase::class)->in(__DIR__);
