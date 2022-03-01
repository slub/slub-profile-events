<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-events
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileEvents\Domain\Model\Dto\Request;

interface RequestUriInterface
{
    /**
     * @return string
     */
    public function getRequestUri(): string;

    /**
     * @param string $requestUri
     */
    public function setRequestUri(string $requestUri = ''): void;
}
