<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class BlogPost.
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\BlogPostRepository")
 * @ORM\Table(name="blog_post")
 */
class BlogPost
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min="10")
     */
    private $content;

    /**
     * @var array
     * @ORM\Column(type="json_array")
     */
    private $tags = [];

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BlogPostSocialTarget", mappedBy="blogPost", cascade={"all"})
     */
    protected $socialTargets;


    public function __construct()
    {
        $this->socialTargets = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * Add socialTarget
     *
     * @param BlogPostSocialTarget $socialTarget
     * @return BlogPost
     */
    public function addQuestion(BlogPostSocialTarget $socialTarget)
    {
        $this->socialTargets->add($socialTarget);
        $socialTarget->setBlogPost($this);

        return $this;
    }

    /**
     * Remove socialTarget
     *
     * @param BlogPostSocialTarget $socialTarget
     */
    public function removeQuestion(BlogPostSocialTarget $socialTarget)
    {
        $this->socialTargets->removeElement($socialTarget);
    }

    /**
     * @return ArrayCollection|BlogPostSocialTarget[]
     */
    public function getSocialTargets()
    {
        return $this->socialTargets;
    }
}
