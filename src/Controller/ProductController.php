<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController 
{

    private $products = [];
    public function __construct()
    {
        $this->products = [
            ['name' => 'iphone X', 'slug' => 'iphone-x','description' => 'Un iphone de 2017', 'price' => 999],
            ['name' => 'iphone XR', 'slug' => 'iphone-xr','description' => 'Un iphone de 2018', 'price' => 1099],
            ['name' => 'iphone XS', 'slug' => 'iphone-xs','description' => 'Un iphone de 2018', 'price' => 1199],
        ];
    }
    /**
     * @Route("/product/random", name="product_random")
    */

    public function random() 
    {
        dump($this->products);
        $index = array_rand($this->products);
        $product = $this->products[$index];
        dump($product);
        

        // return new Response('<body>'.$products['name'].'</body>');
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product", name="product_list")
     */
    public function list()
    {
        return $this->render('product/list.html.twig', [
            'products' => $this->products,
        ]);
    }

    /**
     * @Route("/product/create", name="product_create")
     */
    public function create()
    {
        return $this->render('product/create.html.twig');
    }

    /**
     * @Route("/product/{slug}", name="product_show")
     */
    public function show($slug)
    {
        //le slug dans l'url
        dump($slug);
        //liste de produit
        dump($this->products);

        // Parcourir tout nos produits
        foreach($this->products as $product) {
            //on va comparer le slug de chaque produit avec celui de lurl
            if($slug === $product['slug']) {
            dump($product);
            // si un produit existe on retourne le template et on arrete le code
            return $this->render('product/show.html.twig', ['product' => $product]);
           }
        }

        //Aprés avoir parcouru le tableau si aucun produit correspond on affiche la 404
        throw $this->createNotFoundException('le produit n\'existe pas');
    }

    /**
     * @Route("/product/order/{slug}", name="product_order")
     */
    public function order($slug)
    {
        // message flash pour la comma,nde du produit
        $this->addFlash('success', 'Nous avons bien pris en compte votre commande de ' . $slug);

        return $this->redirectToRoute('product_list');
    }
}