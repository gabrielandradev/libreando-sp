<?php

namespace App\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatalistExtension extends AbstractTypeExtension
{
    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        if (!$options['datalist']) {
            return;
        }

        $datalistId = $view->vars['id'] . '_datalist';
        $view->vars['attr']['list'] = $datalistId;

        $view->vars['datalist_id'] = $datalistId;
        $view->vars['datalist'] = $options['datalist'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['datalist' => []]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [TextType::class];
    }
}