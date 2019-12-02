<?php

namespace App\Controller;

use App\Form\ProductDescriptionType;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{

  private $productRepository;

  public function __construct(ProductRepository $productRepository)
  {
    $this->productRepository = $productRepository;
  }

  /**
   * @Route("/",name="homepage")
   */
  public function index()
  {
    $products = $this->productRepository->findAll();
    return $this->render('Product/index.html.twig',['products'=>$products]);
  }

  /**
   * @Route("/product/{id}",name="product_description")
   */
  public function productDescription($id, Request $request)
  {
    $form = $this->createForm(ProductDescriptionType::class);
    $form->handleRequest($request);
    $product = $this->productRepository->find($id);

    if($form->isSubmitted() && $form->isValid()){
        return $this->redirectToRoute('cart_add', [
          'id'=>$id,
          'product'=> $request->request->get('product_description')
      ]);
    }
    
    return $this->render('Product/description.html.twig',[
      'product'=>$product,
      'form' =>$form->createView()
      ]);
  }
  
}