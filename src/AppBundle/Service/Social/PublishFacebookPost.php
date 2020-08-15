<?php


namespace AppBundle\Service\Social;


class PublishFacebookPost implements Social
{
    private $facebookPost;

    public function setTitle($title)
    {
        $this->facebookPost->setPostData('content',$title);
    }

    public function setContent($content)
    {
        $this->facebookPost->setPostData('content',$content);
    }

    public function createSocialPost()
    {
        $this->facebookPost = new FacebookPostBuilder();
    }

    public function getSocialPost()
    {
        return $this->facebookPost;
    }

    public function publishPost()
    {
        // TODO: Implement publishPost() method.
    }
}