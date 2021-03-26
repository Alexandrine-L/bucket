<?php


namespace App\Controller;


use App\Entity\Reaction;
use App\Entity\Wish;
use App\Form\NewCommentType;
use App\Form\NewWishType;
use App\Repository\ReactionRepository;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route ("/un-nouveau-rêve", name="wish_addWish")
     */
    public function addWish(Request $request, EntityManagerInterface $entityManager)
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

            //pas nécessaire car doctrine retourne automatiquement l'id une fois l'instance insérée en BDD
            //$wishToReturn = $wishRepository->findOneBy(['title' => $wish->getTitle()]);
            //$id = $wishToReturn->getId();

            return $this->redirectToRoute("wish_detail", ['id'=> $wish->getId()]);
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
    public function detail($id,
                           WishRepository $wishRepository,
                           Request $request,
                           EntityManagerInterface $entityManager,
                           ReactionRepository $reactionRepository)
    {
        $detail = $wishRepository->find($id);

        $reactions = $reactionRepository->findBy(['wish' => $detail], ['dateCreated' => 'DESC']);

        $reaction = new Reaction();

        $newCommentForm = $this->createForm(NewCommentType::class, $reaction);

        $newCommentForm->handleRequest($request);

        if ($newCommentForm->isSubmitted() and $newCommentForm->isValid()){

            $reaction->setDateCreated(new \DateTime());
            $reaction->setWish($detail);

            $entityManager->persist($reaction);
            $entityManager->flush();

            $this->addFlash('success', 'Votre commentaire a bien été enregistré !');
            return $this->redirectToRoute('wish_detail', ['id' => $id]);
        }

        return $this->render("wish/detail.html.twig", [
            "detail" => $detail,
            "reactions" => $reactions,
            "newCommentForm" => $newCommentForm->createView()
        ]);
    }
}