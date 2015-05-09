<?php

namespace AppBundle\FormHelper;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\FormInterface;

class ApiEntityExtractor
{
    /** @var RequestStack $requestStack */
    private $requestStack;

    /** @var FormFactoryInterface $formFactory */
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->formFactory = $formFactory;
    }

    /**
     * Return the populated entity if everything is ok,
     * if the data is not valid will throw a FormValidationException
     *
     * @param $formServiceName
     * @param $entityToPopulate
     *
     * @return FormInterface
     */
    public function populateEntityFromRequest($formServiceName, $entityToPopulate, $nameForm = '')
    {
        $form = $this->formFactory->createNamed($nameForm, $formServiceName, $entityToPopulate);

        $form->handleRequest($this->requestStack->getCurrentRequest());

        if( !$form->isSubmitted() ) {
            $form->submit([]);
        }

        return $form;
    }
} 