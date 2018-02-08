<?php
namespace App\Form;

use App\Entity\Photo;
use App\Entity\Project;
use App\Form\ProjectType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Title'))
            ->add('text', TextType::class, array('label' => 'Text', 'required' => false))
            ->add('image', FileType::class, array('label' => 'Photo (Image file)'))
            ->add('project', EntityType::class, array(

                'class' => Project::class,

                'choice_label' => 'title',
                'choice_value' => 'id'
            ))
            ->add('save', SubmitType::class, array('label' => 'Upload Photo'))
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Photo::class,
        ));
    }
}