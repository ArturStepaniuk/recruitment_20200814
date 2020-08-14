<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Enum\BlogPostSocialTargetEnum;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Exception\TargetNotExistsException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class BlogPostSocialTarget.
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\BlogPostSocialTargetRepository")
 * @ORM\Table(name="blog_post_social_target")
 */

class BlogPostSocialTarget
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var BlogPost
     *
     * @ORM\ManyToOne(targetEntity="BlogPost", inversedBy="socialTargets")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $blogPost;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Choice(callback={"AppBundle\Entity\Enum\BlogPostSocialTargetEnum", "getAvailableSocialTarget"})
     */
    protected $target;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set survey
     *
     * @param BlogPost|null $blogPost
     * @return BlogPostSocialTarget
     */
    public function setBlogPost(BlogPost $blogPost = null)
    {
        $this->blogPost = $blogPost;

        return $this;
    }

    /**
     * Get survey
     *
     * @return BlogPost
     */
    public function getBlogPost()
    {
        return $this->blogPost;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function setTarget($target)
    {
        if (!in_array($target, BlogPostSocialTargetEnum::getAvailableSocialTarget())) {
            throw new TargetNotExistsException(sprintf("Invalid social target %s",$target));
        }

        $this->target = $target;

        return $this;
    }
}