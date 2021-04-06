<?php

namespace DocumentValidator;

use DocumentValidator\AbstractValidator;

class NIFValidator extends AbstractValidator
{
    /*
     *   This function validates a Spanish NIF identification number
     *   verifying its check digits.
     *
     *   This function returns:
     *       TRUE: If specified identification number is correct
     *       FALSE: Otherwise
     *
     *   Algorithm works as described in:
     *       http://www.interior.gob.es/es/web/servicios-al-ciudadano/dni/calculo-del-digito-de-control-del-nif-nie
     *
     *   Usage:
     *       $validator = new NIFValidator('33576428Q');
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
        if (!preg_match("/^[A-Z]+$/i", substr($fixedDocNumber, 1, 1))) {
            $fixedDocNumber = strtoupper(substr("000000000" . $this->docNumber, -9));
        } else {
            $fixedDocNumber = strtoupper($this->docNumber);
        }
        $writtenDigit = strtoupper(substr($this->docNumber, -1, 1));
        if ($this->isValidFormat($fixedDocNumber)) {
            $correctDigit = $this->getCheckDigit($fixedDocNumber);
            if ($writtenDigit == $correctDigit) {
                $isValid = TRUE;
            }
        }
        return $isValid;
    }
    /*
     *   This function validates the format of a given string in order to
     *   see if it fits with NIF format. Practically, it performs a validation
     *   over a NIF, except this function does not check the check digit.
     *
     *   This function returns:
     *       TRUE: If specified string respects NIF format
     *       FALSE: Otherwise
     * 
     *   Usage:
     *       echo isValidFormat('33576428Q')
     *   Returns:
     *       TRUE
     */
    protected function isValidFormat($docNumber): bool
    {
        return $this->respectsDocPattern(
            $docNumber,
            '/^[KLM0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][a-zA-Z0-9]/'
        );
    }
    /*
     *   This function calculates the check digit for an individual Spanish
     *   identification number (NIF).
     *
     *   You can replace check digit with a zero when calling the function.
     *
     *   This function returns:
     *       - Returns check digit if provided string had a correct NIF structure
     *       - An empty string otherwise
     *
     *   Usage:
     *       echo getCheckDigit('335764280')
     *   Returns:
     *       Q
     */
    private function getCheckDigit($docNumber): string
    {
        $keyString = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $fixedDocNumber = "";
        $position = 0;
        $writtenLetter = "";
        $correctLetter = "";
        if (!preg_match("/^[A-Z]+$/i", substr($fixedDocNumber, 1, 1))) {
            $fixedDocNumber = strtoupper(substr("000000000" . $docNumber, -9));
        } else {
            $fixedDocNumber = strtoupper($docNumber);
        }
        if ($this->isValidFormat($fixedDocNumber)) {
            $writtenLetter = substr($fixedDocNumber, -1);
            if ($this->isValidFormat($fixedDocNumber)) {
                $fixedDocNumber = str_replace('K', '0', $fixedDocNumber);
                $fixedDocNumber = str_replace('L', '0', $fixedDocNumber);
                $fixedDocNumber = str_replace('M', '0', $fixedDocNumber);
                $position = substr($fixedDocNumber, 0, 8) % 23;
                $correctLetter = substr($keyString, $position, 1);
            }
        }
        return $correctLetter;
    }
}
