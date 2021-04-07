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
        $fixedDocNumber = substr("000000000" . $this->docNumber, -9);
        $writtenDigit = substr($this->docNumber, -1, 1);
        if ($this->isValidFormat($fixedDocNumber)) {
            $correctDigit = $this->getPersonalDocumentCheckDigit($fixedDocNumber);
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
            '/^[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z]/'
        );
    }
}
