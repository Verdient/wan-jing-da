<?php

declare(strict_types=1);

namespace Verdient\WanJingDa;

use Verdient\http\Response as HttpResponse;
use Verdient\HttpAPI\AbstractResponse;
use Verdient\HttpAPI\Result;

/**
 * 响应
 * @author Verdient。
 */
class Response extends AbstractResponse
{
    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function normailze(HttpResponse $response): Result
    {
        $result = new Result();
        $body = $response->getBody();
        if (!$body) {
            $body = json_decode(mb_convert_encoding($response->getRawContent(), 'UTF-8', 'GBK'), true)[0];
        }
        if (is_array($body)) {
            $body = $this->decode($body);
        }
        $result->isOK = isset($body['ack']) && $body['ack'] === 'true';
        if ($result->isOK) {
            $result->data = $body;
        } else {
            $result->errorCode = $body['code'] ?? $response->getStatusCode();
            $result->errorMessage = empty($body['message']) ? $response->getStatusMessage() : urldecode($body['message']);
        }
        return $result;
    }

    /**
     * 解码
     * @return array
     * @author Verdient。
     */
    protected function decode(array $data)
    {
        $result = [];
        foreach ($data as $name => $value) {
            if (is_array($value)) {
                $result[$name] = $this->decode($value);
            } else {
                $result[$name] = $value;
            }
        }
        return $result;
    }
}
