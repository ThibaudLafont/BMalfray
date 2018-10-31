<?php
namespace App\Application\Sonata\MediaBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class CoverImageAdmin extends \Sonata\MediaBundle\Admin\GalleryHasMediaAdmin
{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $link_parameters = [];

        if ($this->hasParentFieldDescription()) {
            $link_parameters = $this->getParentFieldDescription()->getOption('link_parameters', []);
        }

        // Limit the type of medias during browsing
        $link_parameters['mediaType'] = 'image';
        $link_parameters['context'] = 'image';

        $formMapper
            ->add('media', ModelListType::class, [
                'required' => false,
                'label' => false
            ], [
                'link_parameters' => $link_parameters,
            ])
            ->add('position', HiddenType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('media')
            ->add('project')
            ->add('position')
            ->add('enabled')
        ;
    }
}
