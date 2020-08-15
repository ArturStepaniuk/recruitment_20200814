<?php


namespace AppBundle\Service\Social;


interface Social
{
    public function createSocialPost();
    public function setTitle($title);
    public function setContent($content);
    public function getSocialPost();
    public function publishPost();
}