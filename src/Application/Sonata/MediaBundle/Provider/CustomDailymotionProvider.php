<?php
namespace App\Application\Sonata\MediaBundle\Provider;

use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\DailyMotionProvider;

class CustomDailymotionProvider extends DailyMotionProvider
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

        if (preg_match("%(?:dailymotion\.com\/|dai\.ly)(?:video|hub)?\/([0-9a-z]+)%", $media->getBinaryContent(), $matches)) {
            $media->setBinaryContent($matches[1]);
        }
    }
}