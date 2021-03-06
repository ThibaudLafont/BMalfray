<?php
namespace App\Application\Sonata\MediaBundle\Provider;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\MediaBundle\Model\MediaInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

trait BaseVideoProvider
{
    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper)
    {
        $formMapper->add('name');
        $formMapper->add('description');
        $formMapper->add('binaryContent', TextType::class, ['required' => false]);
    }

    public function prePersist(MediaInterface $media)
    {
        parent::prePersist($media); // TODO: Change the autogenerated stub
        $media->setContext('default');
    }

}