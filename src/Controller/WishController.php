<?php


namespace App\Controller;


use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/rêves", name="wish_list")
     */
    public function list(WishRepository $wishRepository)
    {
        $wishes = $wishRepository->findAll();

        return $this->render("wish/list.html.twig", [
            "wishes" => $wishes
        ]);
    }

    /**
     * @Route("/rêve{id}", name="wish_detail")
     */
    public function detail($id)
    {
        return $this->render("wish/detail.html.twig");
    }
}