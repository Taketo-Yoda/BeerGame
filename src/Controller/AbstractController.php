<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Psr\Log\LogLevel;

abstract class AbstractController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Auth', ['className' => 'CustomAuth']);
        $this->loadComponent('Str', ['className' => 'CommonStr']);
        $this->loadComponent('Dttm', ['className' => 'CommonDateTime']);
        $this->Auth->allow(['Login']);

    }

    protected function flashError(string $errorCode): void
    {
        $this->Flash->error(__($errorCode));
        $this->log(__($errorCode), LogLevel::ERROR);
    }

    protected function infolog(string $messageCode): void
    {
        $this->log(__($messageCode), LogLevel::INFO);
    }

}
