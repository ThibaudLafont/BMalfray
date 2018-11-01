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
        // Get Category
        $cat = $em->getRepository(Category::class)
            ->findOneBy(
                ['slugName' => $cat]
            );
        // Store projects
        $projects = $cat->getProjects();

        // If no category related to slug name
        if(is_null($cat)){
            throw new NotFoundHttpException('Aucune ressource ici...');
        // If no project posted
        }elseif(count($projects) === 0) {
            return $this->redirectToRoute('no_project');
        }

        return $this->render(
            'project/category.html.twig',
            [
                'cat'      => $cat,
                'projects' => $projects
            ]
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