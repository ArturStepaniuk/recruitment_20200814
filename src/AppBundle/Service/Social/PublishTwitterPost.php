<?php


namespace AppBundle\Service\Social;


class PublishTwitterPost implements Social
{
    private $twitterPost;

    public function setTitle($title)
    {
        $this->twitterPost->setPostData('content',$title);
    }

    public function setContent($content)
    {
        $this->twitterPost->setPostData('content',$content);
    }

    public function createSocialPost()
    {
        $this->twitterPost = new TwitterPostBuilder();
    }

    public function getSocialPost()
    {
        return $this->twitterPost;
    }

    public function publishPost()
    {
        // TODO: Implement publishPost() method.
    }
}