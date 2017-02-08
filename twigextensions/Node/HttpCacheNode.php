<?php

namespace Craft;

class HttpCacheNode extends \Twig_Node
{
    /**
     * @inheritdoc
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $expiration = $this->getAttribute('expiration');

        if ($expiration) {
            $compiler->write('\Craft\HeaderHelper::setExpires(' . $expiration . ');');
        }
    }
}
