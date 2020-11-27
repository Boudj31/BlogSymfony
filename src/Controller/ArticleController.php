<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/last", name="article_last", methods={"GET"})
     */
    public function last(ArticleRepository $articleRepository) {

        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findLast(),
        ]);

    }
    /**
     * @Route("/lastArticle", name="article_last_article", methods={"GET"})
     */
    public function lastArticle(ArticleRepository $articleRepository) {

        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findLastArticle(),
        ]);

    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        $article = new Article();

        if($this->getUser()->getAuthor() === null) {
            $this->addFlash('warning', 'Vous devez renseigner votre profil');

            return $this->redirectToRoute('edit_profile', ['id' => $this->getUser()->getId() ]);
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setAuthor($this->getUser()->getAuthor());
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', $translator->trans('article.new.success', ['%title%' => $article->getTitle()]));

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('ARTICLE_EDIT', $article);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUpdateAt(new\DateTime());
            $entityManager->flush();

            $this->addFlash('success', $translator->trans('article.new.success', ['%title%' => $article->getTitle()]));

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
