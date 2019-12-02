<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartService)
    {
        return $this->render('cart/index.html.twig', [
            'items' =>$cartService->getFullCart(),
            'total' => $cartService->getTotal()
            ]);
    }
    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id,Request $request,CartService $cartService)
    { 
        $cartService->add($id, $request->query->get('product'));
        return $this->redirectToRoute("cart_index");
    }
    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);
         return $this->redirectToRoute("cart_index");
    }
}