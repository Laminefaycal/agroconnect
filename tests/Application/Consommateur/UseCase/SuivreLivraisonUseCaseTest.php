<?php

namespace Tests\Application\Consommateur\UseCase;

use App\Application\Consommateur\UseCase\SuivreLivraisonUseCase;
use App\Domain\Commande\Commande;
use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\Repository\LivraisonRepositoryInterface;
use InvalidArgumentException;
use Mockery;
use PHPUnit\Framework\TestCase;

uses(TestCase::class);

describe('SuivreLivraisonUseCase', function () {

    it('retourne la livraison associée à la commande si elle existe', function () {
        // Préparer les mocks
        $commandeId = 'cmd-123';
        $livraison = Mockery::mock(Livraison::class);

        $commande = Mockery::mock(Commande::class);
        $commande->shouldReceive('getLivraison')->once()->andReturn($livraison);

        $commandeRepo = Mockery::mock(CommandeRepositoryInterface::class);
        $commandeRepo->shouldReceive('findById')->with($commandeId)->once()->andReturn($commande);

        $livraisonRepo = Mockery::mock(LivraisonRepositoryInterface::class);

        $useCase = new SuivreLivraisonUseCase($commandeRepo, $livraisonRepo);

        // Exécution
        $result = $useCase->execute($commandeId);

        // Vérification
        expect($result)->toBe($livraison);
    });

    it('lève une exception si la commande est introuvable', function () {
        $commandeId = 'cmd-123';

        $commandeRepo = Mockery::mock(CommandeRepositoryInterface::class);
        $commandeRepo->shouldReceive('findById')->with($commandeId)->once()->andReturn(null);

        $livraisonRepo = Mockery::mock(LivraisonRepositoryInterface::class);

        $useCase = new SuivreLivraisonUseCase($commandeRepo, $livraisonRepo);

        expect(fn () => $useCase->execute($commandeId))
            ->toThrow(InvalidArgumentException::class, "Commande introuvable avec l'ID : cmd-123");
    });

    it('lève une exception si la commande n\'a pas de livraison associée', function () {
        $commandeId = 'cmd-123';

        $commande = Mockery::mock(Commande::class);
        $commande->shouldReceive('getLivraison')->once()->andReturn(null);

        $commandeRepo = Mockery::mock(CommandeRepositoryInterface::class);
        $commandeRepo->shouldReceive('findById')->with($commandeId)->once()->andReturn($commande);

        $livraisonRepo = Mockery::mock(LivraisonRepositoryInterface::class);

        $useCase = new SuivreLivraisonUseCase($commandeRepo, $livraisonRepo);

        expect(fn () => $useCase->execute($commandeId))
            ->toThrow(InvalidArgumentException::class, 'Aucune livraison associée à cette commande.');
    });
});
