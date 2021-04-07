<?php

namespace DocumentValidator;

abstract class AbstractValidator
{
    protected $docNumber;

    public function __construct($docNumber)
    {
        $this->docNumber = $docNumber;
    }

    abstract public function isValid(): bool;
    abstract protected function isValidFormat($docNumber): bool;

    /*
     *   This function validates the format of a given string in order to
     *   see if it fits a regexp pattern.
     *
     *   This function is intended to work with Spanish identification
     *   numbers, so it always checks string length (should be 9) and
     *   accepts the absence of leading zeros.
     *
     *   This function returns:
     *       TRUE: If specified string respects the pattern
     *       FALSE: Otherwise
     *
     *   Usage:
     *       echo respectsDocPattern(
     *           '33576428Q',
     *           '/^[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z]/' );
     *   Returns:
     *       TRUE
     */
    protected function respectsDocPattern($givenString, $pattern): bool
    {
        $isValid = FALSE;
        if (is_int(substr($givenString, 0, 1))) {
            $givenString = substr("000000000" . $givenString, -9);
        }
        if (preg_match($pattern, $givenString)) {
            $isValid = TRUE;
        }
        return $isValid;
    }

    /*
     *   This function calculates the check digit for an individual Spanish
     *   identification number (NIF) or first digit parsed NIE document.
     *
     *   You can replace check digit with a zero when calling the function.
     *
     *   This function returns:
     *       - Returns check digit if provided string had a correct NIF structure
     *       - An empty string otherwise
     *
     *   Usage:
     *       echo getPersonalDocumentCheckDigit('335764280')
     *   Returns:
     *       Q
     */
    protected function getPersonalDocumentCheckDigit($docNumber): string
    {
        $keyString = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $position = substr($docNumber, 0, 8) % 23;
        $correctLetter = substr($keyString, $position, 1);
        return $correctLetter;
    }
}
