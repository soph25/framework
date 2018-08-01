<?php
namespace App\Auth\Action;


use Framework\Events\Event;
use App\Auth\User;



class OnLoginEvent extends Event
{

      


      public function __construct(User $userlogged)
    {
        $this->setName('database.auth.login');
        $this->setTarget($userlogged);
        
    }

}
