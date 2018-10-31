<?php
namespace App\Entity\Project;

use App\Entity\Project\Lists\ProjectList;
use App\Entity\Sonata\CoverImage;
use App\Traits\Entity\Hydrate;
use App\Entity\Sonata\ProjectHasMedia;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Project
 *
 * @ORM\Entity("App\Repository\Project\ProjectRepository")
 * @ORM\Table(name="project_project")
 * @ORM\EntityListeners({"App\EventListener\Project"})
 */
class Project{

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
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug_name", type="string", length=255)
     */
    protected $slugName;

    /**
     * Date of project initialisation
     *
     * @var \DateTime
     *
     * @ORM\Column(name="init_date", type="date")
     */
    private $initDate;

    /**
     * Date of project ending
     *
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date")
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="text")
     */
    private $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="raw_content", type="text")
     */
    private $rawContent;

    /**
     * @var int
     *
     * @ORM\Column(name="contributors_nbre", type="integer")
     */
    private $contributorsNbre;

    /**
     * @var string
     *
     * @ORM\Column(name="hc_type", type="string")
     */
    private $highConceptType;

    /**
     * @var string
     *
     * @ORM\Column(name="hc_gender", type="string")
     */
    private $highConceptGender;

    /**
     * @var string
     *
     * @ORM\Column(name="hc_target", type="string")
     */
    private $highConceptTarget;

    /**
     * @var mixed
     *
     * @ORM\OneToMany(
     *     targetEntity="\App\Entity\Project\Lists\ProjectList",
     *     mappedBy="project",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     * )
     */
    private $skillListItems;

    /**
     * Category of project
     *
     * @var Category
     *
     * @ORM\ManyToOne(
     *     targetEntity="\App\Entity\Project\Category",
     *     inversedBy="projects"
     * )
     */
    private $category;

    /**
     * @var CoverImage
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Sonata\CoverImage", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $coverImage;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Sonata\ProjectHasMedia",
     *     mappedBy="project",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     * )
     */
    private $projectHasMedias;

    /**
     * @var EventDispatcher
     */
    private $contentFormatter;

    // Traits
    use Hydrate;

    public function __construct()
    {
        $this->projectHasMedias = new ArrayCollection();
        $this->skillListItems = new ArrayCollection();
    }

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
    public function setName(string $name)
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
    public function setSummary(string $summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return \DateTime
     */
    public function getInitDate()
    {
        return $this->initDate;
    }

    private function stringToDateTime(string $date)
    {
        return new \DateTime($date);
    }

    /**
     * @param \DateTime|string $initDate
     */
    public function setInitDate($initDate)
    {
        if(is_string($initDate)) $initDate = $this->stringToDateTime($initDate);

        $this->initDate = $initDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime|string $endDate
     */
    public function setEndDate($endDate)
    {
        if(is_string($endDate)) $endDate = $this->stringToDateTime($endDate);

        $this->endDate = $endDate;
    }

    public function getDuration()
    {
        return $this->getInitDate()
            ->diff(
                $this->getEndDate(),
                true
            )
            ->format('%a jours')
        ;
    }

    public function getShowUrl()
    {
        return '/project/' . $this->getSlugName();
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
     * @return string
     */
    public function getContributorsNbre()
    {
//        $count = $this->contributorsNbre;
//        if($count === 0) return 'Aucun collaborateur';
//        return $count . ' collaborateurs';
        return $this->contributorsNbre;
    }

    /**
     * @param int $contributorsNbre
     */
    public function setContributorsNbre(int $contributorsNbre)
    {
        $this->contributorsNbre = $contributorsNbre;
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
            if($skill instanceof ProjectList){
                $this->addSkillListItem($skill);
            }
        }
    }

    public function addSkillListItem(ProjectList $skill) {
        // Add BookHasMedia to array
        $this->skillListItems->add($skill);
        //Set this to bookHasMedia
        $skill->setProject($this);
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * @param string $rawContent
     */
    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;
    }

    /**
     * @return mixed
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    /**
     * @param mixed $contentFormatter
     */
    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;
    }

    /**
     * @return string
     */
    public function getHighConceptType()
    {
        return $this->highConceptType;
    }

    /**
     * @param string $highConceptType
     */
    public function setHighConceptType(string $highConceptType): void
    {
        $this->highConceptType = $highConceptType;
    }

    /**
     * @return string
     */
    public function getHighConceptGender()
    {
        return $this->highConceptGender;
    }

    /**
     * @param string $highConceptGender
     */
    public function setHighConceptGender(string $highConceptGender): void
    {
        $this->highConceptGender = $highConceptGender;
    }

    /**
     * @return string
     */
    public function getHighConceptTarget()
    {
        return $this->highConceptTarget;
    }

    /**
     * @param string $highConceptTarget
     */
    public function setHighConceptTarget(string $highConceptTarget): void
    {
        $this->highConceptTarget = $highConceptTarget;
    }

    /**
     * @return ArrayCollection
     */
    public function getProjectHasMedias()
    {
        return $this->projectHasMedias;
    }

    public function setProjectHasMedias($projectHasMedias)
    {
        // Avoid existant projectHasMedias duplication
        $this->projectHasMedias->clear();

        // Loop and assign Entities to this Book
        foreach($projectHasMedias as $projectHasMedia){
            if($projectHasMedia instanceof ProjectHasMedia){
                $this->addProjectHasMedia($projectHasMedia);
            }
        }
    }

    public function addProjectHasMedia(ProjectHasMedia $projectHasMedia) {
        // Add BookHasMedia to array
        $this->projectHasMedias->add($projectHasMedia);
        //Set this to bookHasMedia
        $projectHasMedia->setProject($this);
    }

    /**
     * @return CoverImage
     */
    public function getCoverImage()
    {
        return $this->coverImage;
    }

    /**
     * @param CoverImage $coverImage
     */
    public function setCoverImage(CoverImage $coverImage): void
    {
        $this->coverImage = $coverImage;
    }

}
