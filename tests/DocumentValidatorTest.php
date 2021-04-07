<?php

namespace DocumentValidator\Tests;

use DocumentValidator\DocumentValidator;
use PHPUnit\Framework\TestCase;

class DocumentValidatorTest extends TestCase
{
    public function testNIFValidation()
    {
        $validator = new DocumentValidator();
        $this->assertSame(
            TRUE,
            $validator->isValidIdNumber('27905344L', 'NIF'),
            'Correct NIF number.'
        );
        $this->assertSame(
            FALSE,
            $validator->isValidIdNumber('L27905344', 'NIF'),
            'Not valid NIF format.'
        );
        $this->assertSame(
            FALSE,
            $validator->isValidIdNumber('L27915344', 'NIF'),
            'Valid NIF format but invalid number that does not match check digit.'
        );
        $this->assertSame(
            TRUE,
            $validator->isValidIdNumber('977169Z', 'NIF'),
            'Valid NIF but shorter, and will be filled with zeros on start'
        );
    }

    public function testNIEValidation()
    {
        $validator = new DocumentValidator();
        $this->assertSame(
            TRUE,
            $validator->isValidIdNumber('X6089822C', 'NIE'),
            'Valid NIE format.'
        );
        $this->assertSame(
            FALSE,
            $validator->isValidIdNumber('T4549522K', 'NIE'),
            'Invalid NIE format.'
        );
        $this->assertSame(
            FALSE,
            $validator->isValidIdNumber('X689822C', 'NIE'),
            'Invalid NIE format: because is shorter than expected.'
        );
        $this->assertSame(
            FALSE,
            $validator->isValidIdNumber('X6389822C', 'NIE'),
            'Invalid NIE because claculated check digit does not match.'
        );
    }

    public function testCIFValidation()
    {
        $validator = new DocumentValidator();
        $this->assertSame(
            TRUE,
            $validator->isValidIdNumber('G28667152', 'CIF'),
            'Valid CIF with numeric check digit.'
        );
        $this->assertSame(
            TRUE,
            $validator->isValidIdNumber('W2849191H', 'CIF'),
            'Valid CIF with letter check digit.'
        );
        $this->assertSame(
            FALSE,
            $validator->isValidIdNumber('G2866752', 'CIF'),
            'Not valid CIF format: shorter than expected.'
        );
        $this->assertSame(
            FALSE,
            $validator->isValidIdNumber('52849191H', 'CIF'),
            'Not valid CIF format: starts with number.'
        );
        $this->assertSame(
            FALSE,
            $validator->isValidIdNumber('G2866715P', 'CIF'),
            'Not valid CIFformat: check digit cannot be letter if society type is G.'
        );
        $this->assertSame(
            FALSE,
            $validator->isValidIdNumber('W2949191H', 'CIF'),
            'Not valid CIF because calculated check digit does not match.'
        );
    }
}
