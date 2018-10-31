<?php
namespace App\Entity\Sonata;

use App\Entity\Project\Project;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PostHasSong
 * @package App\Entity\Sonata
 *
 * @ORM\Entity()
 */
class ProjectHasMedia extends BaseHasMedia
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Project\Project", inversedBy="projectHasMedias", cascade={"persist"})
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    public function isVideoMedia()
    {
        if($this->getMedia()->getProviderName() === 'sonata.media.provider.custom.image')
            return false;
        return true;
    }


    public function getUrlIfVideoMedia()
    {
        // Store parts of URL
        $media = $this->getMedia();
        $providerUrl = $media->getMetadataValue('provider_url');
        $urlAdd = '';
        $reference =  $media->getProviderReference();

        // Add url requirements if Dailymotion
        if(preg_match('%dailymotion%', $providerUrl)){
            $urlAdd = '/embed/video/';
        }

        // Concat & return
        return $providerUrl
            . $urlAdd
            . $reference;
    }

}
