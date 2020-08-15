<?php


namespace AppBundle\EventListener\Event;


use AppBundle\Entity\BlogPost;
use Symfony\Component\EventDispatcher\Event;

class BlogPostSocialTargetEvent extends Event
{
    const NAME = 'blogpost.social.target';

    /**
     * @var BlogPost
     */
    protected $blogPost;

    public function __construct(BlogPost $blogPost)
    {
        $this->blogPost = $blogPost;
    }

    public function getBlogPost()
    {
        return $this->blogPost;
    }
}
