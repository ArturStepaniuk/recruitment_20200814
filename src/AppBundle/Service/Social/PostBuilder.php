<?php


namespace AppBundle\Service\Social;


abstract class PostBuilder
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