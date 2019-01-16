<?php

namespace Istok\IstokBundle\Extension;

/**
 * Class JsonDecode
 * @package AppBundle\Twig\Extension
 * @author Kegan VanSickle <keganv@keganv.com>
 */
class VarsExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'twig.json_decode';
    }
    public function getFilters()
    {
        return array(
            'json_decode'   => new \Twig_Filter_Method($this, 'jsonDecode')
        );
    }
    public function jsonDecode($string)
    {
        return json_decode($string);
    }
}