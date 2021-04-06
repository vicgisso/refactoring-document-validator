<?php

namespace DocumentValidator;

/*
 *   This class needs to be kept in order to avoid modify the library interface
 */

class DocumentValidator
{
    /*
    *   This function validates a Spanish identification number
    *   verifying its check digits.
    *
    *   NIFs and NIEs are personal numbers.
    *   CIFs are corporates.
    *
    *   This function requires:
    *       - specificValidation: Passing the proper extension of the abstract
    *         class in order to validate the indicted document
    *
    *   This function returns:
    *       TRUE: If specified identification number is correct
    *       FALSE: Otherwise
    *
    *   Usage:
    *       echo isValidIdNumber('G28667152', 'CIF');
    *   Returns:
    *       TRUE
    */
    public function isValidIdNumber($docNumber, $type): bool
    {
        $fixedDocNumber = strtoupper($docNumber);
        $fixedType = strtoupper($type);

        switch ($fixedType) {
            case 'NIF':
                return $this->specificValidation(
                    new NIFValidator($fixedDocNumber)
                );
            case 'NIE':
                return $this->specificValidation(
                    new NIEValidator($fixedDocNumber)
                );
            case 'CIF':
                return $this->specificValidation(
                    new CIFValidator($fixedDocNumber)
                );
            default:
                throw new \Exception('Unsupported Type');
        }
    }

    /*
    *   This function call method 'isValid' of the validation class passed
    *
    *   This function returns:
    *       TRUE: If specified identification number in class creation
    *             is correct
    *       FALSE: Otherwise
    *
    *   Usage:
    *       echo isValidIdNumber(new CIFValidator('G28667152'));
    *   Returns:
    *       TRUE
    */
    private function specificValidation(AbstractValidator $validator): bool
    {
        return $validator->isValid();
    }
}
