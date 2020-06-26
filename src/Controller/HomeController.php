<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     **/
    public function index(Request $request, PostRepository $postRepo): Response
    {
        $posts = array();

        if ($request->query->has('search')) {
            $posts = $postRepo->search($request->query->get('search'));
        } else {
            $posts = $postRepo->findAll();
        }
        $data = array(
            "posts" => $posts
        );
        return $this->render('home/index.html.twig', $data);
    }
}
