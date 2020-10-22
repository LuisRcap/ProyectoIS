create database if not exists Baches;

use Baches;

/*  CREACIÓN DE TABLAS  */
create table if not exists Ciudadano(
    correo      varchar(45) not null,
    nombre      varchar(45),
    apellidoP   varchar(45),
    apellidoM   varchar(45),
    sexo        varchar(6),
    telefono    varchar(15),
    celular     varchar(15),
    edad        int,
    constraint PK_correo primary key( correo )
);

create table if not exists Trabajador(
    matricula   varchar(20) not null,
    nombre      varchar(45) not null,
    apellidoP   varchar(45) not null,
    apellidoM   varchar(45) not null,
    categoria   varchar(20) not null,
    constraint PK_matricula primary key( matricula )
);

create table if not exists Usuario(
    matricula   varchar(20),
    contrasena  varchar(20) not null,
    constraint PK_matricula primary key( matricula )
);

create table if not exists Notificacion(
    idNotificacion  int not null auto_increment,
    calle           varchar(45),
    colonia         varchar(45),
    delegacion      varchar(45),
    codigoPostal    varchar(5),
    fecha           date not null,
    hora            time not null,
    foto            blob,
    estadoActual    varchar(13) not null,
    matriculaTrabajador varchar(20),
    correoCiudadano varchar(45),
    constraint PK_idNotificacion primary key( idNotificacion )
);

/*  RESTRICCIONES DE TABLAS  */
/*  Llaves foraneas  */
alter table Usuario add constraint FK_matricula
    foreign key( matricula )
    references Trabajador( matricula );

alter table Notificacion add constraint FK_matriculaTrabajador
    foreign key( matriculaTrabajador )
    references Trabajador( matricula );

alter table Notificacion add constraint FK_correoCiudadano
    foreign key( correoCiudadano )
    references Ciudadano( correo );
