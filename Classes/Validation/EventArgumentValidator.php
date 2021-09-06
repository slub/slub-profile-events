<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-events
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileEvents\Validation;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class EventArgumentValidator
{
    protected array $validArguments;

    /**
     * @param array $arguments
     * @return array
     */
    public function validateArguments(array $arguments): array
    {
        $this->validateCommaSeparatedStringIds('category', $arguments['category']);
        $this->validateCommaSeparatedStringIds('discipline', $arguments['discipline']);
        $this->validateCommaSeparatedStringIds('contact', $arguments['contact']);
        $this->validateChecked('showPastEvents', $arguments['showPastEvents']);
        $this->validateChecked('showEventsFromNow', $arguments['showEventsFromNow']);
        $this->validateInteger('limitByNextWeeks', $arguments['limitByNextWeeks']);
        $this->validateStartAndStopTimestamp($arguments['startTimestamp'], $arguments['stopTimestamp']);
        $this->validateSorting('sorting', $arguments['sorting']);
        $this->validateInteger('limit', $arguments['limit']);

        return $this->validArguments;
    }

    /**
     * @param string $start
     * @param string $stop
     */
    protected function validateStartAndStopTimestamp($start = '', $stop = ''): void
    {
        if ((int)$start > 0 && (int)$stop > 0) {
            $this->validArguments['startTimestamp'] = $start;
            $this->validArguments['stopTimestamp'] = $stop;
        }
    }

    /**
     * Take a comma separated list and check that all values are integer.
     * Remove values who are not.
     *
     * @param string $key
     * @param string $value
     */
    protected function validateCommaSeparatedStringIds($key = '', $value = ''): void
    {
        $validValues = [];
        $values = GeneralUtility::trimExplode(',', $value);

        if (count($values) > 0) {
            foreach ($values as $id) {
                (int)$id === 0 ?: $validValues[] = $id;
            }
        }

        count($validValues) === 0 ?: $this->validArguments[$key] = implode(',', $validValues);
    }

    /**
     * Just allow "1" as value.
     *
     * @param string $key
     * @param string $value
     */
    protected function validateChecked($key = '', $value = ''): void
    {
        $value === '1' ? $this->validArguments[$key] = $value : null;
    }

    /**
     * @param string $key
     * @param string $value
     */
    protected function validateInteger($key = '', $value = ''): void
    {
        empty($value) ?: $this->validArguments[$key] = (int)$value;
    }

    /**
     * Just allow (asc|desc)
     *
     * @param string $key
     * @param string $value
     */
    protected function validateSorting($key = '', $value = ''): void
    {
        in_array($value, ['asc', 'desc']) ? $this->validArguments[$key] = $value : null;
    }
}
