<?php
namespace App\Plate;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use App\Auth\Entity\User;
use App\Auth\Table\UserTable;
use App\Session\SessionInterface;
use Slim\Interfaces\RouterInterface;



class AuthInfo implements ExtensionInterface
{
    /**
     * @var UserTable
     */
    private $userTable;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var User
     */
    private $user = null;
    public function __construct(UserTable $userTable, SessionInterface $session)
    {
        //$this->router = $router;
        $this->userTable = $userTable;
        $this->session = $session;
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('user', [$this, 'user']);
        //$engine->registerFunction('addLink', [$this, 'addLink']);
    }
    /**
     * Permet d'identifier un utilisateur.
     *
     * @param string $username
     * @param string $password
     *
     * @return User|bool
     */
    public function login($username, $password)
    {
        $message = $_SESSION['slimFlash'];
        // On valide les informations
        if (empty($username) || empty($password)) {
            return null;
        }
        // On valide l'utilisateur
        $user = $this->userTable->findByUsername($username);
        //$message = $_SESSION['slimFlash']; 
        
        if ($user && $user->checkPassword($password)) {
            //$this->flashy('Vous etes connecté'); 
            $this->session->set('auth.user', $user->id);
            $this->session->set('auth.username', $user->username);
            $this->session->set('auth.role', $user->role);
            //$this->session->set('auth.avatar', $user->role);
            //$this->session->set('slimFlash', $message); 
            return $user;
        }
        return null;
    }
    /**
     * Récupère un utilisateur depuis la session.
     *
     * @return User|bool
     */
    public function user(): ?User
    {
        if ($this->user) {
            return $this->user;
        }
        $user_id = $this->session->get('auth.user');
        if ($user_id) {
            $user = $this->userTable->find($user_id);
            if ($user) {
                $this->user = $user;
            } else {
                $this->session->delete('auth.user');
            }
        }
        return $this->user;
    }
    /**
     * Déconnecte un utilisateur de l'application.
     */
    public function logout()
    {
        $this->session->delete('auth.user');
        $this->session->delete('auth.username');
        $this->session->delete('auth.role');
        $this->user = null;
    }
}
