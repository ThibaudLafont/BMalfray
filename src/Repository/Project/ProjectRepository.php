<?php
namespace App\Repository\Project;

use App\Entity\Project\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function findByNewTime($criteria)
    {
        $statement = "
            SELECT p
            FROM App:Project\Project p
            JOIN App:Project\Category cat
            JOIN App:Project\Contributor cont
            WHERE cat.name = :cat_name
        ";

        // Execute the query and store results
        $projects = $this->getEntityManager()
            ->createQuery($statement)
            ->setParameter('cat_name', $criteria['cat_name'])
            ->execute();

        // Return result
        return $projects;

    }

    public function findForMenu($criteria)
    {
        $conn = $this->getEntityManager()->getConnection();

        // Create query and fetch
        $sql = '
            SELECT p.id, p.name, p.slug_name, cat.name as cat_name
            FROM `project_project` as p 
            JOIN project_category as cat 
              ON cat.id = p.category_id 
            ORDER BY p.end_date
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $projects = $stmt->fetchAll();

        // Treat result
        $return = ['ld' => [], 'gd' => []];
        foreach ($projects as $project) {
            // Build url
            $project['url'] =
                '/project/' . $project['id'] . '/' . $project['slug_name'];
            // Sort in two array on Category
            if($project['cat_name'] === 'Game Design') {
                $return['gd'][] = $project;
            } else {
                $return['ld'][] = $project;
            }
        }

        // Return result
        return $return;
    }
}