<?php
/**
 * Date: 23.11.15
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\GraphQL\Parser\Ast;


use Youshido\GraphQL\Parser\Location;

class Fragment extends AbstractAst
{

    use AstDirectivesTrait;

    /** @var Field[]|Query[] */
    protected $fields;

    /** @var bool */
    private $used = false;

    /**
     * @param string          $name
     * @param string          $model
     * @param array           $directives
     * @param Field[]|Query[] $fields
     * @param Location        $location
     */
    public function __construct(protected $name, protected $model, array $directives, array $fields, Location $location)
    {
        parent::__construct($location);
        $this->fields = $fields;
        $this->setDirectives($directives);
    }

    /**
     * @return boolean
     */
    public function isUsed()
    {
        return $this->used;
    }

    /**
     * @param boolean $used
     */
    public function setUsed($used)
    {
        $this->used = $used;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function setName(mixed $name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    public function setModel(mixed $model)
    {
        $this->model = $model;
    }

    /**
     * @return Field[]|Query[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param Field[]|Query[] $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }
}