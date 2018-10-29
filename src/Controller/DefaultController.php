<?php
namespace App\Controller;

use App\Entity\Project\Project;
use App\Form\Type\ContactType;
use App\Service\MailSender;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{

    /**
     * @Route(
     *     "/",
     *     name="homepage"
     * )
     */
    public function homeAction(Request $request, MailSender $mailer) {

        $form = $this->createForm('App\Form\Type\ContactType');

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $data = $form->getData();

                $mailer->sendMail($data['name'], $data['email'], $data['content']);

                $this->addFlash('success', 'Le mail a bien été envoyé');

                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render(
            'default/homepage.html.twig',
            ['form' => $form->createView()]
        );

    }

}