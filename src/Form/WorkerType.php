<?php 

namespace App\Form;
use App\Entity\Worker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class WorkerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void 
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
            ->add('dailycost', MoneyType::class, [
                'label' => 'Coût journalier'
            ])
        ;
    } 

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Worker::class
        ]);
    }
}