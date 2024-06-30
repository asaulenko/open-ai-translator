<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerCommunity\Client\OpenAiTranslator\Plugin\AiTranslator;

use Generated\Shared\Transfer\AiTranslatorRequestTransfer;
use Generated\Shared\Transfer\AiTranslatorResponseTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use SprykerCommunity\Client\AiTranslator\Dependency\Plugin\TranslatorEnginePluginInterface;

/**
 * @method \SprykerCommunity\Client\OpenAiTranslator\OpenAiTranslatorClientInterface getClient()
 */
class OpenAiTranslatorEnginePlugin extends AbstractPlugin implements TranslatorEnginePluginInterface
{
    /**
     * {@inheritDoc}
     * - Translates text using OpenAI engine.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AiTranslatorRequestTransfer $aiTranslatorRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AiTranslatorResponseTransfer
     */
    public function translate(AiTranslatorRequestTransfer $aiTranslatorRequestTransfer): AiTranslatorResponseTransfer
    {
        return $this->getClient()->translate($aiTranslatorRequestTransfer);
    }

    public function fooBar(): void
    {
        $a = 5;
        $b = 10;
        $c = 7;

        if ($a < $b) {
            $c = 12;
        }
    }
}
