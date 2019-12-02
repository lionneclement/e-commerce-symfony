<?php
namespace App\Service\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {
  protected $session;
  protected $productRepository;
  public function __construct(SessionInterface $session, ProductRepository $productRepository)
  {
    $this->session = $session;
    $this->productRepository = $productRepository;
  }
  public function add(int $id, array $product) {
    $panier = $this->session->get('panier', []);
        if(!empty($panier[$id])){
            $panier[$id]['quantity']+= intval($product['quantity']);
            $panier[$id]['conditionnement'] = floatval($product['conditionnement']);
        }else {
            $panier[$id]['quantity'] = intval($product['quantity']);
            $panier[$id]['conditionnement'] = floatval($product['conditionnement']);
        }
        $this->session->set('panier', $panier);
  }
  public function remove(int $id)
  {
    $panier = $this->session->get('panier',[]);
        if(!empty($panier[$id])){
            unset($panier[$id]);
         }
         $this->session->set('panier',$panier);
  }
  public function getFullCart(): array
  {
    $panier = $this->session->get('panier',[]);
        $panierWithData=[];
        foreach($panier as $id => $product){
            $panierWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity'=> $product['quantity'],
                'conditionnement'=> $product['conditionnement']
            ];
        }
        return $panierWithData;
  }
  public function getTotal() : float
  {
    $total =0;
    foreach($this->getFullCart() as $item){
        $total += $item['product']->getPrice() * $item['quantity'] * $item['conditionnement'];
    }
    return $total;
  }
  
}