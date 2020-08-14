<?php

namespace AppBundle\Entity\Enum;


abstract class BlogPostSocialTargetEnum
{
    const facebook = 'facebook';
    const twitter = 'twitter';

    protected static $typeName = [
        self::facebook    => 'facebook',
        self::twitter => 'twitter',
    ];

    /**
     * @param  string $targetName
     * @return string
     */
    public static function getTargatName($targetName)
    {
        if (!isset(static::$typeName[$targetName])) {
            return "Unknown type ($targetName)";
        }

        return static::$typeName[$targetName];
    }

    /**
     * @return array<string>
     */
    public static function getAvailableSocialTarget()
    {
        return [
            self::facebook,
            self::twitter
        ];
    }

    public static function getTargetGlossary()
    {
        return [
            self::facebook  => self::facebook,
            self::twitter => self::twitter
        ];
    }
}