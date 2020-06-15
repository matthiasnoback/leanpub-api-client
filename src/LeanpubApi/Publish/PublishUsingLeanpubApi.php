<?php
declare(strict_types=1);

namespace LeanpubApi\Publish;

use Assert\Assert;
use Http\Message\RequestFactory;
use LeanpubApi\Common\ApiKey;
use LeanpubApi\Common\BaseUrl;
use LeanpubApi\Common\BookSlug;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Safe\Exceptions\JsonException;
use function Safe\json_decode;

final class PublishUsingLeanpubApi implements Publish
{
    private BookSlug $bookSlug;

    private ApiKey $apiKey;

    private BaseUrl $baseUrl;

    private ClientInterface $httpClient;

    private RequestFactory $requestFactory;

    public function __construct(
        BookSlug $bookSlug,
        ApiKey $apiKey,
        BaseUrl $leanpubApiBaseUrl,
        ClientInterface $httpClient,
        RequestFactory $requestFactory
    ) {
        $this->bookSlug = $bookSlug;
        $this->apiKey = $apiKey;
        $this->baseUrl = $leanpubApiBaseUrl;
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
    }

    private static function assertSuccessResponse(ResponseInterface $response): void
    {
        $responseBody = $response->getBody()->getContents();

        try {
            $responseData = json_decode($responseBody, true);
        } catch (JsonException $exception) {
            throw CouldNotPublishNewVersion::invalidJsonResponse($responseBody);
        }

        if (!$responseData['success'] || $responseData['success'] !== true) {
            throw CouldNotPublishNewVersion::unknownReason();
        }
    }

    public function publishNewVersion(): void
    {
        $response = $this->httpClient->sendRequest(
            $this->requestFactory->createRequest(
                'POST',
                sprintf(
                    '%s/%s/publish.json',
                    $this->baseUrl->asString(),
                    $this->bookSlug->asString()
                ),
                [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                http_build_query(
                    [
                        'api_key' => $this->apiKey->asString(),
                    ]
                )
            )
        );

        self::assertSuccessResponse($response);
    }

    public function publishNewVersionAndEmailReaders(string $emailMessage): void
    {
        Assert::that(trim($emailMessage))
            ->notEmpty('When emailing your readers the email message should not be empty');

        $response = $this->httpClient->sendRequest(
            $this->requestFactory->createRequest(
                'POST',
                sprintf(
                    '%s/%s/publish.json',
                    $this->baseUrl->asString(),
                    $this->bookSlug->asString()
                ),
                [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                http_build_query(
                    [
                        'api_key' => $this->apiKey->asString(),
                        'publish[email_readers]' => 'true',
                        'publish[release_notes]' => $emailMessage
                    ]
                )
            )
        );

        self::assertSuccessResponse($response);
    }
}
