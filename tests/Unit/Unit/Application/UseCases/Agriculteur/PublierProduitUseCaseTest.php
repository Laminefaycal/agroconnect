<?php

namespace Tests\Unit\Unit\Application\UseCases\Agriculteur;

use App\Application\Agriculteur\DTO\PublierProduitDto;
use PHPUnit\Framework\TestCase;

class PublierProduitUseCaseTest extends TestCase
{
    /**
     * Teste que le DTO s'initialise correctement avec les bonnes valeurs.
     */
    public function test_le_dto_s_initialise_correctement(): void
    {
        // GIVEN (Données de test)
        $agriculteurId = 42;
        $nom = 'Pommes de terre';
        $description = 'Belles pommes de terre bio du jardin';
        $prix = 2.50;
        $stock = 150;
        $unite = 'kg';

        // WHEN (Instanciation du DTO)
        $dto = new PublierProduitDto(
            $agriculteurId,
            $nom,
            $description,
            $prix,
            $stock,
            $unite
        );

        // THEN (Vérification des propriétés)
        $this->assertSame($agriculteurId, $dto->agriculteurId);
        $this->assertSame($nom, $dto->nom);
        $this->assertSame($description, $dto->description);
        $this->assertSame($prix, $dto->prix);
        $this->assertSame($stock, $dto->stock);
        $this->assertSame($unite, $dto->unite);
    }
}