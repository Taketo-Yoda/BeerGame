<?php
declare(strict_types=1);
namespace App\Controller\Component;

use App\Model\Entity\User;
use Cake\Controller\Component\AuthComponent;
use Cake\Controller\Controller;
use Cake\Core\Exception\CakeException;
use Cake\Http\Response;

class CustomAuthComponent extends AuthComponent
{
    /**
     * Sets defaults for configs.
     *
     * @return void
     */
    protected function _setDefaults(): void
    {
        $defaults = [
            'authenticate' => ['Form'],
            'loginAction' => [
                'controller' => 'login',
                'action' => 'index',
                'plugin' => null,
            ],
            'logoutRedirect' => $this->_config['loginAction'],
        ];

        $config = $this->getConfig();
        foreach ($config as $key => $value) {
            if ($value !== null) {
                unset($defaults[$key]);
            }
        }
        $this->setConfig($defaults);
    }

    /**
     * Handles unauthenticated access attempt. First the `unauthenticated()` method
     * of the last authenticator in the chain will be called. The authenticator can
     * handle sending response or redirection as appropriate and return `true` to
     * indicate no further action is necessary. If authenticator returns null this
     * method redirects user to login action.
     *
     * @param \Cake\Controller\Controller $controller A reference to the controller object.
     * @return \Cake\Http\Response|null Null if current action is login action
     *   else response object returned by authenticate object or Controller::redirect().
     * @throws \Cake\Core\Exception\CakeException
     */
    protected function _unauthenticated(Controller $controller): ?Response
    {
        if (empty($this->_authenticateObjects)) {
            $this->constructAuthenticate();
        }
        $response = $controller->getResponse();
        $auth = end($this->_authenticateObjects);
        if ($auth === false) {
            throw new CakeException('At least one authenticate object must be available.');
        }
        $result = $auth->unauthenticated($controller->getRequest(), $response);
        if ($result !== null) {
            return $result instanceof Response ? $result : null;
        }

        if (!$controller->getRequest()->is('ajax')) {
            return $controller->redirect($this->_loginActionRedirectUrl());
        }

        return $response->withStatus(403);
    }

    public function isAdmin(): bool
    {
        return $this->user('auth_name') === "admin";
    }
}