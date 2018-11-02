<?php

namespace App\Form;

use App\Entity\Contract;
use App\Entity\Interim;
use App\Entity\Status;
use App\Repository\InterimRepository;
use App\Repository\StatusRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $status = new Status();

        $builder
            ->add('interim', EntityType::class, array(
                'class' => Interim::class,
                'query_builder' => function(InterimRepository $er) {
                  return $er->createQueryBuilder('u');
                },
                'choice_label' => 'name',
                'required'	    => true,
            ))
            ->add('startAt',DateType::class, array(
                'placeholder' => array(
                    'année' => 'Year',
                    'mois' => 'Month',
                    'jour' => 'Day'),
                'required'	    => true,
                'label'	    => 'start_at'))
            ->add('endAt',DateType::class, array(
                'placeholder' => array(
                    'année' => 'Year',
                    'mois' => 'Month',
                    'jour' => 'Day'),
                'required'	    => true,
                'label'	    => 'end_at'))
            ->add('status', EntityType::class, array(
                'class' => Status::class,
                'query_builder' => function (StatusRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.id<=3');
                },
                'choice_label' => 'name',
            ));
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contract::class,
        ]);
    }
}
