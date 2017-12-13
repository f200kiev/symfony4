<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductEntityRepository")
 */
class ProductEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $productName;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    private $productValue;

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function setProductName($productName): void
    {
        $this->productName = $productName;
    }

    public function getProductValue(): int
    {
        return $this->productValue;
    }

    public function setProductValue($productValue): void
    {
        $this->productValue = $productValue;
    }
}
