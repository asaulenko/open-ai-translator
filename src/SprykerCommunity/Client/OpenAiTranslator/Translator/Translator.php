<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerCommunity\Client\OpenAiTranslator\Translator;

use Generated\Shared\Transfer\AiTranslatorRequestTransfer;
use Generated\Shared\Transfer\AiTranslatorResponseTransfer;
use Generated\Shared\Transfer\OpenAiChatResponseTransfer;
use SprykerCommunity\Client\OpenAiClient\OpenAiClientClientInterface;

class Translator implements TranslatorInterface
{
    /**
     * @var string
     */
    public const INVALID_TRANSLATION_MESSAGE = 'Unable to translate provided text.';

    /**
     * @var string
     */
    protected const OPENAI_PROMPT_TEMPLATE = 'Support me in translating the following text `%s` from %s locale to %s locale(s) for an online shop, ensuring native speaker fluency.
        Generate accurate and contextually fitting translations to enhance the user experience.
        The texts to be translated may contain URLs, URL paths, HTML, unicode characters or some word enclosed by the character "%%", please don\'t translate them.
        IMPORTANT: ONLY RETURN THE TRANSLATED TEXT AND NOTHING ELSE.';

    /**
     * @var \SprykerCommunity\Client\OpenAiClient\OpenAiClientClientInterface
     */
    protected OpenAiClientClientInterface $openAiClient;

    /**
     * @param \SprykerCommunity\Client\OpenAiClient\OpenAiClientClientInterface $openAiClient
     */
    public function __construct(OpenAiClientClientInterface $openAiClient)
    {
        $this->openAiClient = $openAiClient;
    }

    /**
     * @param \Generated\Shared\Transfer\AiTranslatorRequestTransfer $aiTranslatorRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AiTranslatorResponseTransfer
     */
    public function translate(AiTranslatorRequestTransfer $aiTranslatorRequestTransfer): AiTranslatorResponseTransfer
    {
        $openAiChatResponse = $this->openAiClient->chat(
            sprintf(
                static::OPENAI_PROMPT_TEMPLATE,
                $aiTranslatorRequestTransfer->getTextOrFail(),
                $aiTranslatorRequestTransfer->getSourceLocaleOrFail(),
                $aiTranslatorRequestTransfer->getTargetLocale(),
            ),
        );

        return $this->createTranslatorResponse($openAiChatResponse, $aiTranslatorRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OpenAiChatResponseTransfer $openAiChatResponse
     * @param \Generated\Shared\Transfer\AiTranslatorRequestTransfer $aiTranslatorRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AiTranslatorResponseTransfer
     */
    protected function createTranslatorResponse(
        OpenAiChatResponseTransfer $openAiChatResponse,
        AiTranslatorRequestTransfer $aiTranslatorRequestTransfer
    ): AiTranslatorResponseTransfer {
        $aiTranslatorResponseTransfer = (new AiTranslatorResponseTransfer())->setOriginalText($aiTranslatorRequestTransfer->getTextOrFail())
            ->setSourceLocale($aiTranslatorRequestTransfer->getSourceLocaleOrFail())
            ->setTargetLocale($aiTranslatorRequestTransfer->getTargetLocale());
        $aiTranslatorResponseTransfer->setTranslation(
            $openAiChatResponse->getMessage() ?? static::INVALID_TRANSLATION_MESSAGE,
        );

        return $aiTranslatorResponseTransfer;
    }
}
