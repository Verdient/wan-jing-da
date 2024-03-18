<?php

declare(strict_types=1);

namespace Verdient\WanJingDa;

use Verdient\http\Request as HttpRequest;

/**
 * 请求
 * @author Verdient。
 */
class Request extends HttpRequest
{
    /**
     * 客户编号
     * @author Verdient。
     */
    public string|int $customerId;

    /**
     * 客户用户编号
     * @author Verdient。
     */
    public string|int $customerUserId;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function send(): Response
    {
        if (in_array($this->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            $this->addBody('customer_id', $this->customerId);
            $this->addBody('customer_userid', $this->customerUserId);
        } else {
            $this->addQuery('customer_id', $this->customerId);
            $this->addQuery('customer_userid', $this->customerUserId);
        }
        $this->setBody(['param' => json_encode($this->getBody())]);
        return new Response(parent::send());
    }
}
