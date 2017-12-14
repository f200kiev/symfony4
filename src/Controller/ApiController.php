<?php

namespace App\Controller;

use App\Entity\ProductEntity;
use App\Persister\ProductEntityPersister;
use App\Repository\ProductEntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiController extends Controller
{
    private $serializer;

    private $validator;

    private $entityPersister;

    private $entityRepository;

    public function __construct(
      SerializerInterface $serializer,
      ValidatorInterface $validator,
      ProductEntityPersister $entityPersister,
      ProductEntityRepository $entityRepository
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->entityPersister = $entityPersister;
        $this->entityRepository = $entityRepository;
    }

    /**
     * @Route("/api/product/add", name="add_product")
     * @Method({"POST"})
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addProduct(Request $request): Response
    {
        $product = $this->serializer->deserialize($request->getContent(), ProductEntity::class, 'json');

        $violations = $this->validator->validate($product);
        if (0 !== count($violations)) {
            return new JsonResponse($violations);
        }

        $this->entityPersister->save($product);

        return new JsonResponse(json_decode($this->serializer->serialize($product, 'json')));
    }

    public function updateProduct(int $productId, Request $request): JsonResponse
    {
    }

    /**
     * @Route("/api/product/{productId}", name="update_product")
     * @Method({"PUT"})
     *
     * @param int                                       $productId
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function patchProduct(int $productId, Request $request): JsonResponse
    {
        $newProduct = $this->serializer->deserialize($request->getContent(), ProductEntity::class, 'json');

        $violations = $this->validator->validate($newProduct);
        if (0 !== count($violations)) {
            return new JsonResponse(json_decode($violations));
        }

        $oldProduct = $this->entityRepository->find($productId);

        if (!$oldProduct) {
            return new JsonResponse('Product not found', JsonResponse::HTTP_NOT_FOUND);
        }

        $newProduct = $this->entityPersister->update($newProduct, $oldProduct);

        return new JsonResponse(json_decode($this->serializer->serialize($newProduct, 'json')));
    }

    /**
     * @Route("/api/product/{productId}", name="remove_product")
     * @Method({"DELETE"})
     *
     * @param int $productId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function removeProduct(int $productId): JsonResponse
    {
        $product = $this->entityRepository->find($productId);

        if (!$product) {
            return new JsonResponse('Product not found', JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityPersister->remove($product);

        $response = new JsonResponse();
        $response->setData('Product has been removed');

        return $response;
    }
}
