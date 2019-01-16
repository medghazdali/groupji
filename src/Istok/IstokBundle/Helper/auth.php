<?php

namespace Istok\IstokBundle\Entity;

class auth {

    private $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function get_identity() {
        
        return 45;
    }
}