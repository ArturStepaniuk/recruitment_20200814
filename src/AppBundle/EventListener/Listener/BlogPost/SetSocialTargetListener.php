<?php


namespace AppBundle\EventListener\Listener\BlogPost;


use AppBundle\Entity\Enum\BlogPostSocialTargetEnum;
use AppBundle\EventListener\Event\BlogPostSocialTargetEvent;
use AppBundle\Exception\TargetNotExistsException;
use AppBundle\Service\Social\BlogPostSocial;
use AppBundle\Service\Social\FacebookPost;
use AppBundle\Service\Social\TwitterPost;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Event;

class SetSocialTargetListener
{
    /** @var  EntityManagerInterface */
    protected $em;
    /**
     * @var array
     */
    protected $appSettings;

    /**
     * UserProfileUpdated constructor.
     * @param EntityManagerInterface $em
     * @param array $appSettings
     */
    public function __construct(EntityManagerInterface $em, array $appSettings)
    {
        $this->em = $em;
        $this->appSettings = $appSettings;
    }

    /**
     * @param Event $event
     * @throws TargetNotExistsException
     */
    public function publishPost(Event $event)
    {
        if (!($event instanceof BlogPostSocialTargetEvent)) {
            throw new \UnexpectedValueException(sprintf(
                'Expected %s, got %s',
                BlogPostSocialTargetEvent::class,
                get_class($event)
            ));
        }

        $blogPost = $event->getBlogPost();
        $socialTargets = $blogPost->getSocialTargets();
        $lastTarget = end($socialTargets);

        dump($lastTarget);
        die();

        switch (true){
            case ($lastTarget === BlogPostSocialTargetEnum::facebook):
                $socialPost = new FacebookPost();
                break;
            case ($lastTarget === BlogPostSocialTargetEnum::twitter):
                $socialPost = new TwitterPost();
                break;
            default:
                throw new TargetNotExistsException(sprintf("Invalid social target %s",$lastTarget));
                break;
        }

        (new BlogPostSocial($this->appSettings))->setBlogPost($blogPost)->publish($socialPost);

    }
}