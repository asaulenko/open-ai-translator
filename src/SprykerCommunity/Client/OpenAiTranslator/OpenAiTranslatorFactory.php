<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerCommunity\Client\OpenAiTranslator;

use Spryker\Client\Kernel\AbstractFactory;
use SprykerCommunity\Client\OpenAiClient\OpenAiClientClientInterface;
use SprykerCommunity\Client\OpenAiTranslator\Translator\Translator;
use SprykerCommunity\Client\OpenAiTranslator\Translator\TranslatorInterface;

class OpenAiTranslatorFactory extends AbstractFactory
{
    /**
     * @return \SprykerCommunity\Client\OpenAiTranslator\Translator\TranslatorInterface
     */
    public function createTranslator(): TranslatorInterface
    {
        return new Translator(
            $this->getOpenAiClientClient(),
        );
    }

    /**
     * @return \SprykerCommunity\Client\OpenAiClient\OpenAiClientClientInterface
     */
    public function getOpenAiClientClient(): OpenAiClientClientInterface
    {
        return $this->getProvidedDependency(OpenAiTranslatorDependencyProvider::CLIENT_OPEN_AI_CLIENT);
    }
}
