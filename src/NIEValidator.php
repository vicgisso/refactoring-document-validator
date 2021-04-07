<?php

namespace DocumentValidator;

use DocumentValidator\AbstractValidator;

class NIEValidator extends AbstractValidator
{
    /*
     *   This function validates a Spanish NIE identification number
     *   verifying its check digits.
     *
     *   This function returns:
     *       TRUE: If specified identification number is correct
     *       FALSE: Otherwise
     *
     *   Algorithm works as described in:
     *       http://www.interior.gob.es/es/web/servicios-al-ciudadano/dni/calculo-del-digito-de-control-del-nif-nie
     *
     *   The algorithm for validating the check digits of a NIE number is
     *   identical to the altorithm for validating NIF numbers. We only have to
     *   replace Y, X and Z with 1, 0 and 2 respectively; and then, run
     *   the NIF altorithm
     * 
     *   Usage:
     *       $validator = new NIEValidator('X6089822C');
     *       echo $validator->isValid();
     *   Returns:
     *       TRUE
     */
    public function isValid(): bool
    {
        $isValid = FALSE;
        if ($this->isValidFormat($this->docNumber)) {

            $numberWithoutLast = substr($this->docNumber, 0, strlen($this->docNumber) - 1);
            $lastDigit = substr($this->docNumber, -1, 1);
            $numberWithoutLast = str_replace('Y', '1', $numberWithoutLast);
            $numberWithoutLast = str_replace('X', '0', $numberWithoutLast);
            $numberWithoutLast = str_replace('Z', '2', $numberWithoutLast);
            $fixedDocNumber = $numberWithoutLast . $lastDigit;
            $correctDigit = $this->getPersonalDocumentCheckDigit($fixedDocNumber);
            if ($lastDigit == $correctDigit) {
                $isValid = TRUE;
            }
        }
        return $isValid;
    }

    /*
     *   This function validates the format of a given string in order to
     *   see if it fits with NIE format. Practically, it performs a validation
     *   over a NIE, except this function does not check the check digit.
     *
     *   This function returns:
     *       TRUE: If specified string respects NIE format
     *       FALSE: Otherwise
     * 
     *   Usage:
     *       echo isValidFormat('X6089822C')
     *   Returns:
     *       TRUE
     */
    protected function isValidFormat($docNumber): bool
    {
        return $this->respectsDocPattern(
            $docNumber,
            '/^[XYZ][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z0-9]/'
        );
    }
}
