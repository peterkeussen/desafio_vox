<?php

namespace App\Controller;

use App\Entity\Socio;
use App\Repository\SocioRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SocioController extends AbstractController
{
    #[Route('/socios', name: 'socios_create', methods: ["POST"])]
    public function create(Request $request, SocioRepository $socioRepository): JsonResponse
    {
        $data = $request->request->all();
        $socio = new Socio();
        $socio->setNome($data['nome']);
        $socio->setCpf($data['cpf']);

        $socioRepository->add($socio, true);

        return $this->json([
            'message' => 'Socio criado com sucesso',
            'data' => $socio,
        ], 201, [], [
            ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            }
        ]);
    }

    #[Route('/socios', name: 'socios_list', methods: ["GET"])]
    public function list(SocioRepository $socioRepository): JsonResponse
    {        
        return $this->json([
            'data' => $socioRepository->findAll(),
        ], 200, [], [
            // ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
            //     return $object->getId();
            // }
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['empresas']
        ]);
    }

    #[Route('/socios/{id}', name: 'socios_update', methods: ["PUT", "PATCH"])]
    public function update(Request $request, ManagerRegistry $doctrine, SocioRepository $socioRepository, int $id): JsonResponse
    {        
        $data = $request->request->all();
        $socio = $socioRepository->find($id);

        if(!$socio) {
            throw $this->createNotFoundException('Empresa não encontrada');
        }

        $socio->setNome($data['nome']);
        $socio->setCpf($data['cpf']);        
        
        $doctrine->getManager()->persist($socio);
        $doctrine->getManager()->flush();

        $socio = $socioRepository->find($id);
             
        return $this->json([
            'message' => 'Socio atualizado com sucesso',
            'data' => $socio,
        ], 201, [], [
            // ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
            //     return $object->getId();
            // }
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['empresas']
        ]);
    }

    #[Route('/socios/{id}', name: 'socios_delete', methods: ["DELETE"])]
    public function delete(SocioRepository $socioRepository, int $id): JsonResponse
    {        
        $socio = $socioRepository->find($id);

        if(!$socio) {
            throw $this->createNotFoundException('Socio não encontrado');
        }

        $socioRepository->remove($socio, true);
             
        return $this->json([
            'message' => 'Socio excluída com sucesso.',
            'data' => $socio,
        ], 200, [], [
            // ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
            //     return $object->getId();
            // }
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['empresas']
        ]);
    }

    #[Route('/socio/{id}', name: 'socio', methods: ["GET"])]
    public function show(SocioRepository $socioRepository, int $id): Response
    {        
        $socio = $socioRepository->find($id);
        if(!$socio) {
            throw $this->createNotFoundException('Socio não encontrado');
        }

        // $normalizer = new ObjectNormalizer();
        // $encoder = new JsonEncoder();
        // $serializer = new Serializer([$normalizer], [$encoder]);
        // $jsonContent = $serializer->serialize($socio, 'json', [
        //     AbstractNormalizer::IGNORED_ATTRIBUTES => ['empresas']
        // ]);
        // $response = new Response($jsonContent);
        // return $response;

        return $this->json([            
            'data' => $socio,
        ], 200, [], [
            // ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
            //     return $object->getId();
            // }
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['empresas']
        ]);
    }
}
