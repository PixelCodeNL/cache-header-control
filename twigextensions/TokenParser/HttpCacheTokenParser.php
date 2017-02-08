<?php

namespace Craft;

use Twig_Token;

class HttpCacheTokenParser extends \Twig_TokenParser
{
    /**
     * @inheritdoc
     */
    public function parse(Twig_Token $token)
    {
        $setCache = craft()->cacheHeaderControl->getConfig('enableCache');
        $lineNumber = $token->getLine();
        $value = $this->parser->getStream()->getCurrent()->getValue();
        if ($value === '') {
            $value = craft()->cacheHeaderControl->getConfig('defaultCacheExpiration');
        } elseif ($value === 'false') {
            $this->parser->getStream()->expect(\Twig_Token::NAME_TYPE);
            $setCache = false;
        } else {
            $this->parser->getStream()->expect(\Twig_Token::STRING_TYPE);
        }
        $expiration = null;
        if ($setCache && !empty($value)) {
            $parsedTime = strtotime($value);
            if ($parsedTime !== false && $parsedTime > -1) {
                $expiration = $parsedTime - time();
            }
        } elseif (!$setCache) {
            $expiration = -1;
        }

        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);

        return new HttpCacheNode(
            [],
            ['expiration' => $expiration],
            $lineNumber,
            $this->getTag()
        );
    }

    /**
     * @inheritdoc
     */
    public function getTag()
    {
        return 'http_cache';
    }
}
