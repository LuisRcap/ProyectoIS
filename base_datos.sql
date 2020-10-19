create database Baches;

use Baches;

/*  CREACIÓN DE TABLAS  */
create table if not exists Notificador(
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
    foto            blob not null,
    matriculaTrabajador varchar(20),
    constraint PK_idNotificacion primary key( idNotificacion )
);

create table if not exists Notificador_notifica(
    idNotificacion  int,
    correo          varchar(45)
);

/*  RESTRICCIONES DE TABLAS  */
/*  Llaves foraneas  */
alter table Usuario add constraint FK_matricula
    foreign key( matricula )
    references Trabajador( matricula );

alter table Notificacion add constraint FK_matriculaTrabajador
    foreign key( matriculaTrabajador )
    references Trabajador( matricula );

alter table Notificador_notifica add constraint FK_idNotificacion
    foreign key( idNotificacion )
    references Notificacion( idNotificacion );

alter table Notificador_notifica add constraint FK_correo
    foreign key( correo )
    references Notificador( correo );