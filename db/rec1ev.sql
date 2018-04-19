DROP TABLE IF EXISTS usuarios CASCADE;
CREATE TABLE usuarios
(
    id       BIGSERIAL    PRIMARY KEY
  , nombre   VARCHAR(255) NOT NULL UNIQUE
  , password CHAR(64)
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


INSERT INTO usuarios (nombre, password) VALUES
    ('pepe', 'pepe')
  , ('ana', 'ana')
;

INSERT INTO citas (fecha, hora, usuario_id) VALUES
    ('2019-01-01', '13:20:00', 1)
  , ('2019-02-01', '16:44:00', 2)
;
