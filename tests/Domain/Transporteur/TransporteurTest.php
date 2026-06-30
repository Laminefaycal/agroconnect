<?php

namespace Tests\Domain\Transporteur;

use App\Domain\Transporteur\Transporteur;

describe('Transporteur', function () {
    it('peut être instancié avec toutes ses propriétés', function () {
        $transporteur = new Transporteur(
            'TR-001',
            'AgroLogistics',
            'contact@agrologistics.ga',
            '+241 77 88 99 00',
            'Camion bâché'
        );

        expect($transporteur->getId())->toBe('TR-001')
            ->and($transporteur->getNom())->toBe('AgroLogistics')
            ->and($transporteur->getEmail())->toBe('contact@agrologistics.ga')
            ->and($transporteur->getTelephone())->toBe('+241 77 88 99 00')
            ->and($transporteur->getVehicule())->toBe('Camion bâché');
    });

    it('retourne les bonnes valeurs avec les getters', function () {
        $transporteur = new Transporteur('TR-002', 'FastDelivery', 'info@fastdelivery.ga', '+241 66 55 44 33', 'Moto');

        expect($transporteur->getId())->toBe('TR-002')
            ->and($transporteur->getNom())->toBe('FastDelivery')
            ->and($transporteur->getEmail())->toBe('info@fastdelivery.ga')
            ->and($transporteur->getTelephone())->toBe('+241 66 55 44 33')
            ->and($transporteur->getVehicule())->toBe('Moto');
    });

    it('peut modifier le nom avec un setter fluent', function () {
        $transporteur = new Transporteur('TR-003', 'OldName', 'old@email.ga', '123', 'Van');
        $result = $transporteur->setNom('NewName');

        expect($result)->toBe($transporteur) // fluent
            ->and($transporteur->getNom())->toBe('NewName');
    });

    it('peut modifier l\'email avec un setter fluent', function () {
        $transporteur = new Transporteur('TR-004', 'Nom', 'old@email.ga', '123', 'Van');
        $result = $transporteur->setEmail('new@email.ga');

        expect($result)->toBe($transporteur)
            ->and($transporteur->getEmail())->toBe('new@email.ga');
    });

    it('peut modifier le téléphone avec un setter fluent', function () {
        $transporteur = new Transporteur('TR-005', 'Nom', 'email@test.ga', '123456', 'Van');
        $result = $transporteur->setTelephone('987654');

        expect($result)->toBe($transporteur)
            ->and($transporteur->getTelephone())->toBe('987654');
    });

    it('peut modifier le véhicule avec un setter fluent', function () {
        $transporteur = new Transporteur('TR-006', 'Nom', 'email@test.ga', '123', 'Vélo');
        $result = $transporteur->setVehicule('Camion');

        expect($result)->toBe($transporteur)
            ->and($transporteur->getVehicule())->toBe('Camion');
    });

    it('permet le chaînage des setters', function () {
        $transporteur = new Transporteur('TR-007', 'A', 'a@b.ga', '111', 'Scooter');

        $transporteur->setNom('B')
            ->setEmail('b@c.ga')
            ->setTelephone('222')
            ->setVehicule('Voiture');

        expect($transporteur->getNom())->toBe('B')
            ->and($transporteur->getEmail())->toBe('b@c.ga')
            ->and($transporteur->getTelephone())->toBe('222')
            ->and($transporteur->getVehicule())->toBe('Voiture');
    });
});
