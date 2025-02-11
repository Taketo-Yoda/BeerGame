<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Top Controller
 *
 */
class TopController extends AbstractController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->set('isAdmin', $this->Auth->isAdmin());
        $this->set('account', $this->Auth->User('account'));
    }

}
