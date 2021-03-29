# Document Validator

The current library is a Spanish Identity Document Number Validator. It validates several document types, like DNI, NIE and CIF.

This library is widely used in many projects and we don't want to alter their public interface (by now).

The purpose of this test is to refactor this legacy code library.

## You must:

* Respect the public interface of the class, we don't want to alter the classes already using this one.
* Ensure refactored class hasn't lost any of their previous functionality. 

## You should ensure:

* You didn't introduce new bugs.
* Class follows PSR-12 standard.
* Refactored class follows as many SOLID principles as can.
* Refactored class is now easier to understand how it works and is easier to work with.

## What we value the most?

* Understandable code.
* Usage of known patterns.
* Naming.
* SOLID principles.
* You can add external libraries, but we will value more positively your own code.

## Extra

* If you can change public interface, how would you do it? Why?
* What improvements would you want to add to help this library mainteinance?
* In a near future, we want to include validation for [Peruvian National Identity Numbers](https://mag.elcomercio.pe/respuestas/cual-es-el-digito-verificador-de-mi-dni-documento-nacional-de-identidad-reniec-peru-nnda-nnlt-noticia/) too. How would you do it?

That's all! Happy coding!
