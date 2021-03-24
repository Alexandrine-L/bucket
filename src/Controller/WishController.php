<?php


namespace App\Controller;


use App\Entity\Wish;
use App\Form\NewWishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route ("/un-nouveau-rêve", name="wish_addWish")
     */
    public function addWish(Request $request, EntityManagerInterface $entityManager, WishRepository $wishRepository)
    {
        $wish = new Wish();

        $newWishForm = $this->createForm(NewWishType::class, $wish);

        $newWishForm->handleRequest($request);

        if ($newWishForm->isSubmitted() AND $newWishForm->isValid()){

            $wish->setDateCreated(new \DateTime());
            $wish->setIsPublished(true);
            $wish->setLikes(0);

            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash("success", "Votre rêve a bien été ajouté!" );

            $wishToReturn = $wishRepository->findOneBy(['title' => $wish->getTitle()]);
            $id = $wishToReturn->getId();

            return $this->redirectToRoute("wish_detail", ['id'=> $id]);
        }

        return $this->render("wish/form.html.twig", [
            "newWishForm" => $newWishForm->createView(),
        ]);
    }

    /**
     * @Route("/rêves/{page}", name="wish_list", requirements={"page": "\d+"})
     */
    public function list(WishRepository $wishRepository, int $page = 1)
    {
        $wishes = $wishRepository->findWishList($page);

        return $this->render("wish/list.html.twig", [
            "wishes" => $wishes,
            "currentPage" => $page,
        ]);
    }

    /**
     * @Route("/rêve{id}", name="wish_detail")
     */
    public function detail($id, WishRepository $wishRepository)
    {
        $detail = $wishRepository->find($id);

        return $this->render("wish/detail.html.twig", [
            "detail" => $detail
        ]);
    }
}