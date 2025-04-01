<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Table
{
    #[ORM\Column(type: 'string')]
    private ?string $nom = null;

    #[ORM\Column(type: 'integer')]
    private ?integer $age = null;

}
