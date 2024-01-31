/*INSERT INTO clienti (email, passw, nome, indirizzo, citta, telefono)
VALUES 
('cliente1@email.com', 'password123', 'Mario Rossi', 'Via Roma 123', 'Milano', '1234567890'),
('cliente2@email.com', 'securepass', 'Anna Bianchi', 'Corso Italia 456', 'Roma', '9876543210');


INSERT INTO categorieProdotti (nome, descrizione)
VALUES 
('Sedie', 'Sedie per soggiorno e cucina'),
('Divani', 'Divani comodi e moderni'),
('Tavoli', 'Tavoli per soggiorno e cucina'),
('Armadi', 'Armadi spaziosi e funzionali'),
('Lavandini', 'Lavandini moderni e resistenti');


INSERT INTO opzioni (nome)
VALUES 
('Colore personalizzato'),
('Materiale resistente'),
('Montaggio incluso');


INSERT INTO prodotti (nome, prezzo, peso, descrizione, immagine, categoria, stock)
VALUES 
('Sedia', 20.99, 8.5, 'Sedia moderna con struttura in legno.', NULL, 'Sedie', 50),
('Divano', 499.99, 90.0, 'Divano spazioso e confortevole.', NULL, 'Divani', 20),
('Lavandino', 249.99, 120.0, 'Lavandino moderno e resistente.', NULL, 'Lavandini', 30),
('Armadio', 699.99, 90.0, 'Armadio spazioso con 3 ante.', NULL, 'Armadi', 10),
('Tavolo', 70.99, 70.0, 'Tavolo da pranzo in legno robusto.', NULL, 'Tavoli', 40);


INSERT INTO prodotti_categorie (id_prodotto, id_categoria)
VALUES 
(1, 1),
(2, 2),
(3, 5),
(4, 4),
(5, 3);


INSERT INTO prodotti_opzioni (id_prodotto, id_opzione)
VALUES 
(1, 1),
(2, 2),
(3, 3),
(4, 1),
(4, 2);
*/