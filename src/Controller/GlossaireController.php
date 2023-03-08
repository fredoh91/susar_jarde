<?php

namespace App\Controller;

use App\Entity\Glossaire;
use App\Form\GlossaireType;
use App\Repository\GlossaireRepository;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// #[Security("is_granted('ROLE_DMFR_ADMIN') or is_granted('ROLE_SURV_ADMIN')")]
// #[IsGranted('ROLE_DMFR_ADMIN')]
// #[IsGranted('ROLE_SURV_ADMIN')]
#[IsGranted(new Expression('is_granted("ROLE_DMFR_ADMIN") or is_granted("ROLE_SURV_ADMIN")'))]
#[Route('/admin_tbref/glossaire')]
class GlossaireController extends AbstractController
{
    #[Route('/', name: 'app_glossaire_index', methods: ['GET'])]
    public function index(GlossaireRepository $glossaireRepository): Response
    {
        return $this->render('admin_tbref/glossaire/index.html.twig', [
            'glossaires' => $glossaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_glossaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GlossaireRepository $glossaireRepository): Response
    {
        $glossaire = new Glossaire();
        $form = $this->createForm(GlossaireType::class, $glossaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $glossaireRepository->save($glossaire, true);

            return $this->redirectToRoute('app_glossaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_tbref/glossaire/new.html.twig', [
            'glossaire' => $glossaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_glossaire_show', methods: ['GET'])]
    public function show(Glossaire $glossaire): Response
    {
        return $this->render('admin_tbref/glossaire/show.html.twig', [
            'glossaire' => $glossaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_glossaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Glossaire $glossaire, GlossaireRepository $glossaireRepository): Response
    {
        $form = $this->createForm(GlossaireType::class, $glossaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $glossaireRepository->save($glossaire, true);

            return $this->redirectToRoute('app_glossaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_tbref/glossaire/edit.html.twig', [
            'glossaire' => $glossaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_glossaire_delete', methods: ['POST'])]
    public function delete(Request $request, Glossaire $glossaire, GlossaireRepository $glossaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$glossaire->getId(), $request->request->get('_token'))) {
            $glossaireRepository->remove($glossaire, true);
        }

        return $this->redirectToRoute('app_glossaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
