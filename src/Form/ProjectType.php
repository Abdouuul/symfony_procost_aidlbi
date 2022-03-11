<?php 

namespace App\Form;
use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void 
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du projet',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description du projet',
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix du projet',
            ])
            ->add('deliveryDate', DateType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text',
            ])
        ;
    } 

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}