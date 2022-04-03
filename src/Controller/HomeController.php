<?php

namespace App\Controller;

use App\Entity\Question;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Question::class);

        $questions = $doctrine
            ->getRepository(Question::class)
            ->getQuestionOrderByDate(true);

        return $this->render('home/index.html.twig', [
            'questions' => $questions
        ]);
    }
}
