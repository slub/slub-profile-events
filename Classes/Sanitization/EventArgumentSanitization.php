<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-events
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileEvents\Sanitization;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class EventArgumentSanitization
{
    protected array $sanitizedArguments = [];

    /**
     * @param array $arguments
     * @return array
     */
    public function sanitizeDefaultArguments(array $arguments): array
    {
        if (count($arguments) > 0) {
            $this->sanitizeCommaSeparatedStringIds('category', $arguments['category']);
            $this->sanitizeCommaSeparatedStringIds('discipline', $arguments['discipline']);
            $this->sanitizeCommaSeparatedStringIds('contact', $arguments['contact']);
            $this->sanitizeChecked('showPastEvents', $arguments['showPastEvents']);
            $this->sanitizeChecked('showEventsFromNow', $arguments['showEventsFromNow']);
            $this->sanitizeInteger('limitByNextWeeks', $arguments['limitByNextWeeks']);
            $this->sanitizeStartAndStopTimestamp($arguments['startTimestamp'], $arguments['stopTimestamp']);
            $this->sanitizeSorting('sorting', $arguments['sorting']);
            $this->sanitizeInteger('limit', $arguments['limit']);
        }

        return $this->sanitizedArguments;
    }

    /**
     * @param array $arguments
     * @return array
     */
    public function sanitizeUserArguments(array $arguments): array
    {
        if (count($arguments) === 0) {
            return ['user' => 0];
        }

        $this->sanitizeDefaultArguments($arguments);
        $this->sanitizeInteger('user', $arguments['user']);

        return $this->sanitizedArguments;
    }

    /**
     * @param string $start
     * @param string $stop
     */
    protected function sanitizeStartAndStopTimestamp(string $start = '', string $stop = ''): void
    {
        if ((int)$start > 0 && (int)$stop > 0) {
            $this->sanitizedArguments['startTimestamp'] = $start;
            $this->sanitizedArguments['stopTimestamp'] = $stop;
        }
    }

    /**
     * Take a comma separated list and check that all values are integer.
     * Remove values who are not.
     *
     * @param string $key
     * @param string $value
     */
    protected function sanitizeCommaSeparatedStringIds(string $key = '', string $value = ''): void
    {
        $sanitizedValues = [];
        $values = GeneralUtility::trimExplode(',', $value);

        if (count($values) > 0) {
            foreach ($values as $id) {
                (int)$id === 0 ?: $sanitizedValues[] = $id;
            }
        }

        count($sanitizedValues) === 0 ?: $this->sanitizedArguments[$key] = implode(',', $sanitizedValues);
    }

    /**
     * Just allow "1" as value.
     *
     * @param string $key
     * @param string $value
     */
    protected function sanitizeChecked(string $key = '', string $value = ''): void
    {
        if ($value === '1') {
            $this->sanitizedArguments[$key] = $value;
        }
    }

    /**
     * @param string $key
     * @param string $value
     */
    protected function sanitizeInteger(string $key = '', string $value = ''): void
    {
        empty($value) ?: $this->sanitizedArguments[$key] = (int)$value;
    }

    /**
     * Just allow (asc|desc)
     *
     * @param string $key
     * @param string $value
     */
    protected function sanitizeSorting(string $key = '', string $value = ''): void
    {
        if (in_array($value, ['asc', 'desc'])) {
            $this->sanitizedArguments[$key] = $value;
        }
    }
}
