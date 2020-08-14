<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\BlogPost;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class BlogPostController.
 */
class BlogPostController extends FOSRestController
{
    /**
     * @ApiDoc(
     *     section="Blog Post",
     *     description="Return complete list of blog posts"
     * )
     *
     * @Route(name="api.blog_post.list", path="/blog-post")
     * @Method("GET")
     *
     * @return \FOS\RestBundle\View\View
     */
    public function listPostsAction()
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:BlogPost');

        return $this->view($repo->findAll());
    }

    /**
     * @ApiDoc(
     *     section="Blog Post",
     *     description="Publish post to specified target"
     * )
     * @Route(name="api.blog_post.publish", path="/blog-post/{post}/{target}")
     * @Method("POST")
     * @param BlogPost $post
     * @param $target
     *
     * @return \FOS\RestBundle\View\View
     */
    public function publishPostAction(BlogPost $post, $target)
    {
        // todo: implement this

        return $this->view();
    }
}
