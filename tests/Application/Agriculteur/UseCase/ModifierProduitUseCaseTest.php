<?php

namespace Tests\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\ModifierProduitUseCase;
use App\Domain\Produit\Produit;
use App\Domain\Produit\ProduitRepositoryInterface;
use InvalidArgumentException;
use Mockery;

describe('ModifierProduitUseCase', function () {
    beforeEach(function () {
        // Mock du repository avec la BONNE interface
        $this->repositoryMock = Mockery::mock(ProduitRepositoryInterface::class);
        $this->useCase = new ModifierProduitUseCase($this->repositoryMock);
    });

    it('modifie un produit existant et le persiste', function () {
        $produitId = 'prod-123';
        $data = [
            'nom' => 'Tomates bio',
            'description' => 'Tomates fraîches du jardin',
            'prixUnitaire' => 3.99,
            'stock' => 75,
            'unite' => 'kg',
        ];

        $produitMock = Mockery::mock(Produit::class);
        $produitMock->shouldReceive('setNom')->with($data['nom'])->once()->andReturnSelf();
        $produitMock->shouldReceive('setDescription')->with($data['description'])->once()->andReturnSelf();
        $produitMock->shouldReceive('setPrixUnitaire')->with($data['prixUnitaire'])->once()->andReturnSelf();
        $produitMock->shouldReceive('setStock')->with($data['stock'])->once()->andReturnSelf();
        $produitMock->shouldReceive('setUnite')->with($data['unite'])->once()->andReturnSelf();

        $this->repositoryMock->shouldReceive('findById')
            ->with($produitId)
            ->once()
            ->andReturn($produitMock);
        $this->repositoryMock->shouldReceive('save')
            ->with($produitMock)
            ->once();

        $this->useCase->execute($produitId, $data);

        expect(true)->toBeTrue(); // succès si aucune exception
    });

    it('lève une exception si le produit n\'existe pas', function () {
        $produitId = 'prod-inexistant';
        $data = ['nom' => 'Nouveau nom'];

        $this->repositoryMock->shouldReceive('findById')
            ->with($produitId)
            ->once()
            ->andReturnNull();
        $this->repositoryMock->shouldReceive('save')->never();

        expect(fn () => $this->useCase->execute($produitId, $data))
            ->toThrow(InvalidArgumentException::class, 'Produit non trouvé.');
    });

    it('ne modifie que les champs fournis dans le tableau de données', function () {
        $produitId = 'prod-456';
        $data = [
            'prixUnitaire' => 12.50,
            'stock' => 100,
        ];

        $produitMock = Mockery::mock(Produit::class);
        $produitMock->shouldReceive('setPrixUnitaire')->with(12.50)->once()->andReturnSelf();
        $produitMock->shouldReceive('setStock')->with(100)->once()->andReturnSelf();
        $produitMock->shouldReceive('setNom')->never();
        $produitMock->shouldReceive('setDescription')->never();
        $produitMock->shouldReceive('setUnite')->never();

        $this->repositoryMock->shouldReceive('findById')
            ->with($produitId)
            ->once()
            ->andReturn($produitMock);
        $this->repositoryMock->shouldReceive('save')
            ->with($produitMock)
            ->once();

        $this->useCase->execute($produitId, $data);
        expect(true)->toBeTrue();
    });
});
