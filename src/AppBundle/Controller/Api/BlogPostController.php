<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\BlogPost;
use AppBundle\Form\BlogPostType;
use AppBundle\Manager\BlogPost\BlogPostManager;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormInterface;
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
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route(name="api.blog_post.publish", path="/blog-post/{post}/{target}")
     * @Method("POST")
     * @param BlogPost $post
     * @param $target
     *
     * @param BlogPostManager $blogPostManager
     * @return \FOS\RestBundle\View\View
     */
    public function publishPostAction(BlogPost $post, $target,BlogPostManager $blogPostManager)
    {
        $blogPost = $this->getDoctrine()
            ->getRepository(BlogPost::class)
            ->find($post);



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
     *          400 = "Returned when error occurred"
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
     * @param BlogPostManager $blogPostManager
     * @return Response
     * @throws \Exception
     */
    public function createPostAction(Request $request, BlogPostManager $blogPostManager)
    {

        $blogPost = $blogPostManager->createNewInstance();
        $form = $this->createForm(BlogPostType::class,$blogPost);
        $data = json_decode($request->getContent(),true);

        $form->submit($data);

        return $this->handleEditForm($form, $blogPostManager, $request);
    }

    /**
     * @ApiDoc(
     *     section="Blog Post",
     *     description="Edit post",
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
     *          400 = "Returned when error occurred"
     *     }
     * )
     *
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @Rest\Put(
     *     name = "api.blog_post.edit",
     *     path = "/blog-post/{post}/edit",
     *     options = {"expose"=true}
     * )
     * @param Request $request
     * @param BlogPost $post
     * @param BlogPostManager $blogPostManager
     * @return Response
     * @throws \Exception
     */
    public function editPostAction(Request $request, BlogPost $post, BlogPostManager $blogPostManager)
    {

        $blogPost = $this->getDoctrine()
            ->getRepository(BlogPost::class)
            ->find($post);

        $form = $this->createForm(BlogPostType::class,$blogPost);
        $data = json_decode($request->getContent(),true);

        $form->submit($data);

        return $this->handleEditForm($form, $blogPostManager, $request);
    }

    /**
     * @param FormInterface $form
     * @param Request|null $request
     * @return Response
     * @throws \Exception
     */
    protected function handleEditForm(FormInterface $form, BlogPostManager $blogPostManager, Request $request = null)
    {
        if($form->isSubmitted()&&$form->isValid()){

            try {
                $blogPost = $blogPostManager->createBlogPostByForm($form);
                return $this->handleView($this->view($blogPost, Response::HTTP_CREATED));
            } catch (\Exception $e) {
                return $this->handleView($this->view($e, Response::HTTP_BAD_REQUEST));
            }

        }
        return $this->handleView($this->view($form, Response::HTTP_BAD_REQUEST));
    }

}
