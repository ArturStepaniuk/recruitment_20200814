<?php


namespace AppBundle\Manager\BlogPost;


use AppBundle\Entity\BlogPost;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;

class BlogPostManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function __construct(
        EntityManager $em,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return BlogPost
     */
    public function createNewInstance()
    {
        return new BlogPost();
    }

    /**
     * @param FormInterface $form
     * @throws \Exception
     */
    public function createBlogPostByForm(FormInterface $form)
    {
        $this->em->beginTransaction();
        try {
            $blogPost = $form->getData();
            $this->em->persist($blogPost);
            $this->em->flush();
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        }

        return $blogPost;
    }

}