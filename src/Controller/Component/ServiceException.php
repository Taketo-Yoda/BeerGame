<?php
declare(strict_types=1);
namespace App\Controller\Component;

use Cake\Core\Exception\Exception;

/**
 * ServiceException
 */
class ServiceException extends Exception
{
    public $errorCode;
    public $errorMsg;

    public function __constract($errorCode, $errorMsg = null, $code = 0, Throwable $previous = null) {
        $this->errorCode = $errorCode;
        $this->errorMsg = is_null($errorMsg) ? __($this->errorCode) : $errorMsg;
        parentt::__construct($this->errorMsg, $code, $previous);
    }
}