<?php


namespace AppBundle\Service\Social;


abstract class Post
{
    /**
     * @var object[]
     */
    private $data = [];

    public function setPostData($key, $value)
    {
        $this->data[$key] = $value;
    }
}