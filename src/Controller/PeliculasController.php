<?php

namespace App\Controller;

use App\Repository\PeliculasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request; 
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Critica;

class PeliculasController extends AbstractController
{
    #[Route('/listar', name: 'app_listar_pelicula')]
    public function index(PeliculasRepository $peliculasRepository): Response
    {
        $peliculas = $peliculasRepository->findAll();
        $peliculasJson = array();

        foreach ($peliculas as $pelicula) {
            $peliculasJson[] = [
                "id" => $pelicula->getId(),
                "titulo" => $pelicula->getTitulo(),
                "descripcion" => $pelicula->getDescripcion(),
                "año" => $pelicula->getAño(),
                "genero" => $pelicula->getGenero(),

            ];
        }

        return $this->json($peliculasJson);
    }

    #[Route('/critica', name: 'app_critica', methods: ['POST'])]
    public function createCritica(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $movieId = $data['movieId'] ?? null;
        $userId = $data['userId'] ?? null;
        $criticatext = $data['criticatext'] ?? null;

        if (!$movieId || !$userId || !$criticatext) {
            return $this->json(['error' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
        }

        $critica = new Critica();
        $critica->setMovieId($movieId);
        $critica->setUserId($userId);
        $critica->setCriticatext($criticatext);

        $entityManager->persist($critica);
        $entityManager->flush();

        return $this->json(['message' => 'Critica created successfully'], Response::HTTP_CREATED);
    }

    #[Route('/critica/{movieId}', name: 'get_critica_by_movie', methods: ['GET'])]
    public function getCriticaByMovieId($movieId, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Critica::class);
        $criticas = $repository->findBy(['movieId' => $movieId]);

        if (!$criticas) {
            return $this->json(['error' => 'No critiques found for this movie'], Response::HTTP_NOT_FOUND);
        }

        // Filtrar y devolver los campos 'criticatext' y 'userId'
        $response = array_map(function($critica) {
            return [
                'criticatext' => $critica->getCriticatext(),
                'userId' => $critica->getUserId()
            ];
        }, $criticas);

        return $this->json($response);
    }
}
