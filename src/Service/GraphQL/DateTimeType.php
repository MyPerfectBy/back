<?php
namespace App\Service\GraphQL;

use GraphQL\Language\AST\Node;

class DateTimeType
{
    /**
     * @param \DateTime $value
     *
     * @return string
     */
    public static function serialize(\DateTime $value)
    {
        if($value){
            return $value->format(DATE_ATOM);
        }
        else{
            return null;
        }
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public static function parseValue($value)
    {
        return $value ? new \DateTime($value) : null;
    }

    /**
     * @param Node $valueNode
     *
     * @return string
     */
    public static function parseLiteral($valueNode)
    {
        return $valueNode->value ? new \DateTime($valueNode->value) : null;
    }
}