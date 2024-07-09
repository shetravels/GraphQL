<?php
namespace Youshido\GraphQL\Execution\Container;

interface ContainerInterface
{
    /**
     * @param string $id #Service
     * @return mixed
     */
    public function get($id);

    /**
     * @param string $id
     * @return mixed
     */
    public function set($id, mixed $value);

    /**
     * @param string $id
     * @return mixed
     */
    public function remove($id);

    /**
     * @param string $id
     * @return mixed
     */
    public function has($id);

}