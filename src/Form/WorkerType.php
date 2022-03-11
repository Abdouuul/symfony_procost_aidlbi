<?php 

namespace App\Form;
use App\Entity\Worker;
use App\Repository\JobRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class WorkerType extends AbstractType
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
            ->add('lastName', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
            ->add('dailycost', MoneyType::class, [
                'label' => 'Coût journalier'
            ])
            ->add('job', ChoiceType::class, [
                'choices' => $this->jobRepository->findAll(),
                'choice_label' => 'name',
                'label' => 'Métier',
            ])
            ->add('employedAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'embauche'
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