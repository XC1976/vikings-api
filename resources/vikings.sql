CREATE TABLE Weapon (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  type VARCHAR(50) NOT NULL,
  damage INTEGER NOT NULL
);

INSERT INTO Weapon(type, damage) VALUES
('sword', 50),
('axe', 100);

CREATE TABLE viking (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  name varchar(16) NOT NULL,
  attack int NOT NULL,
  defense INTEGER NOT NULL,
  health INTEGER NOT NULL,
  weaponID INTEGER,
  FOREIGN KEY(weaponID) REFERENCES Weapon(id) ON DELETE SET NULL
);

INSERT INTO viking (name, attack, defense, health, weaponID) VALUES
('Ragnar', 200, 150, 300, 1),
('Rollo', 250, 100, 200, 1),
('Ivar', 300, 200, 100, 1);

INSERT INTO viking (name, attack, defense, health) VALUES
('Floki', 150, 80, 350),
('Lagertha', 300, 200, 200),
('Björn', 350, 200, 100);