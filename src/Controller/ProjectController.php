<?php
namespace App\Controller;

use App\Entity\Project\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends Controller
{

    /**
     * @Route(
     *     "/projects",
     *     name="project_list"
     * )
     */
    public function listAction() {

        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository(Project::class)
            ->findBy([], ['endDate' => 'DESC']);

        return $this->render(
            'project/list.html.twig',
            ['projects' => $projects]
        );

    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(
     *     "/project/{slugName}",
     *     name="project_show",
     *     requirements={"slugName"="(.+|-)+"}
     * )
     */
    public function showAction($slugName) {

        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('App:Project\Project')
            ->findOneBy(['slugName' => $slugName]);

        if(is_null($project)) {
            throw new NotFoundHttpException('Aucun projet ici...');
        }

        return $this->render(
            'project/show.html.twig',
            ['project' => $project]
        );

    }

}
