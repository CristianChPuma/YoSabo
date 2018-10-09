<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Question;
use App\Entity\UserQuestionChoice;
use App\Service\FileUploader;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Config\Definition\Exception\Exception;
use App\Entity\QuestionChoice;

class QuestionController extends AbstractController
{
    /**
     * @Route("/preguntas", name="questions")
     */
    public function index(Security $security)
    {

      $user = $security->getUser();
      $choices = $user->getUserquestionchoices();

      $questionIds = [];

     foreach($choices as $choice){
       if($choice->getIsRight()){
       $questionIds[] = $choice->getQuestion();
      }
     }

     if(count($questionIds)){

       $finalquestions = $this->getDoctrine()
           ->getRepository(Question::class)
           ->findAllE($questionIds);
     }else{
       $finalquestions = $this->getDoctrine()
           ->getRepository(Question::class)
           ->findAll();
     }

     /*$finalquestions = $this->getDoctrine()
         ->getRepository(Question::class)
         ->findAllE($questionIds);

         throw new Exception();
*/
    //throw new Exception(count($finalquestions));

    if(count($finalquestions) > 0 ){
       $randomQuestion = $finalquestions[mt_rand(0, count($finalquestions)-1)];
    }
    else{
       $randomQuestion = "";
    }



        return $this->render('frontend/question/index.html.twig', [
            'title' => 'Sesión de Preguntas',
            'question' => $randomQuestion
        ]);

    }

    /**
     * @Route("/sumpoints", name="sum-points")
     */
    public function sumPoints(Request $request, Security $security)
    {

        if($isright = $request->request->get('isright')){

              $entityManager = $this->getDoctrine()->getManager();

              $questionId = $request->request->get('questionid');
              $points = $request->request->get('questionpoints');

              $user = $security->getUser();
              $currentuserPoints = $user->getScore();
              $newUserScore = $points + $currentuserPoints;


              $user->setScore($newUserScore);


              $currentQuestion = $this->getDoctrine()
                  ->getRepository(Question::class)
                  ->findOneById($questionId);

              $user = $security->getUser();
              $choices = $user->getUserquestionchoices();
              $answeredQuestion = [];

              foreach($choices as $choice){
                $answeredQuestion[] = $choice->getQuestion();
              }

              $questionchoice = $this->getDoctrine()
                                ->getRepository(UserQuestionChoice::class)
                                ->findOneBy(['question' => $currentQuestion, 'user' => $user]);

              if($questionchoice){
                //throw new Exception($isright);
                if($isright == "true"){
                $questionchoice->setIsRight(true);
              }
                if($isright == "false")
              {
                //throw new Exception("false");
                $questionchoice->setIsRight(false);
              }

                $entityManager->persist($questionchoice);

              }else{

                //throw new Exception($isright);

                $userquestionchoice = new UserQuestionChoice();
                $userquestionchoice->setQuestion($currentQuestion);
                if($isright == "true"){
                $userquestionchoice->setIsRight(true);
              }
                if($isright == "false")
              {
                //throw new Exception("false");
                $userquestionchoice->setIsRight(false);
              }
                $userquestionchoice->setUser($user);
                $entityManager->persist($userquestionchoice);

              }



              $entityManager->persist($user);
              $entityManager->flush();

              return new JsonResponse(array(
                    'isright' => $isright,
                    'points' => $points
               ));

        }

    }

    /**
     * @Route("/addquestion", name="add-question")
     */
     public function addQuestion(Request $request, FileUploader $fileUploader){

       if ($coverfile = $request->files->get('filedata')) {

         $entityManager = $this->getDoctrine()->getManager();

         $questiondata = $request->get('question');
         $explanation = $request->get('explanation');
         $score = $request->get('score');

         $answers = [];

         $answers[] = $request->get('answer_a');
         $answers[] = $request->get('answer_b');
         $answers[]  = $request->get('answer_c');
         $answers[]  = $request->get('answer_d');

        $question = new Question();
        $question->setQuestion($questiondata);
        $question->setExplanation($explanation);
        $question->setRewards($score);
        $fileName = $fileUploader->upload($coverfile);
        $question->setCover($fileName);

        $entityManager->persist($question);

        for($i = 0; $i<count($answers); $i++){
          $choices = new QuestionChoice();
          $choices->setQuestion($question);
          $choices->setChoice($answers[$i]);
          if($i==0){
            $choices->setIsrightchoice(true);
          }else{
            $choices->setIsrightchoice(false);
          }
          $entityManager->persist($choices);
        }

        $entityManager->flush();

        return new JsonResponse(array(

         ));

       }

     }


   public function fillQuestions(){

     $questions = $this->getDoctrine()
         ->getRepository(Question::class)
         ->findAll([],['id'=>'DESC']);

         return $this->render(
               'frontend/components/questioncard.html.twig',
               array('questions' => $questions)
           );

   }

}
