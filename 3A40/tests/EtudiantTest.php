<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Etudiant;

class EtudiantTest extends TestCase
{
    public function testIsTrue(): void
    {
        $etudant = new etudiant();
        $etudant->setUserName("Foulen");
        $this->assertTrue($etudant->getuSER);
    }
}
