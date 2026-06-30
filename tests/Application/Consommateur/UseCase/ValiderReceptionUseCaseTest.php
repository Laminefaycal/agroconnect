<?php

// tests/Application/Consommateur/UseCase/ValiderReceptionUseCaseTest.php

namespace Tests\Application\Consommateur\UseCase;

use App\Application\Consommateur\Dto\ValiderReceptionDto;
use App\Application\Consommateur\UseCase\ValiderReceptionUseCase;
use App\Domain\Commande\Commande;
use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Commande\StatutCommande;
use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\Repository\LivraisonRepositoryInterface;
use App\Domain\Livraison\StatutLivraison;
use InvalidArgumentException;
use Mockery;
use PHPUnit\Framework\TestCase;

uses(TestCase::class);

describe('ValiderReceptionUseCase', function () {

    it('valide la réception avec succès lorsque le statut est EN_ROUTE', function () {
        $commandeId = 'cmd-123';
        $dto = new ValiderReceptionDto($commandeId, true);

        $livraison = Mockery::mock(Livraison::class);
        $livraison->shouldReceive('getStatut')->once()->andReturn(StatutLivraison::EN_ROUTE);
        $livraison->shouldReceive('mettreAJourStatut')->once()->with(StatutLivraison::LIVREE);

        $commande = Mockery::mock(Commande::class);
        $commande->shouldReceive('getLivraison')->once()->andReturn($livraison);
        $commande->shouldReceive('setStatut')->once()->with(StatutCommande::LIVREE);

        $commandeRepo = Mockery::mock(CommandeRepositoryInterface::class);
        $commandeRepo->shouldReceive('findById')->with($commandeId)->once()->andReturn($commande);
        $commandeRepo->shouldReceive('save')->with($commande)->once();

        $livraisonRepo = Mockery::mock(LivraisonRepositoryInterface::class);
        $livraisonRepo->shouldReceive('save')->with($livraison)->once();

        $useCase = new ValiderReceptionUseCase($commandeRepo, $livraisonRepo);

        $useCase->execute($dto);

        expect(true)->toBeTrue();
    });

    it('lève une exception si la commande est introuvable', function () {
        $commandeId = 'cmd-123';
        $dto = new ValiderReceptionDto($commandeId, true);

        $commandeRepo = Mockery::mock(CommandeRepositoryInterface::class);
        $commandeRepo->shouldReceive('findById')->with($commandeId)->once()->andReturn(null);

        $livraisonRepo = Mockery::mock(LivraisonRepositoryInterface::class);

        $useCase = new ValiderReceptionUseCase($commandeRepo, $livraisonRepo);

        expect(fn () => $useCase->execute($dto))
            ->toThrow(InvalidArgumentException::class, "Commande introuvable avec l'ID : cmd-123");
    });

    it('lève une exception si la commande n\'a pas de livraison associée', function () {
        $commandeId = 'cmd-123';
        $dto = new ValiderReceptionDto($commandeId, true);

        $commande = Mockery::mock(Commande::class);
        $commande->shouldReceive('getLivraison')->once()->andReturn(null);

        $commandeRepo = Mockery::mock(CommandeRepositoryInterface::class);
        $commandeRepo->shouldReceive('findById')->with($commandeId)->once()->andReturn($commande);

        $livraisonRepo = Mockery::mock(LivraisonRepositoryInterface::class);

        $useCase = new ValiderReceptionUseCase($commandeRepo, $livraisonRepo);

        expect(fn () => $useCase->execute($dto))
            ->toThrow(InvalidArgumentException::class, 'Aucune livraison associée à cette commande.');
    });

    it('lève une exception si le statut actuel est déjà final (LIVREE)', function () {
        $commandeId = 'cmd-123';
        $dto = new ValiderReceptionDto($commandeId, true);

        $livraison = Mockery::mock(Livraison::class);
        $livraison->shouldReceive('getStatut')->once()->andReturn(StatutLivraison::LIVREE);

        $commande = Mockery::mock(Commande::class);
        $commande->shouldReceive('getLivraison')->once()->andReturn($livraison);

        $commandeRepo = Mockery::mock(CommandeRepositoryInterface::class);
        $commandeRepo->shouldReceive('findById')->with($commandeId)->once()->andReturn($commande);

        $livraisonRepo = Mockery::mock(LivraisonRepositoryInterface::class);

        $useCase = new ValiderReceptionUseCase($commandeRepo, $livraisonRepo);

        expect(fn () => $useCase->execute($dto))
            ->toThrow(
                InvalidArgumentException::class,
                'La livraison est déjà dans un état final (statut actuel : LIVREE).'
            );
    });

    it('lève une exception si le statut actuel est PROBLEME', function () {
        $commandeId = 'cmd-123';
        $dto = new ValiderReceptionDto($commandeId, true);

        $livraison = Mockery::mock(Livraison::class);
        $livraison->shouldReceive('getStatut')->once()->andReturn(StatutLivraison::PROBLEME);

        $commande = Mockery::mock(Commande::class);
        $commande->shouldReceive('getLivraison')->once()->andReturn($livraison);

        $commandeRepo = Mockery::mock(CommandeRepositoryInterface::class);
        $commandeRepo->shouldReceive('findById')->with($commandeId)->once()->andReturn($commande);

        $livraisonRepo = Mockery::mock(LivraisonRepositoryInterface::class);

        $useCase = new ValiderReceptionUseCase($commandeRepo, $livraisonRepo);

        expect(fn () => $useCase->execute($dto))
            ->toThrow(
                InvalidArgumentException::class,
                'La livraison est déjà dans un état final (statut actuel : PROBLEME).'
            );
    });

    it('lève une exception si estLivree est false', function () {
        $commandeId = 'cmd-123';
        $dto = new ValiderReceptionDto($commandeId, false);

        $livraison = Mockery::mock(Livraison::class);
        $livraison->shouldReceive('getStatut')->once()->andReturn(StatutLivraison::EN_ROUTE);

        $commande = Mockery::mock(Commande::class);
        $commande->shouldReceive('getLivraison')->once()->andReturn($livraison);

        $commandeRepo = Mockery::mock(CommandeRepositoryInterface::class);
        $commandeRepo->shouldReceive('findById')->with($commandeId)->once()->andReturn($commande);

        $livraisonRepo = Mockery::mock(LivraisonRepositoryInterface::class);

        $useCase = new ValiderReceptionUseCase($commandeRepo, $livraisonRepo);

        expect(fn () => $useCase->execute($dto))
            ->toThrow(InvalidArgumentException::class, "La réception n'a pas été confirmée par le consommateur.");
    });

    it('accepte un statut ASSIGNEE et valide la réception', function () {
        $commandeId = 'cmd-123';
        $dto = new ValiderReceptionDto($commandeId, true);

        $livraison = Mockery::mock(Livraison::class);
        $livraison->shouldReceive('getStatut')->once()->andReturn(StatutLivraison::ASSIGNEE);
        $livraison->shouldReceive('mettreAJourStatut')->once()->with(StatutLivraison::LIVREE);

        $commande = Mockery::mock(Commande::class);
        $commande->shouldReceive('getLivraison')->once()->andReturn($livraison);
        $commande->shouldReceive('setStatut')->once()->with(StatutCommande::LIVREE);

        $commandeRepo = Mockery::mock(CommandeRepositoryInterface::class);
        $commandeRepo->shouldReceive('findById')->with($commandeId)->once()->andReturn($commande);
        $commandeRepo->shouldReceive('save')->with($commande)->once();

        $livraisonRepo = Mockery::mock(LivraisonRepositoryInterface::class);
        $livraisonRepo->shouldReceive('save')->with($livraison)->once();

        $useCase = new ValiderReceptionUseCase($commandeRepo, $livraisonRepo);

        $useCase->execute($dto);

        expect(true)->toBeTrue();
    });

    it('accepte un statut PRISE_EN_CHARGE et valide la réception', function () {
        $commandeId = 'cmd-123';
        $dto = new ValiderReceptionDto($commandeId, true);

        $livraison = Mockery::mock(Livraison::class);
        $livraison->shouldReceive('getStatut')->once()->andReturn(StatutLivraison::PRISE_EN_CHARGE);
        $livraison->shouldReceive('mettreAJourStatut')->once()->with(StatutLivraison::LIVREE);

        $commande = Mockery::mock(Commande::class);
        $commande->shouldReceive('getLivraison')->once()->andReturn($livraison);
        $commande->shouldReceive('setStatut')->once()->with(StatutCommande::LIVREE);

        $commandeRepo = Mockery::mock(CommandeRepositoryInterface::class);
        $commandeRepo->shouldReceive('findById')->with($commandeId)->once()->andReturn($commande);
        $commandeRepo->shouldReceive('save')->with($commande)->once();

        $livraisonRepo = Mockery::mock(LivraisonRepositoryInterface::class);
        $livraisonRepo->shouldReceive('save')->with($livraison)->once();

        $useCase = new ValiderReceptionUseCase($commandeRepo, $livraisonRepo);

        $useCase->execute($dto);

        expect(true)->toBeTrue();
    });
});
