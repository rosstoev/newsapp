<?php


namespace App\Controller;


use App\Entity\News;
use App\Entity\User;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="news", methods={"GET"})
     * @return Response
     */
    public function create(){
        $newsForm = $this->createForm(NewsType::class);


        return $this->render("news.html.twig",[

            "newsForm"=>$newsForm->createView()
        ]);
    }

    /**
     * @Route("/news", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createProcess(Request $request){
        $news = new News();
        $newsForm = $this->createForm(NewsType::class, $news);
        $newsForm->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $news->setSummary();
            $news->setAuthor($this->getUser());
            $em->persist($news);
            $em->flush();
            return $this->redirectToRoute("all_news");

    }
    /**
     * @Route("/all", name="all_news")
     */

    public function allNews(){

        $em = $this->getDoctrine()->getManager();

        $allNews = $em->getRepository(News::class)->findAll();

        return $this->render("all.html.twig",[
            "allNews" => $allNews
        ]);

    }

    /**
     * @Route("/view/{id}", name="news_view")
     * @param News $news
     * @return Response
     */
    public function viewNews(News $news){

      return $this->render("onenews.html.twig",[
          "news" =>$news
      ]);


    }

    /**
     * @Route("/editNews/{id}", name="edit_news", methods={"GET"})
     * @param News $news
     * @return Response
     */
    public function edit(News $news){

        $form = $this->createForm(NewsType::class,$news);

        return $this->render("editNews.html.twig",[
            "newsForm" => $form->createView()
        ]);
    }

    /**
     * @Route("/editNews/{id}", methods={"POST"})
     * @param News $news
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editProcess(News $news, Request $request){

        $form = $this->createForm(NewsType::class,$news);
        $form->handleRequest($request);
            $em= $this->getDoctrine()->getManager();
            $news->setSummary();
            $news->setAuthor($this->getUser());
            $em->persist($news);
            $em->flush();
            return $this->redirectToRoute("news_view",["id"=>$news->getId()]);


    }

    /**
     * @Route("/delete/{id}", name="delete_news")
     * @param News $news
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeNews(News $news){

        $em = $this->getDoctrine()->getManager();
        $em->remove($news);
        $em->flush();

        return $this->redirectToRoute("all_news");
    }

    /**
     * @Route("/profile",name="profile")
     */

    public function profile(){
        $allUsers = null;
        $hasAccess = $this->isGranted('ROLE_ADMIN');
        if($hasAccess){
            $allUsers= $this->getDoctrine()->getRepository(User::class)->findAll();
        }

        return $this->render('profile.html.twig',[
            'allUsers'=>$allUsers
        ]);

    }

}