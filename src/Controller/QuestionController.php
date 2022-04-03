<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @param int $id
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/question/{id}', name: 'app_question')]
    public function index(int $id, ManagerRegistry $doctrine): Response
    {
        $question = $doctrine
            ->getRepository(Question::class)
            ->getQuestionById($id);

        $answers = $doctrine
            ->getRepository(Answer::class)
            ->getAnswersOnQuestion($id, true);

        return $this->render('question/index.html.twig', [
            'q' => $question,
            'answers' => $answers
        ]);
    }
}
