<?php

namespace App\Controller;

use App\Service\Interfaces\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResumeController extends AbstractController
{

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * ResumeController constructor.
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(
        UserServiceInterface $userService
    ) {
        $this->userService = $userService;
    }

    /**
     * @Route("/", name="resume")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {

        $form = $this->createFormBuilder(null, ['method' => 'GET'])
            ->add('username', TextType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $resultDto = null;
        $username = null;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $username = $data['username'];
        }

        if (!empty($username)) {
            $resultDto = $this->userService->getUser($username);
        }

        return $this->render('resume/index.html.twig', [
            'controller_name' => 'ResumeController',
            'form' => $form->createView(),
            'result' => $resultDto
        ]);
    }
}
