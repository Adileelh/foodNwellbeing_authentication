<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Services\CartServices;
use App\Repository\AddressRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/address')]
class AddressController extends AbstractController
{

    private $addressRepository;

    public function __construct(){

        $this->addressRepository = $addressRepository;
    }

    #[Route('/', name: 'app_address_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('address/index.html.twig', [
            'addresses' => $addressRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_address_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CartServices $cartServices): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $address->setUser($user);
            $addressRepository->add($address);
            return $this->redirectToRoute('app_address_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('address/new.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_address_show', methods: ['GET'])]
    public function show(Address $address): Response
    {
        return $this->render('address/show.html.twig', [
            'address' => $address,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_address_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Address $address): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addressRepository->add($address);
            return $this->redirectToRoute('app_address_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('address/edit.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_address_delete', methods: ['POST'])]
    public function delete(Request $request, Address $address): Response
    {
        if ($this->isCsrfTokenValid('delete'.$address->getId(), $request->request->get('_token'))) {
            $addressRepository->remove($address);
        }

        return $this->redirectToRoute('app_address_index', [], Response::HTTP_SEE_OTHER);
    }
}
