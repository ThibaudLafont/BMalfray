<?php
namespace App\Entity\Project;

use App\Entity\Project\Lists\CategoryList;
use App\Traits\Entity\Hydrate;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Category
 *
 * @ORM\Entity
 * @ORM\Table(name="project_category")
 */
class Category{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=75)
     *
     * @Assert\NotBlank(message="Veuillez renseigner un titre")
     * @Assert\Type(
     *     type="string",
     *     message="Le titre doit être une chaine de caractères"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug_name", type="string", length=255)
     */
    protected $slugName;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="text")
     *
     * @Assert\NotBlank(message="Veuillez renseigner un résumé")
     * @Assert\Type(
     *     type="string",
     *     message="Le résumé doit être une chaine de caractères"
     * )
     */
    private $summary;

    /**
     * @var mixed
     *
     * @ORM\OneToMany(
     *     targetEntity="\App\Entity\Project\Lists\CategoryList",
     *     mappedBy="category",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     * )
     *
     * @Assert\Valid
     * @Assert\Count(
     *      min = 1,
     *      minMessage = "Veuillez fournir au moins une compétence"
     * )
     */
    private $skillListItems;

    /**
     * Category's projects
     *
     * @var mixed
     *
     * @ORM\OneToMany(
     *     targetEntity="\App\Entity\Project\Project",
     *     mappedBy="category"
     * )
     * @ORM\OrderBy({"endDate" = "DESC"})
     */
    private $projects;

    // Traits
    use Hydrate;

    /**
     * Get id
     *
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set summary
     *
     * @param string $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return mixed
     */
    public function getDistantMedias()
    {
        return $this->distantMedias;
    }

    /**
     * @return mixed
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @param mixed $projects
     */
    public function setProjects($projects)
    {
        $this->projects = $projects;
    }

    /**
     * @return string
     */
    public function getSlugName(): string
    {
        return $this->slugName;
    }

    /**
     * @param string $slugName
     */
    public function setSlugName(string $slugName)
    {
        $this->slugName = $slugName;
    }

    /**
     * @return mixed
     */
    public function getSkillListItems()
    {
        return $this->skillListItems;
    }

    public function setSkillListItems($skillListItems)
    {
        // Avoid existant skillListItems duplication
        $this->skillListItems->clear();

        // Loop and assign Entities to this Book
        foreach($skillListItems as $skill){
            if($skill instanceof CategoryList){
                $this->addSkillListItem($skill);
            }
        }
    }

    public function addSkillListItem(CategoryList $skill) {
        // Add BookHasMedia to array
        $this->skillListItems->add($skill);
        //Set this to bookHasMedia
        $skill->setCategory($this);
    }

}
