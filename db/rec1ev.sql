DROP TABLE IF EXISTS usuarios CASCADE;
CREATE TABLE usuarios
(
    id         BIGSERIAL    PRIMARY KEY
  , n_paciente char(5)      NOT NULL UNIQUE
  , nombre     VARCHAR(255) NOT NULL
  , password   VARCHAR(255)
);

DROP TABLE IF EXISTS citas CASCADE;
CREATE TABLE citas
(
    id         BIGSERIAL PRIMARY KEY
  , fecha      DATE      NOT NULL
  , hora       TIME      NOT NULL
  , usuario_id BIGINT    NOT NULL REFERENCES usuarios(id)
                         ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO usuarios (n_paciente, nombre, password) VALUES
    ('Z9999', 'Admin', crypt('admin', gen_salt('bf', 13)))
  , ('A0000', 'Pepe', crypt('pepe', gen_salt('bf', 13)))
  , ('A0001', 'Ana', crypt('ana', gen_salt('bf', 13)))
  , ('A0002', 'Mateo', crypt('mateo', gen_salt('bf', 13)))
  , ('A0003', 'Luís', crypt('luis', gen_salt('bf', 13)))
  , ('A0004', 'Josefa', crypt('josefa', gen_salt('bf', 13)))
  , ('A0005', 'Marcos', crypt('marcos', gen_salt('bf', 13)))
;

INSERT INTO citas (fecha, hora, usuario_id) VALUES
    ('2019-01-01', '13:15:00', 2)
  , ('2017-03-09', '10:15:00', 2)
  , ('2017-03-19', '12:30:00', 2)
  , ('2017-05-08', '17:45:00', 2)
  , ('2019-01-02', '10:00:00', 3)
  , ('2019-01-02', '10:15:00', 4)
  , ('2019-01-02', '10:30:00', 5)
  , ('2019-01-02', '10:45:00', 6)
  , ('2019-01-02', '11:00:00', 7)
  , ('2019-01-02', '20:45:00', 7)
;
