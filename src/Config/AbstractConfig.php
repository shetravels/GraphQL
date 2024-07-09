<?php
/*
* This file is a part of graphql-youshido project.
*
* @author Alexandr Viniychuk <a@viniychuk.com>
* created: 11/27/15 2:31 AM
*/

namespace Youshido\GraphQL\Config;


use Youshido\GraphQL\Exception\ConfigurationException;
use Youshido\GraphQL\Exception\ValidationException;
use Youshido\GraphQL\Validator\ConfigValidator\ConfigValidator;

/**
 * Class Config
 *
 * @package Youshido\GraphQL\Config
 */
abstract class AbstractConfig
{

    /**
     * @var array
     */
    protected $data = [];

    protected $extraFieldsAllowed = null;

    /**
     * TypeConfig constructor.
     *
     * @param array $configData
     * @param bool  $finalClass
     *
     * @throws ConfigurationException
     * @throws ValidationException
     */
    public function __construct(array $configData, protected mixed $contextObject = null, protected $finalClass = false)
    {
        if (empty($configData)) {
            throw new ConfigurationException('Config for Type should be an array');
        }
        $this->data          = $configData;

        $this->build();
    }

    public function validate()
    {
        $validator = ConfigValidator::getInstance();

        if (!$validator->validate($this->data, $this->getContextRules(), $this->extraFieldsAllowed)) {
            throw new ConfigurationException('Config is not valid for ' . ($this->contextObject ? $this->contextObject::class : null) . "\n" . implode("\n", $validator->getErrorsArray(false)));
        }
    }

    public function getContextRules()
    {
        $rules = $this->getRules();
        if ($this->finalClass) {
            foreach ($rules as $name => $info) {
                if (!empty($info['final'])) {
                    $rules[$name]['required'] = true;
                }
            }
        }

        return $rules;
    }

    abstract public function getRules();

    public function getName()
    {
        return $this->get('name');
    }

    public function getType()
    {
        return $this->get('type');
    }

    public function getData()
    {
        return $this->data;
    }

    public function getContextObject()
    {
        return $this->contextObject;
    }

    public function isFinalClass()
    {
        return $this->finalClass;
    }

    public function isExtraFieldsAllowed()
    {
        return $this->extraFieldsAllowed;
    }


    /**
     * @return null|callable
     */
    public function getResolveFunction()
    {
        return $this->get('resolve', null);
    }

    protected function build()
    {
    }

    /**
     * @param      $key
     * @param null $defaultValue
     *
     * @return mixed|null|callable
     */
    public function get($key, $defaultValue = null)
    {
        return $this->has($key) ? $this->data[$key] : $defaultValue;
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    public function __call($method, $arguments)
    {
        if (str_starts_with((string) $method, 'get')) {
            $propertyName = lcfirst(substr((string) $method, 3));
        } elseif (str_starts_with((string) $method, 'set')) {
            $propertyName = lcfirst(substr((string) $method, 3));
            $this->set($propertyName, $arguments[0]);

            return $this;
        } elseif (str_starts_with((string) $method, 'is')) {
            $propertyName = lcfirst(substr((string) $method, 2));
        } else {
            throw new \Exception('Call to undefined method ' . $method);
        }

        return $this->get($propertyName);
    }


}
