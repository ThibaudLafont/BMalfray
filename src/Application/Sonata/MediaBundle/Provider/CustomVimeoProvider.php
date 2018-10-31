<?php
namespace App\Application\Sonata\MediaBundle\Provider;

use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\VimeoProvider;

class CustomVimeoProvider extends VimeoProvider
{

    use BaseVideoProvider;

    /**
     * @param MediaInterface $media
     */
    protected function fixBinaryContent(MediaInterface $media)
    {
        if (!$media->getBinaryContent()) {
            return;
        }

        if (preg_match(
                "%(http|https)?:\/\/(www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(\d+)(?:|\/\?)%",
                $media->getBinaryContent(),
                $matches
        )) {
            $media->setBinaryContent($matches[4]);
        }
    }

}