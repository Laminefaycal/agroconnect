<?php

namespace Tests\Domain;

use App\Domain\Agriculteur\Agriculteur;
use PHPUnit\Framework\TestCase;

/**
 * Class AgriculteurTest
 *
 * Test unitaire pour l'entité Domaine Agriculteur.
 * Vérifie que le cycle de vie de base de l'objet et ses accesseurs fonctionnent correctement.
 */
class AgriculteurTest extends TestCase
{
    /**
     * Vérifie qu'un agriculteur peut être correctement créé et que ses données sont intègres.
     */
    public function test_un_agriculteur_peut_etre_cree_avec_ses_attributs(): void
    {
        // 1. ARRANGE (Préparation des données de test)
        $id = 'agri-123';
        $nom = 'Fayçal Moussa';
        $email = 'faycal@agroconnect.ga';
        $telephone = '+24165553199';
        $numeroSIRET = '123456789';

        // 2. ACT (Exécution de l'action : instanciation)
        $agriculteur = new Agriculteur($id, $nom, $email, $telephone, $numeroSIRET);

        // 3. ASSERT (Vérifications des résultats attendus)
        $this->assertInstanceOf(Agriculteur::class, $agriculteur);
        $this->assertEquals($id, $agriculteur->getId());
        $this->assertEquals($nom, $agriculteur->getNom());
        $this->assertEquals($email, $agriculteur->getEmail());
        $this->assertEquals($telephone, $agriculteur->getTelephone());
        $this->assertEquals($numeroSIRET, $agriculteur->getNumeroSIRET());
    }
}
