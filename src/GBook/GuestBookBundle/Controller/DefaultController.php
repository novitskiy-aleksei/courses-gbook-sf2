<?php

namespace GBook\GuestBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GBook\GuestBookBundle\Entity\Post;

class DefaultController extends Controller
{
    /**
     * Home page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $posts = $this->get('doctrine.orm.entity_manager')
            ->getRepository('GuestBookBundle:Post')
            ->findAll();

        return $this->render('GuestBookBundle:Default:index.html.twig', array('posts' => $posts));
    }

    /**
     * Post a new post
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function postAction()
    {

        $params = $this->getRequest()->request->all();

        $post = new Post();
        $post->populate($params);

        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($post);
        $em->flush();

        return $this->redirect($this->generateUrl('guest_book_homepage'));
    }
}
