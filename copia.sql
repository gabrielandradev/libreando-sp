INSERT INTO `estado_prestamo`(`estado`) VALUES ('Prestado'), ('En sala');

INSERT INTO `copia_libro`(`libro_id`, `disponibilidad_id`, `ubicacion_fisica`) 
SELECT libro.id, 1, 'Biblioteca' FROM libro;