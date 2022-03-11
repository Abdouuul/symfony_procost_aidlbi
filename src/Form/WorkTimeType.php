<?php 

namespace App\Form;

use App\Entity\WorkTime;
use App\Repository\JobRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkTimeType extends AbstractType
{
    public function __construct(private JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void 
    {
        $builder
            ->add('project', ChoiceType::class, [
                'label' => 'Projet concenré',
                'choices' => $this->jobRepository->findAll(),
                'choice_label' => 'name',
            ])
            ->add('days', NumberType::class, [
                'label' => 'Nombre de jours'
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