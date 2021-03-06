<?php

namespace Hyper\AdsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Hyper\AdsBundle\DBAL\ZoneType as ZType;
use Doctrine\ORM\EntityRepository;

class ZoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'name', 'translation_domain' => 'HyperAdsBundle'))
            ->add(
                'enabled',
                'choice',
                array(
                    'choices' => array(
                        1 => 'yes',
                        0 => 'no'
                    ),
                    'label' => 'enabled',
                    'translation_domain' => 'HyperAdsBundle',
                )
            )
            ->add('dailyPrice', 'money', array('label' => 'daily.price', 'translation_domain' => 'HyperAdsBundle'))
            ->add('maxBanners', 'integer', array('label' => 'max.banners', 'translation_domain' => 'HyperAdsBundle'))
            ->add('maxWidth', 'integer', array('label' => 'max.width', 'translation_domain' => 'HyperAdsBundle'))
            ->add('maxHeight', 'integer', array('label' => 'max.height', 'translation_domain' => 'HyperAdsBundle'))
            ->add(
                'type',
                'choice',
                array(
                    'label' => 'type',
                    'translation_domain' => 'HyperAdsBundle',
                    'choices' => Ztype::getValidTypesWithLabels()
                )
            )
            ->add(
                'page',
                'entity',
                array(
                    'class' => 'HyperAdsBundle:Page',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                            ->orderBy('p.name', 'ASC');
                    },
                    'label' => 'page',
                    'translation_domain' => 'HyperAdsBundle'
                )
            );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Hyper\AdsBundle\Entity\Zone'
            )
        );
    }

    public function getName()
    {
        return 'hyper_adsbundle_zonetype';
    }
}
