<?php

namespace Test\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\ValiderCommandeUseCase;
use App\Application\Agriculteur\DTO\ValiderCommandeDto;
use App\Domain\Repository\CommandeRepositoryInterface;
use App\Domain\Repository\TransporteurRepositoryInterface;
use App\Domain\Repository\LivraisonRepositoryInterface;
use App\Domain\Service\ServiceLivraison;

it('execute sans lever d exception', function () {

    $commandeRepository = Mockery::mock(CommandeRepositoryInterface::class);
    $transporteurRepository = Mockery::mock(TransporteurRepositoryInterface::class);
    $livraisonRepository = Mockery::mock(LivraisonRepositoryInterface::class);
    $serviceLivraison = Mockery::mock(ServiceLivraison::class);

    $useCase = new ValiderCommandeUseCase(
        $commandeRepository,
        $transporteurRepository,
        $livraisonRepository,
        $serviceLivraison
    );

    $dto = Mockery::mock(ValiderCommandeDto::class);

    expect(fn () => $useCase->execute($dto))
        ->not->toThrow(Exception::class);
});

afterEach(function () {
    Mockery::close();
});
