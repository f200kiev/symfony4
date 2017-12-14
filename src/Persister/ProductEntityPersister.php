<?php

namespace App\Persister;

use App\Entity\ProductEntity;
use Doctrine\ORM\EntityManagerInterface;

class ProductEntityPersister
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(ProductEntity $entity): ProductEntity
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    public function update(ProductEntity $newProduct, ProductEntity $oldProduct): ProductEntity
    {
        $oldProduct->setProductName($newProduct->getProductName());
        $oldProduct->setProductValue($newProduct->getProductValue());

        $this->entityManager->persist($oldProduct);
        $this->entityManager->flush();

        return $oldProduct;
    }

    public function remove(ProductEntity $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}
