<?php

/**
 * Created by PhpStorm.
 * User: dangnv
 * Date: 9/27/16
 * Time: 20:46
 */
abstract class UserRole
{
    const ROLE_ADMIN = 'admin';
    const ROLE_EDITOR = 'editor';
    const ROLE_USER = 'user';
    const ROLE_MARKETING = 'marketing';
    const ROLE_GUEST = 'guest';

    public static function getConstants()
    {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }
}