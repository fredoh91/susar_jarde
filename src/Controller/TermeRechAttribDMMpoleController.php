<?php

namespace App\Controller;

use App\Entity\TermeRechAttribDMMpole;
use App\Form\TermeRechAttribDMMpoleType;
use App\Repository\TermeRechAttribDMMpoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Security("is_granted('ROLE_DMFR_ADMIN') or is_granted('ROLE_SURV_ADMIN')")]
#[Route('/admin_tbref/terme_rech_attrib_dmmpole')]
class TermeRechAttribDMMpoleController extends AbstractController
{
    #[Route('/', name: 'app_terme_rech_attrib_d_m_mpole_index', methods: ['GET'])]
    public function index(TermeRechAttribDMMpoleRepository $termeRechAttribDMMpoleRepository): Response
    {
        return $this->render('admin_tbref/terme_rech_attrib_dm_mpole/index.html.twig', [
            'terme_rech_attrib_d_m_mpoles' => $termeRechAttribDMMpoleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_terme_rech_attrib_d_m_mpole_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TermeRechAttribDMMpoleRepository $termeRechAttribDMMpoleRepository): Response
    {
        $termeRechAttribDMMpole = new TermeRechAttribDMMpole();
        $form = $this->createForm(TermeRechAttribDMMpoleType::class, $termeRechAttribDMMpole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $termeRechAttribDMMpoleRepository->save($termeRechAttribDMMpole, true);

            return $this->redirectToRoute('app_terme_rech_attrib_d_m_mpole_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_tbref/terme_rech_attrib_dm_mpole/new.html.twig', [
            'terme_rech_attrib_d_m_mpole' => $termeRechAttribDMMpole,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_terme_rech_attrib_d_m_mpole_show', methods: ['GET'])]
    public function show(TermeRechAttribDMMpole $termeRechAttribDMMpole): Response
    {
        return $this->render('admin_tbref/terme_rech_attrib_dm_mpole/show.html.twig', [
            'terme_rech_attrib_d_m_mpole' => $termeRechAttribDMMpole,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_terme_rech_attrib_d_m_mpole_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TermeRechAttribDMMpole $termeRechAttribDMMpole, TermeRechAttribDMMpoleRepository $termeRechAttribDMMpoleRepository): Response
    {
        $form = $this->createForm(TermeRechAttribDMMpoleType::class, $termeRechAttribDMMpole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $termeRechAttribDMMpoleRepository->save($termeRechAttribDMMpole, true);

            return $this->redirectToRoute('app_terme_rech_attrib_d_m_mpole_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_tbref/terme_rech_attrib_dm_mpole/edit.html.twig', [
            'terme_rech_attrib_d_m_mpole' => $termeRechAttribDMMpole,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_terme_rech_attrib_d_m_mpole_delete', methods: ['POST'])]
    public function delete(Request $request, TermeRechAttribDMMpole $termeRechAttribDMMpole, TermeRechAttribDMMpoleRepository $termeRechAttribDMMpoleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$termeRechAttribDMMpole->getId(), $request->request->get('_token'))) {
            $termeRechAttribDMMpoleRepository->remove($termeRechAttribDMMpole, true);
        }

        return $this->redirectToRoute('app_terme_rech_attrib_d_m_mpole_index', [], Response::HTTP_SEE_OTHER);
    }
}
