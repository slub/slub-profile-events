<?php

declare(strict_types=1);

/*
* This file is part of the package slub/slub-profile-events
*
* For the full copyright and license information, please read the
* LICENSE file that was distributed with this source code.
*/

namespace Slub\SlubProfileEvents\Utility;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Exception\SiteNotFoundException;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use UnexpectedValueException;

class LanguageUtility
{
    /**
     * @param int $pageUid
     * @return SiteLanguage
     * @throws AspectNotFoundException
     */
    public static function getSiteLanguage(int $pageUid): SiteLanguage
    {
        $site = self::getSite($pageUid);
        $languageUid = self::getUid();

        return $site->getLanguageById($languageUid);
    }

    /**
     * @return int
     * @throws AspectNotFoundException
     */
    public static function getUid(): int
    {
        /** @var Context $context */
        $context = GeneralUtility::makeInstance(Context::class);

        return (int)$context->getPropertyFromAspect('language', 'id');
    }

    /**
     * @param int $pageUid
     * @return Site
     */
    protected static function getSite(int $pageUid): Site
    {
        /** @var SiteFinder $siteFinder */
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);

        try {
            return $siteFinder->getSiteByPageId($pageUid);
        } catch (SiteNotFoundException $e) {
            throw new UnexpectedValueException(
                'A site not found by "' . $pageUid . '".',
                1490360742
            );
        }
    }
}
