<?php

namespace App\Controller;

use App\Entity\Ligne;
use App\Form\LigneType;
use App\Repository\LigneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(LigneRepository $repo, Request $request,EntityManagerInterface $em): Response
    {
        $ligne = new Ligne();
        $formLigne = $this->createForm(LigneType::class,$ligne);
        $formLigne->handleRequest($request);
        if ($formLigne->isSubmitted()) {
            $em->persist($ligne);
            $em->flush();
            unset($formLigne);
            unset($ligne);
            $ligne = new Ligne();
            $formLigne = $this->createForm(LigneType::class,$ligne);
        }
        $listLigne = $repo->findAll();
        $totalHt = 0;
        foreach ($listLigne as $ligne) {
            $totalHt += $ligne->getTotal();
        }
        $totalTva = $totalHt *20 /100;
        $totalTtc = $totalHt + $totalTva;
        return $this->render('main/index.html.twig', [
            'listLigne'=> $listLigne,
            'totalHt' => $totalHt,
            'totalTva' => $totalTva,
            'totalTtc' => $totalTtc,
            'formLigne' => $formLigne->createView()
        ]);
    }

    /**
     * @Route("/effacerLigne/{id}", name="effacer_ligne")
     */
    public function effacerLigne(LigneRepository $repo, $id): Response
    {
        $ligne = $repo->findOneBy(
            [
                'id'=>$id
            ]
        );
        $em = $this->getDoctrine()->getManager();
        $em->remove($ligne);
        $em->flush();
        return $this->redirectToRoute('index');
    }
}
