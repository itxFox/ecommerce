CREATE DATABASE ecommerce;
CREATE TABLE prodotti (
    id_prodotto INT(255) AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(30),
    prezzo DOUBLE(10, 2),
    peso DOUBLE(10, 2),
    descrizione TEXT,
    immagine LONGBLOB,
    categoria VARCHAR(30),
    stock INT(255)
);

CREATE TABLE ordini (
    id_ordine INT(255) AUTO_INCREMENT PRIMARY KEY,
    customer_id INT(255),
    ammontare DOUBLE(10, 2),
    indirizzoOrdine VARCHAR(50),
    emailOrdine VARCHAR(25),
    dataOrdine DATE,
    statoOrdine VARCHAR(15)
    FOREIGN KEY (customer_id) REFERENCES clienti(id_customer)
);

CREATE TABLE clienti (
    id_customer INT(255) AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(25),
    passw VARCHAR(30),
    amministratore BOOLEAN DEFAULT FALSE,
    nome VARCHAR(40),
    indirizzo VARCHAR(50),
    citta VARCHAR(15),
    telefono VARCHAR(10)
);

CREATE TABLE dettagliOrdini (
    id_dettaglio INT(255) AUTO_INCREMENT PRIMARY KEY,
    id_ordine INT(255),
    id_prodotto INT(255),
    prezzo DOUBLE(10, 2),
    quantita INT(255),
    FOREIGN KEY (id_ordine) REFERENCES ordini(id_ordine),
    FOREIGN KEY (id_prodotto) REFERENCES prodotti(id_prodotto)
);

CREATE TABLE categorieProdotti (
    id_categoria INT(255) AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(30),
    descrizione TEXT
);

CREATE TABLE opzioni (
    id_opzione INT(255) AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(30)
);

CREATE TABLE prodotti_categorie (
    id_prodotti_categorie INT(255) AUTO_INCREMENT PRIMARY KEY,
    id_prodotto INT(255),
    id_categoria INT(255),
    FOREIGN KEY (id_prodotto) REFERENCES prodotti(id_prodotto),
    FOREIGN KEY (id_categoria) REFERENCES categorieProdotti(id_categoria)
);

CREATE TABLE prodotti_opzioni (
    id_prodotti_opzioni INT(255) AUTO_INCREMENT PRIMARY KEY,
    id_prodotto INT(255),
    id_opzione INT(255),
    FOREIGN KEY (id_prodotto) REFERENCES prodotti(id_prodotto),
    FOREIGN KEY (id_opzione) REFERENCES opzioni(id_opzione)
);
