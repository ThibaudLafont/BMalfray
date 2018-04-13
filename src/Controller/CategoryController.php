<?php
namespace App\Controller;

use App\Entity\Project\Category;
use App\Entity\Project\Lists\CategoryList;
use App\Entity\Project\Lists\ProjectList;
use App\Entity\Project\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{

    /**
     * @Route(
     *     "/projects/{cat}",
     *     name="category_projects",
     *     requirements={
     *          "cat"="([a-z]+|-)+"
     *     }
     * )
     */
    public function listProjectsAction($cat) {

        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository(Category::class)
            ->findOneBy(
                ['slugName' => $cat]
            );

        if(is_null($cat)) {
//            throw new NotFoundHttpException("Aucune resource ici");
            return $this->redirectToRoute('no_project');
        }

        $projects = $cat->getProjects();

        return $this->render(
            'project/category.html.twig',
            ['projects' => $projects]
        );

    }

    /**
     * @Route(
     *     "/category/empty",
     *     name="no_project"
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function noProjectAction() {

        return $this->render('project/no-project.html.twig');

    }

}