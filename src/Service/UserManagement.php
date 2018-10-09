<?php

namespace App\Service;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserManagement{

  public function createUser($data, UserPasswordEncoderInterface $passwordEncoder){

    $userdata = json_decode($data, true);

    $user = new User();

    $role = $userdata[0]['value'];
    $username = $userdata[1]['value'];
    $plainPassword = $userdata[2]['value'];
    $password = $passwordEncoder->encodePassword($user, $plainPassword);
    $email = $userdata[3]['value'];



    $user->setUsername($username);
    $user->setPassword($password);
    $user->setEmail($email);
    $user->setIsActive(true);

    switch($role){
        case 'user':
        $user->setRoles(array('ROLE_USER'));
        break;
        case 'admin':
        $user->setRoles(array('ROLE_ADMIN'));
        break;
        case 'modder':
        $user->setRoles(array('ROLE_MODDER'));
        break;
        case 'contributor':
        $user->setRoles(array('ROLE_CONTRIBUTOR'));
        break;
        default:
        $user->setRoles(array('ROLE_USER'));
    }

    return $user;

  }

}
