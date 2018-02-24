# Document Validator

El propósito de este ejercicio es refactorizar un código legacy.

Se debe de respetar la interfaz pública de la clase, ya que no queremos alterar el funcionamiento 
de las clases que ya hacen uso de este código.

Debemos asegurarnos de que:
 
* La clase no ha perdido nada de su funcionalidad previa. 
* No hemos introducido nuevos bugs.
* La clase sigue un coding standard (PSR1-2)
* El resultado sigue principios SOLID

## Modo de proceder

1. Observar qué hace actualmente la clase.
2. Asegurarnos de que nada de lo que hagamos alterará su funcioamiento (Harness testing).
3. Corregir el coding style en caso de necesitarlo.
4. Detección de smells solucionables con safe refactors
5. Aplicar refactors
6. Asegurarnos de que todo sigue OK
7. Repetir 4-6 hasta eliminar todos los smells posibles.
8. Aplicar refactors más complejos
9. Asegurarnos de que too sigue OK
