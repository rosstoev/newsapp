<?php


namespace App\Controller\Testing;


use App\Entity\Category;
use App\Entity\News;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\Event;

class TestController extends AbstractController
{
    /**
     * @Route("/directCreate", name="direct_create")
     * @return Response
     */
    public function directCreate () :Response
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $this->randomCategory(2);

        $news = new News();
        $news->setTitle('New news')
            ->setContent("This is new news with random category")
            ->getSummary();
        foreach ($categories as $category){
            $news->getCategories()->add($category);

        }
        $em->persist($news);
        $em->flush();

        return new Response("Save new news article with id ".$news->getId());
    }

    /**
     * @Route("/directEdit/{id}", name="direct_edit")
     * @param News $news
     * @return Response
     */
    public function directEdit(News $news){
        $changedTitle = "S promenenoto zaglavie";
        $changedContent = "Promenenoto sudurjanie";
        $categories = $this->randomCategory(2);
        $news->setTitle($changedTitle);
        $news->setContent($changedContent);
        $news->setCategories($categories);
        $news->setAuthor($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->persist($news);
        $em->flush();
        return new Response('Successfully you edit news with id '.$news->getId());
    }

    /**
     * @Route("/directDelete/{id}", name="direct_delete")
     * @param News $news
     * @return Response
     */

    public function directDelete(News $news){
        $lastId = $news->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($news);
        $em->flush();

        return new Response("You successfully deleted news with id " . $lastId);
    }

    /**
     * @Route("/directDeleteCat/{id}", name="direct_view")
     * @param Category $category
     * @return Response
     */
    public function directDeleteCat(Category $category){

        $em = $this->getDoctrine()->getManager();
        foreach ($category->getCategoryNews() as $news){
            $em->remove($news);
        }
        $em->remove($category);
        $em->flush();
        return new Response('You delete this category '.$category->getCatName().' and his news');
    }


    public function randomCategory(int $maxCat){
        $categories = [];
        $categoryRep = $this->getDoctrine()->getRepository(Category::class);
        $allCat = $categoryRep->findAll();
        $currentId = null;
        while (count($categories) < $maxCat){
            $randNumber = rand(1,count($allCat));
            if($randNumber != $currentId){
                $currentId = $categoryRep->find($randNumber)->getId();
                $category = $categoryRep->find($randNumber);
                $categories[] = $category;
            }


        }

        return $categories;

    }

    /**
     * @Route("/directRemoveUser/{id}", name="d_remove_user")
     * @param User $user
     * @return Response
     */
    public function directRemoveUser(User $user){
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return new Response('Succesfully remove user with id ' . $user->getFullName());
    }


}