<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     **/
    public function index(Request $request, PostRepository $postRepo, UserRepository $userRepo): Response
    {
        $posts = array();

        if ($request->query->has('search')) {
            $search = $request->query->get('search');
            if (strpos($search, '@') === 0) {
                $author = $userRepo->findOneBy(["nickname" => substr($search, 1)]);
                if ($author != NULL) {
                    $posts = $postRepo->findBy(["author" => $author]);
                }
            } else {
                $posts = $postRepo->search($search);
            }
        } else {
            $posts = $postRepo->findAll();
        }
        $data = array(
            "posts" => $posts
        );
        return $this->render('home/index.html.twig', $data);
    }
}
