<?php

namespace App\Controller;

use App\Entity\Empresa;
use App\Entity\Socio;
use App\Repository\EmpresaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class EmpresaController extends AbstractController
{
    #[Route('/empresas', name: 'empresas_create', methods: ["POST"])]
    public function create(Request $request, EmpresaRepository $empresaRepository): JsonResponse
    {
        $data = $request->request->all();
        $empresa = new Empresa();
        $empresa->setNome($data['nome']);
        $empresa->setRazaosocial($data['razaosocial']);
        $empresa->setCnpj($data['cnpj']);
        
        $empresaRepository->add($empresa, true);
     
        return $this->json([
            'message' => 'Empresa criada com sucesso',
            'data' => $empresa,
        ], 201, [], [
            ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            }
        ]);
    }

    #[Route('/empresas', name: 'empresas_list', methods: ["GET"])]
    public function list(EmpresaRepository $empresaRepository): JsonResponse
    {        
        return $this->json([
            'data' => $empresaRepository->findAll(),
        ], 200, [], [ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
            return $object->getId();
        }]);
    }

    #[Route('/empresas/{id}', name: 'empresas_update', methods: ["PUT", "PATCH"])]
    public function update(Request $request, ManagerRegistry $doctrine, EmpresaRepository $empresaRepository, int $id): JsonResponse
    {        
        $data = $request->request->all();
        $empresa = $empresaRepository->find($id);

        if(!$empresa) {
            throw $this->createNotFoundException('Empresa não encontrada');
        }

        $empresa->setNome($data['nome']);
        $empresa->setRazaosocial($data['razaosocial']);
        $empresa->setCnpj($data['cnpj']);
        
        $doctrine->getManager()->persist($empresa);
        $doctrine->getManager()->flush();

        $empresa = $empresaRepository->find($id);
             
        return $this->json([
            'data' => $empresa,
        ], 201, [], [ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
            return $object->getId();
        }]);
    }

    #[Route('/empresas/{id}', name: 'empresas_delete', methods: ["DELETE"])]
    public function delete(EmpresaRepository $empresaRepository, int $id): JsonResponse
    {        
        $empresa = $empresaRepository->find($id);

        if(!$empresa) {
            throw $this->createNotFoundException('Empresa não encontrada');
        }

        $empresaRepository->remove($empresa, true);
             
        return $this->json([
            'message' => 'Empresa excluída com sucesso.',
            'data' => $empresa,
        ], 200, [], [ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
            return $object->getId();
        }]);
    }

    #[Route('/criar_empresas', name: 'criar_empresas')]
    public function createEmpresa(EntityManagerInterface $entityManager): JsonResponse
    {
        $empresa = new Empresa();
        $empresa->setNome('Nome da empresa');
        $empresa->setRazaosocial('Razão social da empresa');
        $empresa->setCnpj('00.000.000/0000-05');

        $socio1 = new Socio();
        $socio1->setNome('Nome do socio7');
        $socio1->setCpf('000.000.000-07');

        $socio2 = new Socio();
        $socio2->setNome('Nome do socio8');
        $socio2->setCpf('000.000.000-08');

        $empresa->addSocio($socio1);
        $socio1->addEmpresa($empresa);
        $empresa->addSocio($socio2);
        $socio2->addEmpresa($empresa);

        $entityManager->persist($empresa);      
        $entityManager->flush();
     
        return $this->json([
            'data' => $empresa,
        ], 200, [], [ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
            return $object->getId();
        }]);

        // return $this->render('empresa/index.html.twig', [
        //     'controller_name' => 'EmpresaController',
        // ]);
    }

 

    #[Route('/empresa/{id}', name: 'empresa', methods: ["GET"])]
    public function show(EmpresaRepository $empresaRepository, int $id): JsonResponse
    {        
        $empresa = $empresaRepository->find($id);

        if(!$empresa) {
            throw $this->createNotFoundException('Empresa não encontrada');
        }

        return $this->json([
            'data' => $empresa,
        ], 200, [], [ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
            return $object->getId();
        }]);
    }



}
