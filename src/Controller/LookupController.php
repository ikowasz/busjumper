<?php

namespace App\Controller;

use App\Form\LookupFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LookupController extends AbstractController
{
    #[Route('/lookup', name: 'app_lookup')]
    public function index(
        Request $request,
    ): Response
    {
        $form = $this->createForm(LookupFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // Process the data
            // For example, you can save it to the database or perform some action

            return $this->redirectToRoute('app_lookup');
        }

        return $this->render('lookup/index.html.twig', [
            'form' => $form,
        ]);
    }
}
