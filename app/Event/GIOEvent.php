<?php
namespace JSantos\Event;

use Symfony\Component\EventDispatcher\Event;

class GIOEvent extends Event
{
    /**
     * @var string
     */
    protected $eventName = '';

    /**
     * @return string
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @param string $eventName
     */
    public function setEventName(string $eventName)
    {
        $this->eventName = $eventName;
    }
}