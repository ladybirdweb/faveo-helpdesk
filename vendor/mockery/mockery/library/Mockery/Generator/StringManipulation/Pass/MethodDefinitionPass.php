<?php

/**
 * Mockery (https://docs.mockery.io/)
 *
 * @copyright https://github.com/mockery/mockery/blob/HEAD/COPYRIGHT.md
 * @license   https://github.com/mockery/mockery/blob/HEAD/LICENSE BSD 3-Clause License
 * @link      https://github.com/mockery/mockery for the canonical source repository
 */

namespace Mockery\Generator\StringManipulation\Pass;

use Mockery\Generator\Method;
use Mockery\Generator\Parameter;
use Mockery\Generator\MockConfiguration;

class MethodDefinitionPass implements Pass
{
    public function apply($code, MockConfiguration $config)
    {
        foreach ($config->getMethodsToMock() as $method) {
            if ($method->isPublic()) {
                $methodDef = 'public';
            } elseif ($method->isProtected()) {
                $methodDef = 'protected';
            } else {
                $methodDef = 'private';
            }

            if ($method->isStatic()) {
                $methodDef .= ' static';
            }

            $methodDef .= ' function ';
            $methodDef .= $method->returnsReference() ? ' & ' : '';
            $methodDef .= $method->getName();
            $methodDef .= $this->renderParams($method, $config);
            $methodDef .= $this->renderReturnType($method);
            $methodDef .= $this->renderMethodBody($method, $config);

            $code = $this->appendToClass($code, $methodDef);
        }

        return $code;
    }

    protected function renderParams(Method $method, $config)
    {
        $class = $method->getDeclaringClass();
        if ($class->isInternal()) {
            $overrides = $config->getParameterOverrides();

            if (isset($overrides[strtolower($class->getName())][$method->getName()])) {
                return '(' . implode(',', $overrides[strtolower($class->getName())][$method->getName()]) . ')';
            }
        }

        $methodParams = array();
        $params = $method->getParameters();
        $isPhp81 = \PHP_VERSION_ID >= 80100;
        foreach ($params as $param) {
            $paramDef = $this->renderTypeHint($param);
            $paramDef .= $param->isPassedByReference() ? '&' : '';
            $paramDef .= $param->isVariadic() ? '...' : '';
            $paramDef .= '$' . $param->getName();

            if (!$param->isVariadic()) {
                if (false !== $param->isDefaultValueAvailable()) {
                    $defaultValue = $param->getDefaultValue();

                    if (is_object($defaultValue)) {
                        $prefix = get_class($defaultValue);
                        if ($isPhp81) {
                            if (enum_exists($prefix)) {
                                $prefix = var_export($defaultValue, true);
                            } elseif (
                                !$param->isDefaultValueConstant() &&
                                // "Parameter #1 [ <optional> F\Q\CN $a = new \F\Q\CN(param1, param2: 2) ]
                                preg_match(
                                    '#<optional>\s.*?\s=\snew\s(.*?)\s]$#',
                                    $param->__toString(),
                                    $matches
                                ) === 1
                            ) {
                                $prefix = 'new ' . $matches[1];
                            }
                        }
                    } else {
                        $prefix = var_export($defaultValue, true);
                    }

                    $paramDef .= ' = ' . $prefix;
                } elseif ($param->isOptional()) {
                    $paramDef .= ' = null';
                }
            }

            $methodParams[] = $paramDef;
        }
        return '(' . implode(', ', $methodParams) . ')';
    }

    protected function renderReturnType(Method $method)
    {
        $type = $method->getReturnType();

        return $type ? sprintf(': %s', $type) : '';
    }

    protected function appendToClass($class, $code)
    {
        $lastBrace = strrpos($class, "}");
        $class = substr($class, 0, $lastBrace) . $code . "\n    }\n";
        return $class;
    }

    protected function renderTypeHint(Parameter $param)
    {
        $typeHint = $param->getTypeHint();

        return $typeHint === null ? '' : sprintf('%s ', $typeHint);
    }

    private function renderMethodBody($method, $config)
    {
        $invoke = $method->isStatic() ? 'static::_mockery_handleStaticMethodCall' : '$this->_mockery_handleMethodCall';
        $body = <<<BODY
{
\$argc = func_num_args();
\$argv = func_get_args();

BODY;

        // Fix up known parameters by reference - used func_get_args() above
        // in case more parameters are passed in than the function definition
        // says - eg varargs.
        $class = $method->getDeclaringClass();
        $class_name = strtolower($class->getName());
        $overrides = $config->getParameterOverrides();
        if (isset($overrides[$class_name][$method->getName()])) {
            $params = array_values($overrides[$class_name][$method->getName()]);
            $paramCount = count($params);
            for ($i = 0; $i < $paramCount; ++$i) {
                $param = $params[$i];
                if (strpos($param, '&') !== false) {
                    $body .= <<<BODY
if (\$argc > $i) {
    \$argv[$i] = {$param};
}

BODY;
                }
            }
        } else {
            $params = array_values($method->getParameters());
            $paramCount = count($params);
            for ($i = 0; $i < $paramCount; ++$i) {
                $param = $params[$i];
                if (!$param->isPassedByReference()) {
                    continue;
                }
                $body .= <<<BODY
if (\$argc > $i) {
    \$argv[$i] =& \${$param->getName()};
}

BODY;
            }
        }

        $body .= "\$ret = {$invoke}(__FUNCTION__, \$argv);\n";

        if (! in_array($method->getReturnType(), ['never', 'void'], true)) {
            $body .= "return \$ret;\n";
        }

        $body .= "}\n";
        return $body;
    }
}
