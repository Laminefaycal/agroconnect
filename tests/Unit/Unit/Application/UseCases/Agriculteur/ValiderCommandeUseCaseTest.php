<?php

namespace Tests\Unit\Unit\Application\UseCases\Agriculteur;

use App\Application\Agriculteur\DTO\ValiderCommandeDto;
use PHPUnit\Framework\TestCase;

class ValiderCommandeUseCaseTest extends TestCase
{
    /**
     * Cas 1 : Initialisation complète avec toutes les données (y compris le transporteur)
     */
    public function test_le_dto_s_initialise_correctement_avec_un_transporteur(): void
    {
        // GIVEN
        $commandeId = 101;
        $estDisponible = true;
        $modeLivraison = 'A domicile';
        $transporteurId = 7;

        // WHEN
        $dto = new ValiderCommandeDto(
            $commandeId,
            $estDisponible,
            $modeLivraison,
            $transporteurId
        );

        // THEN
        $this->assertSame($commandeId, $dto->commandeId);
        $this->assertSame($estDisponible, $dto->estDisponible);
        $this->assertSame($modeLivraison, $dto->modeLivraison);
        $this->assertSame($transporteurId, $dto->transporteurId);
    }

    /**
     * Cas 2 : Initialisation sans spécifier le transporteur (valeur par défaut)
     */
    public function test_le_dto_s_initialise_correctement_sans_transporteur(): void
    {
        // GIVEN
        $commandeId = 102;
        $estDisponible = false;
        $modeLivraison = 'Point retrait';

        // WHEN (On ne passe pas le 4ème argument)
        $dto = new ValiderCommandeDto(
            $commandeId,
            $estDisponible,
            $modeLivraison
        );

        // THEN (On vérifie que transporteurId est bien resté à null)
        $this->assertSame($commandeId, $dto->commandeId);
        $this->assertSame($estDisponible, $dto->estDisponible);
        $this->assertSame($modeLivraison, $dto->modeLivraison);
        $this->assertNull($dto->transporteurId); // Utilisation de assertNull pour plus de clarté
    }
}