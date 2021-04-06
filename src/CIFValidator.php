<?php

namespace DocumentValidator;

use DocumentValidator\AbstractValidator;

class CIFValidator extends AbstractValidator
{
    /*
     *   This function validates a Spanish CIF identification number
     *   verifying its check digits.
     *
     *   This function returns:
     *       TRUE: If specified identification number is correct
     *       FALSE: Otherwise
     *
     *   CIF numbers structure is defined at:
     *       BOE number 49. February 26th, 2008 (article 2)
     * 
     *   Usage:
     *       $validator = new CIFValidator('F43298256');
     *       echo $validator->isValid();
     *   Returns:
     *       TRUE
     */
    public function isValid(): bool
    {
        $isValid = FALSE;
        $fixedDocNumber = "";
        $correctDigit = "";
        $writtenDigit = "";
        $fixedDocNumber = strtoupper($this->docNumber);

        $writtenDigit = substr($fixedDocNumber, -1, 1);
        if ($this->isValidFormat($fixedDocNumber) == 1) {
            $correctDigit = $this->getCheckDigit($fixedDocNumber);
            // if ($this->digitNeedsConversion($this->docNumber)) {
            //     $correctDigit = $this->convertCheckDigit($correctDigit);
            // }
            if ($writtenDigit == $correctDigit) {
                $isValid = TRUE;
            }
        }
        return $isValid;
    }

    /*
     *   This function validates the format of a given string in order to
     *   see if it fits with CIF format. Practically, it performs a validation
     *   over a CIF, but this function does not check the check digit.
     *
     *   This function returns:
     *       TRUE: If specified string respects CIF format
     *       FALSE: Otherwise
     * 
     *   Usage:
     *       echo isValidCIFFormat('H24930836')
     *   Returns:
     *       TRUE
     */
    protected function isValidFormat($docNumber): bool
    {
        return
            $this->respectsDocPattern(
                $docNumber,
                '/^[PQSNWR][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z0-9]/'
            )
            or
            $this->respectsDocPattern(
                $docNumber,
                '/^[ABCDEFGHJUV][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]/'
            );
    }

    /*
     *   This function calculates the digit check for a corporate Spanish
     *   identification number (CIF).
     *
     *   You can replace check digit with a zero when calling the function.
     * 
     *   This function returns:
     *       - The correct check digit if provided string had a
     *         correct CIF structure
     *       - An empty string otherwise
     * 
     *   Usage:
     *       echo getCIFCheckDigit('H24930830');
     *   Prints:
     *       6
     */
    private function getCheckDigit($docNumber)
    {
        $fixedDocNumber = "";
        $centralChars = "";
        $firstChar = "";
        $evenSum = 0;
        $oddSum = 0;
        $totalSum = 0;
        $lastDigitTotalSum = 0;
        $correctDigit = "";
        $fixedDocNumber = strtoupper($docNumber);
        if ($this->isValidFormat($fixedDocNumber)) {
            $firstChar = substr($fixedDocNumber, 0, 1);
            $centralChars = substr($fixedDocNumber, 1, 7);
            $evenSum =
                substr($centralChars, 1, 1) +
                substr($centralChars, 3, 1) +
                substr($centralChars, 5, 1);
            $oddSum =
                $this->sumDigits(substr($centralChars, 0, 1) * 2) +
                $this->sumDigits(substr($centralChars, 2, 1) * 2) +
                $this->sumDigits(substr($centralChars, 4, 1) * 2) +
                $this->sumDigits(substr($centralChars, 6, 1) * 2);
            $totalSum = $evenSum + $oddSum;
            $lastDigitTotalSum = substr($totalSum, -1);
            if ($lastDigitTotalSum > 0) {
                $correctDigit = 10 - ($lastDigitTotalSum % 10);
            } else {
                $correctDigit = 0;
            }
        }

        /* If CIF number starts with P, Q, S, N, W or R,
            check digit should be a letter */
            if (preg_match('/[PQSNWR]/', $firstChar)) {
                $correctDigit = substr("JABCDEFGHI", $correctDigit, 1);
            }
            return $correctDigit;
    }

    /*
     *   This function converts calculated check digit in letter
     * 
     *   Usage:
     *       echo convertCheckDigit(8);
     *   Returns:
     *       'H'
     */
    private function convertCheckDigit($calculatedDigit): string
    {
        return substr("JABCDEFGHI", $calculatedDigit, 1);
    }

    /*
     *   This function checks if CIF number needs conversion to letter
     * 
     *   Usage:
     *       echo digitNeedsConversion('W2849191H');
     *   Returns:
     *       TRUE
     */
    private function digitNeedsConversion($docNumber): bool
    {
        $firstChar = substr($docNumber, 0, 1);
        if (preg_match('/[PQSNWR]/', $firstChar)) {
            return TRUE;
        }
        return FALSE;
    }

    /*
     *   This function performs the sum, one by one, of the digits
     *   in a given quantity.
     *
     *   For instance, it returns 6 for 123 (as it sums 1 + 2 + 3).
     * 
     *   Usage:
     *       echo sumDigits(12345);
     *   Returns:
     *       15
     */
    private function sumDigits($digits)
    {
        $total = 0;
        $i = 1;
        while ($i <= strlen($digits)) {
            $thisNumber = substr($digits, $i - 1, 1);
            $total += $thisNumber;
            $i++;
        }
        return $total;
    }
}
