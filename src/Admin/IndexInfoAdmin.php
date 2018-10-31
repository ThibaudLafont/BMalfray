<?php
namespace App\Admin;

use App\Entity\Project\Category;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\Filter\NumberType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class IndexInfoAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        // Build Form
        $formMapper
            ->with('Biographie', ['class' => 'col-md-8'])
                ->add('bioImage', AdminType::class, [
                    'label' => 'Image de la bigraphie'
                ])
                ->add('ldCv', AdminType::class, [
                    'label' => 'CV Level Design'
                ])
                ->add('gdCv', AdminType::class, [
                    'label' => 'CV Game Design'
                ])
                ->add('content', FormatterType::class, [
                    'label' => 'Biographie',
                    'format_field_options' => [
                        'choices' => [
                            'richhtml' => 'richhtml'
                        ],
                        'data' => 'richhtml',
                    ],
                    'source_field'         => 'rawContent',
                    'source_field_options' => [
                        'attr' => [
                            'class' => 'span10',
                            'rows' => 30
                        ],
                    ],
                    'format_field'         => 'contentFormatter',
                    'target_field'         => 'content',
                    'ckeditor_context'     => 'bio',
                    'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher(),
                ])
            ->end()
            ->with('Infos', ['class' => 'col-md-4'])
                ->add('city', TextType::class, [
                    'label' => 'Ville actuelle'
                ])
                ->add('phoneNumber', TextType::class, [
                    'label' => 'Numéro de téléphone'
                ])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        return null;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name', null, ['label' => 'Nom']);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->remove('delete');
    }

    public function toString($object)
    {
        return 'Infos de la homepage';
    }
}
