<?php


namespace AppBundle\Manager\BlogPost;


use AppBundle\Entity\BlogPost;
use AppBundle\Entity\BlogPostSocialTarget;
use AppBundle\EventListener\Event\BlogPostSocialTargetEvent;
use AppBundle\Exception\TargetNotExistsException;
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
     * @return mixed
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


    /**
     * @param FormInterface $form
     * @return mixed
     * @throws \Exception
     */
    public function setSocialTargetBlogPostByForm(FormInterface $form)
    {
        $this->em->beginTransaction();
        try {
            $postSocialTarget = $form->getData();

            $this->em->persist($postSocialTarget);
            $this->em->flush();
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        }

        return $postSocialTarget;
    }

    /**
     * @param BlogPost $blogPost
     * @param $target
     * @return BlogPost
     * @throws \Exception
     */
    public function setSocialTargetBlogPost(BlogPost $blogPost, $target)
    {
        $this->em->beginTransaction();
        try {

            $postSocialTarget = new BlogPostSocialTarget();
            $postSocialTarget->setTarget($target);
            $postSocialTarget->setBlogPost($blogPost);

            $this->em->persist($postSocialTarget);
            $this->em->flush();
            $this->em->commit();

            $this->eventDispatcher->dispatch(
                BlogPostSocialTargetEvent::NAME,
                new BlogPostSocialTargetEvent($blogPost)
            );

        } catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        }

        return $blogPost;
    }


}