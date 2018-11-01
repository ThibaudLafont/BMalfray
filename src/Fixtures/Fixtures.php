<?php
namespace App\Fixtures;

use App\Entity\IndexInfo;
use App\Entity\Media\Local\Explanation;
use App\Entity\Project\Category;
use App\Entity\Project\Contributor;
use App\Entity\Project\Explanation\Paragraph;
use App\Entity\Project\Explanation\Title;
use App\Entity\Project\HighConcept;
use App\Entity\Project\Lists\CategoryList;
use App\Entity\Project\Lists\ProjectList;
use App\Entity\Project\Project;
use App\Entity\User;
use App\Service\Sluggifier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Yaml\Yaml;

/**
 * Parse YAML datas and persist them in DB
 *
 * @package App\Fixtures
 */
class Fixtures extends Fixture
{

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var Sluggifier
     */
    private $sluggifier;

    public function __construct(Sluggifier $sluggifier)
    {
        $this->setSluggifier($sluggifier);
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Store manager
        $this->setManager($manager);

        // Load and parse Index YAML file
        $datas =  Yaml::parse(file_get_contents(__DIR__ . '/data/Infos.yaml'));
        $this->loadIndexInfos($datas);

        // Load and parse LD YAML file
        $datas = Yaml::parse(file_get_contents(__DIR__ . '/data/LevelDesign.yaml'));
        $this->loadCategoryProjects($datas);

        // Load and parse GD YAML file
       $datas =  Yaml::parse(file_get_contents(__DIR__ . '/data/GameDesign.yaml'));
       $this->loadCategoryProjects($datas);

        // Load and parse GD YAML file
        $datas =  Yaml::parse(file_get_contents(__DIR__ . '/data/User.yaml'));
        $this->loadUsers($datas);

        // Flush results
        $manager->flush();
    }

    public function loadUsers(array $datas)
    {
        foreach ($datas as $data) {
            $user = new User();
            $user->setUsername($data['username']);
            $user->setPassword($data['mdp']);
            $user->setRoles(['ROLE_USER']);

            $this->getManager()->persist($user);
        }
    }

    public function loadIndexInfos(array $datas)
    {
        $index = new IndexInfo();
        $index->setName($datas['name']);
        $index->setContent($datas['biography']);
        $index->setRawContent($datas['biography']);
        $index->setPhoneNumber($datas['phone_number']);
        $index->setCity($datas['city']);

        $this->getManager()->persist($index);
    }

    /**
     * From YAML::parse, init and persist objects
     * General method for persist Category, Projects, Medias, Contributors
     *
     * @param array $datas
     */
    private function loadCategoryProjects(array $datas)
    {
        // Get manager
        $manager = $this->getManager();

        // Create&Persist Category
        $category = $this->createCategory($datas['category']);
        $manager->persist($category);
    }

    /**
     * Create and Hydrate Category from array
     *
     * @param array $datas
     * @return Category
     */
    private function createCategory(array $datas)
    {

        // Create&Persist Category
        $category = new Category();
        $category->setName($datas['name']);
        $category->setSlugName(
            $this->getSluggifier()->sluggify($datas['name'])
        );
        $category->setSummary($datas['summary']);

        $i=1;
        foreach ($datas['skills'] as $item) {
            $skill = new CategoryList();
            $skill->setPosition($i);
            $skill->setContent($item);
            $skill->setCategory($category);

            $this->getManager()->persist($skill);
            $i++;
        }

        // Return object
        return $category;

    }

    /**
     * Get manager
     *
     * @return ObjectManager
     */
    public function getManager(): ObjectManager
    {
        return $this->manager;
    }

    /**
     * Set manager
     *
     * @param ObjectManager $manager
     */
    public function setManager(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return Sluggifier
     */
    public function getSluggifier(): Sluggifier
    {
        return $this->sluggifier;
    }

    /**
     * @param Sluggifier $sluggifier
     */
    public function setSluggifier(Sluggifier $sluggifier)
    {
        $this->sluggifier = $sluggifier;
    }

}
