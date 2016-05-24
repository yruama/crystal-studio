<?php

namespace Lib;
 
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\DBAL\Connection;
use Entities;

class UserProvider implements UserProviderInterface
{
    private $conn;
 
    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }
 
    //The username will be the email adress
    public function loadUserByUsername($login)
    {

        $stmt = $this->conn->executeQuery('SELECT * FROM t_user WHERE login = "'.$login.'"');
        if (!$user = $stmt->fetch()) {
            throw new UsernameNotFoundException(sprintf('Email "%s" does not exist.', $email));
        }    
        return new User($user['login'], $user['password'], explode(',', $user['role']), true, true, true, true);
    }
 
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
 
        return $this->loadUserByUsername($user->getUsername());
    }
 
    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }


    public function findByProviderUid($provider, $providerUid)
    {
        $auth = new Entities\Authentication($this->conn);
        return $auth->findByProviderUid($provider, $providerUid);
    }  
    
    public function findByUserId($userId)
    {
        $auth = new Entities\Authentication($this->conn);
        return $auth->findByUserId($userId);        
    }

    public function createFromSocialNetwork($data, $role = 'ROLE_USER')
    { 
        $user = new Entities\User($this->conn);
        return $user->createFromSocialNetwork($data);
    }


    public function createAuthentication($data)
    {
        $auth = new Entities\Authentication($this->conn);
        return $auth->create($data);
    }


    public function findByEmail($email)
    {
        $user = new Entities\User($this->conn);
        return $user->findByEmail($email)->getData();
    }
}