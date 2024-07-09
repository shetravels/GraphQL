<?php
/**
 * Date: 26.11.15
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\GraphQL\Exception;


use Youshido\GraphQL\Exception\Interfaces\LocationableExceptionInterface;
use Youshido\GraphQL\Parser\Location;

class ResolveException extends \Exception implements LocationableExceptionInterface
{

    public function __construct($message, private readonly ?\Youshido\GraphQL\Parser\Location $location = null)
    {
        parent::__construct($message);
    }


    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }
}
