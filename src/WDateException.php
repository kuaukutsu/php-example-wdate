<?php

namespace kuaukutsu\ExampleWdate;

use LogicException;

/**
 * Class WDateException
 * @package kuaukutsu\ExampleWdate
 */
class WDateException extends LogicException
{
    /**
     * WDateException constructor.
     * @param string $message
     */
    public function __construct($message = 'Datetime not valid')
    {
        parent::__construct($message);
    }
}
