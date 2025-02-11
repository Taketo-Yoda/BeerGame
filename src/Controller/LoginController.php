<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Login Controller
 *
 */
class LoginController extends AbstractController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        if ($this->request->is('post')) {
            $account = $this->request->getData('account');
            $password = $this->request->getData('password');
            if ($this->Str->isNullOrEmpty($account) || $this->Str->isNullOrEmpty($password)) {
                $this->flashError('E00001');
                return;
            };

            $users = TableRegistry::getTableLocator()->get('Users');
            $user = $users->get($account);
            
            if ($user?->password !== hash('sha256', $password)) {
                $this->flashError('E00002');
                return;
            } else {
                $this->infoLog('Login:'.$account);
                $this->Auth->setUser($user);
                $user->login();
                $users->save($user);
                $this->getRequest()->getSession()->write('User.nickname', $user->nickname);
                return $this->redirect($this->Auth->redirectUrl());
            }

        }
    }

}
