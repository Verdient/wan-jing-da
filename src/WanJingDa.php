<?php

declare(strict_types=1);

namespace Verdient\WanJingDa;

use Verdient\http\parser\JsonParser;
use Verdient\http\serializer\body\UrlencodedBodySerializer;
use Verdient\HttpAPI\AbstractClient;

/**
 * 万境达
 * @author Verdient。
 */
class WanJingDa extends AbstractClient
{
    /**
     * 客户编号
     * @author Verdient。
     */
    protected string|int $customerId;

    /**
     * 客户用户编号
     * @author Verdient。
     */
    protected string|int $customerUserId;

    /**
     * 代理主机
     * @author Verdient。
     */
    protected string|null $proxyHost = null;

    /**
     * 代理端口
     * @author Verdient。
     */
    protected int|string|null $proxyPort = null;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $request = Request::class;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function request($path): Request
    {
        /** @var Request */
        $request = parent::request($path);
        $request->customerId = $this->customerId;
        $request->customerUserId = $this->customerUserId;
        if ($this->proxyHost) {
            $request->setProxy($this->proxyHost, empty($this->proxyPort) ? null : intval($this->proxyPort));
        }
        $request->setBodySerializer(UrlencodedBodySerializer::class);
        $request->setParser(JsonParser::class);
        return $request;
    }
}
