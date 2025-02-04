<?php


namespace App\Form;


use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options){

            $builder->add("title", TextType::class)
                    ->add("content",TextareaType::class)
                    ->add("categories", EntityType::class,[
                        'class' => Category::class,
                        'choice_label' => 'cat_name',
                        'multiple' => true,
                        'expanded' => true
                    ])
                    ->add("save",SubmitType::class);

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\News',
        ]);
    }

}