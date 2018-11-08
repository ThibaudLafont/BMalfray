<?php
namespace App\EventListener;

use App\Entity\Media\Local\Explanation;
use App\Service\Sluggifier;
use App\Service\Uploader;

/**
 * Class Project
 *
 * Execute actions when Doctrine work with Messages entities
 *
 * @package AppBundle\EventListener
 */
class Project
{
    /**
     * @var Sluggifier
     */
    private $sluggifier;

    public function __construct(Sluggifier $sluggifier)
    {
        $this->setSluggifier($sluggifier);
    }

    public function prePersist(\App\Entity\Project\Project $project) {
        $this->removeNullPHM($project);
    }

    public function preFlush(\App\Entity\Project\Project $project) {

        $project->setSlugName(
            $this->getSluggifier()->sluggify($project->getName())
        );

        $this->removeNullPHM($project);

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

    private function removeNullPHM($project){
        foreach ($project->getProjectHasMedias() as $hMedia){
            if($hMedia->getMedia() === null){
                $project->getProjectHasMedias()->removeElement($hMedia);
            }
        }
    }

}
