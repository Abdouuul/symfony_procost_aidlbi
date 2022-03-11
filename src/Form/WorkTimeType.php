<?php 

namespace App\Form;

use App\Entity\WorkTime;
use App\Repository\JobRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class WorkTimeType extends AbstractType
{
    public function __construct(private JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void 
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom'
            ])
        ;
    } 

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkTime::class
        ]);
    }
}