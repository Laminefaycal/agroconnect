<?php

namespace Test\Application\Consommateur\UseCase;

namespace Test\Application\Consommateur\UseCase;

use App\Application\Consommateur\UseCase\PasserCommandeUseCase;
use App\Application\Consommateur\Dto\PasserCommandeDto;
use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Consommateur\Repository\ConsommateurRepositoryInterface;
use App\Domain\Produit\Repository\ProduitRepositoryInterface;
use App\Domain\Services\ServiceDisponibilite;

test('il doit lever une exception tant que la logique interne n\'est pas codée', function () {
    // 1. Arrange
    $useCase = new PasserCommandeUseCase(
        mock(CommandeRepositoryInterface::class),
        mock(ConsommateurRepositoryInterface::class),
        mock(ProduitRepositoryInterface::class),
        mock(ServiceDisponibilite::class)
    );

    // 2. Création du DTO avec les 3 arguments attendus par son constructeur
    // Remplacez ces valeurs par les types attendus (ex: string, array, string)
    $fauxIdConsommateur = 'consommateur-123';
    $faussesLignesCommande = [];
    $fausseAdresse = '123 Rue de la Ferme';

    $dto = new PasserCommandeDto($fauxIdConsommateur, $faussesLignesCommande, $fausseAdresse);

    // 3. Act & Assert
    expect(fn() => $useCase->execute($dto))
        ->toThrow(\Exception::class, "Logique interne à implémenter selon vos règles métier.");
});
