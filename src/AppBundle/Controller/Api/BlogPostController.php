<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\BlogPost;
use AppBundle\Form\BlogPostType;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @ApiDoc(
     *     section="Blog Post",
     *     description="Create post",
     *     input = {
     *          "class"     = "\ApiBundle\Form\BlogPostType",
     *          "paramType"  = "body"
     *     },
     *     responseMap = {
     *          201     = {
     *              "class" = "AppBundle\Entity\BlogPost"
     *          }
     *     },
     *     statusCodes  = {
     *          201 = "Returned when OK",
     *          401 = "Returned when error occurred"
     *     }
     * )
     *
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @Rest\Post(
     *     name = "api.blog_post.create",
     *     path = "/blog-post/create",
     *     options = {"expose"=true}
     * )
     * @param Request $request
     * @return Response
     */
    public function createPostAction(Request $request)
    {

        $blogPost = new BlogPost();
        $form = $this->createForm(BlogPostType::class,$blogPost);
        $data = json_decode($request->getContent(),true);

        $form->submit($data);

        if($form->isSubmitted()&&$form->isValid()){


            $em=$this->getDoctrine()->getManager();
            $em->persist($blogPost);
            $em->flush();

            //$view = $this->view($subcomment, Response::HTTP_OK);

            return $this->handleView($this->view($blogPost, Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form, Response::HTTP_BAD_REQUEST));
    }
}
