<?php


namespace AppBundle\Service\Social;


use AppBundle\Entity\BlogPost;

class BlogPostSocial
{
    /**
     * @var array
     */
    protected $appSettings;
    /**
     * @var BlogPost
     */
    private $blogPost;

    public function __construct(array $appSettings)
    {
        $this->appSettings = $appSettings;
    }

    public function setBlogPost(BlogPost $blogPost){
        $this->blogPost = $blogPost;
        return $this;
    }

    public function publish(Social $social)
    {
        $social->createSocialPost();
        $social->setTitle($this->blogPost->getTitle());
        $social->setContent($this->blogPost->getContent());

        $social->publishPost();

        return $this;
    }
}