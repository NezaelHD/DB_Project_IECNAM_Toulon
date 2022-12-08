CREATE DATABASE bookingalien;

\c bookingalien

-- Suppression de la base existante

DROP TABLE IF EXISTS Traveller CASCADE;
DROP TABLE IF EXISTS Planet CASCADE;
DROP TABLE IF EXISTS Trip CASCADE;
DROP TABLE IF EXISTS Country CASCADE;
DROP TABLE IF EXISTS City CASCADE;
DROP TABLE IF EXISTS Hotel CASCADE;
DROP TABLE IF EXISTS Review CASCADE;
DROP TABLE IF EXISTS Activity CASCADE;
DROP TABLE IF EXISTS Currency CASCADE;
DROP TABLE IF EXISTS CityActivities CASCADE;
DROP TABLE IF EXISTS TravellerReviews CASCADE;


-- Création de la structure de la base (tables)

CREATE TABLE Currency (
                          currencyName VARCHAR(50) PRIMARY KEY NOT NULL,
                          currencySymbole VARCHAR(50) NOT NULL,
                          currencyExchangeRate FLOAT NOT NULL
);

CREATE TABLE Planet (
                        planetName VARCHAR(50) PRIMARY KEY NOT NULL,
                        currencyName VARCHAR(50) NOT NULL,
                        FOREIGN KEY (currencyName) REFERENCES Currency (currencyName)
);

CREATE TABLE Traveller (
                           travellerEmail VARCHAR(50) PRIMARY KEY NOT NULL,
                           travellerName VARCHAR(50) NOT NULL,
                           travellerSurname VARCHAR(50) NOT NULL,
                           password VARCHAR(255) NOT NULL,
                           roles JSON,
                           planetName VARCHAR(50) NOT NULL,
                           FOREIGN KEY (planetName) REFERENCES Planet (planetName)
);

CREATE TABLE Country (
                         countryName VARCHAR(50) PRIMARY KEY NOT NULL,
                         currencyName VARCHAR(50) NOT NULL,
                         FOREIGN KEY (currencyName) REFERENCES Currency (currencyName)
);

CREATE TABLE City (
                      cityID SERIAL PRIMARY KEY NOT NULL,
                      cityName VARCHAR(50) NOT NULL,
                      countryName VARCHAR(50) NOT NULL,
                      FOREIGN KEY (countryName) REFERENCES Country (countryName)
);

CREATE TABLE Hotel (
                       hotelID SERIAL PRIMARY KEY NOT NULL,
                       hotelName VARCHAR(50) NOT NULL,
                       hotelNbPlace INTEGER NOT NULL,
                       hotelPrice FLOAT NOT NULL,
                       hotelAddress VARCHAR(255) NOT NULL,
                       cityID INTEGER NOT NULL,
                       FOREIGN KEY (cityID) REFERENCES City (cityID),
                       CHECK (hotelNbPlace >= 0),
                       CHECK (hotelPrice > 0)
);

CREATE TABLE Activity (
                          activityID SERIAL PRIMARY KEY NOT NULL,
                          activityName VARCHAR(50) NOT NULL,
                          activityPrice FLOAT NOT NULL,
                          CHECK (activityPrice >= 0)
);

CREATE TABLE Trip (
                      tripID SERIAL PRIMARY KEY NOT NULL,
                      tripStart DATE NOT NULL,
                      tripEnd DATE NOT NULL,
                      travellerEmail VARCHAR(50) NOT NULL,
                      hotelID INTEGER NOT NULL,
                      activityID INTEGER,
                      FOREIGN KEY (travellerEmail) REFERENCES Traveller (travellerEmail),
                      FOREIGN KEY (hotelID) REFERENCES Hotel (hotelID),
                      FOREIGN KEY (activityID) REFERENCES Activity (activityID)
);

CREATE TABLE Review (
                        reviewID SERIAL PRIMARY KEY NOT NULL,
                        reviewOpinion VARCHAR(2000),
                        reviewStars INTEGER NOT NULL,
                        travellerEmail VARCHAR(50) NOT NULL,
                        hotelID INTEGER,
                        activityID INTEGER,
                        FOREIGN KEY (travellerEmail) REFERENCES Traveller (travellerEmail),
                        FOREIGN KEY (hotelID) REFERENCES Hotel (hotelID),
                        FOREIGN KEY (activityID) REFERENCES Activity (activityID),
                        CHECK (reviewStars >= 0),
                        check ((hotelID IS NOT NULL AND activityID is NULL) OR (activityID IS NOT NULL AND hotelID is NULL))
);

CREATE TABLE CityActivities (
                                activityID INTEGER NOT NULL,
                                cityID INTEGER NOT NULL,
                                FOREIGN KEY (activityID) REFERENCES Activity (activityID),
                                FOREIGN KEY (cityID) REFERENCES City (cityID)
);


-- Création des fonctions trigger

CREATE OR REPLACE FUNCTION Hotel_Place_Down_update()
    RETURNS TRIGGER
    LANGUAGE plpgsql
AS
$$
BEGIN
    IF (SELECT hotelNbPlace FROM hotel WHERE hotelID = OLD.hotelid) = 0 THEN
        RAISE EXCEPTION 'Plus de place';
    END IF;

    UPDATE hotel
    SET hotelNbPlace = hotelNbPlace - 1
    WHERE hotelID = NEW.hotelID;
    RETURN NEW;
END
$$;

CREATE OR REPLACE FUNCTION Hotel_Place_Up_update()
    RETURNS TRIGGER
    LANGUAGE plpgsql
AS
$$
BEGIN
    UPDATE hotel
    SET hotelNbPlace = hotelNbPlace + 1
    WHERE hotelID = OLD.hotelID;
    RETURN OLD;
END
$$;


CREATE OR REPLACE FUNCTION Check_Trip_Date()
    RETURNS TRIGGER
    LANGUAGE plpgsql
AS $$
BEGIN
    IF EXISTS (SELECT * FROM trip
               WHERE travellerEmail = NEW.travellerEmail
                 AND tripstart <= NEW.tripstart
                 AND tripend >= NEW.tripstart)
    THEN RAISE EXCEPTION 'Trip start date is already booked';
    END IF;

    IF EXISTS (SELECT * FROM trip
               WHERE travellerEmail = NEW.travellerEmail
                 AND tripstart <= NEW.tripend
                 AND tripend >= NEW.tripend)
    THEN RAISE EXCEPTION 'Trip start date is already booked';
    END IF;

    RETURN NEW;
END
$$;


-- Création des triggers

CREATE OR REPLACE TRIGGER Hotel_Place_Down_Trigger
    AFTER INSERT ON trip
    FOR EACH ROW
EXECUTE FUNCTION Hotel_Place_Down_update();

CREATE OR REPLACE TRIGGER Hotel_Place_Up_Trigger
    BEFORE DELETE ON trip
    FOR EACH ROW
EXECUTE FUNCTION Hotel_Place_Up_update();

CREATE OR REPLACE TRIGGER Check_Trip_Trigger
    BEFORE INSERT ON trip
    FOR EACH ROW
EXECUTE FUNCTION Check_Trip_Date();

-- Impémentation des données
-- Currency
INSERT INTO Currency (currencyName, currencySymbole, currencyExchangeRate) VALUES ('Dollard', '$', 0.9);
INSERT INTO Currency (currencyName, currencySymbole, currencyExchangeRate) VALUES ('Yen', '¥', 145.0);
INSERT INTO Currency (currencyName, currencySymbole, currencyExchangeRate) VALUES ('Euro', '€', 1.0);
INSERT INTO Currency (currencyName, currencySymbole, currencyExchangeRate) VALUES ('Tentacul', '~', 32.0);
INSERT INTO Currency (currencyName, currencySymbole, currencyExchangeRate) VALUES ('Oeuil', 'Ø', 1038.0);
INSERT INTO Currency (currencyName, currencySymbole, currencyExchangeRate) VALUES ('Sphère', '°', 0.06);

-- Planet
INSERT INTO Planet (planetName, currencyName) VALUES ('Bloublon', 'Tentacul');
INSERT INTO Planet (planetName, currencyName) VALUES ('Plouplon', 'Tentacul');
INSERT INTO Planet (planetName, currencyName) VALUES ('P3X-542', 'Sphère');
INSERT INTO Planet (planetName, currencyName) VALUES ('Zorgulon', 'Oeuil');
INSERT INTO Planet (planetName, currencyName) VALUES ('Felucia', 'Oeuil');
INSERT INTO Planet (planetName, currencyName) VALUES ('N{0Az@', 'Sphère');

-- Country
INSERT INTO Country (countryName, currencyName) VALUES ('New Zeland', 'Dollard');
INSERT INTO Country (countryName, currencyName) VALUES ('USA', 'Dollard');
INSERT INTO Country (countryName, currencyName) VALUES ('France', 'Euro');
INSERT INTO Country (countryName, currencyName) VALUES ('China', 'Yen');

-- City
INSERT INTO City (cityID, cityName, countryName) VALUES ('4', 'Toulon', 'France');
INSERT INTO City (cityID, cityName, countryName) VALUES ('3', 'Anger', 'France');
INSERT INTO City (cityID, cityName, countryName) VALUES ('2', 'New York City', 'USA');
INSERT INTO City (cityID, cityName, countryName) VALUES ('1', 'Chicago', 'USA');
INSERT INTO City (cityID, cityName, countryName) VALUES ('5', 'Shangaï', 'China');
INSERT INTO City (cityID, cityName, countryName) VALUES ('6', 'Wuhan', 'China');
INSERT INTO City (cityID, cityName, countryName) VALUES ('8', 'Wellington', 'New Zeland');
INSERT INTO City (cityID, cityName, countryName) VALUES ('7', 'Auckland', 'New Zeland');

--Activity
INSERT INTO Activity (activityName, activityPrice) VALUES ('Visite des caves local', 59.0);
INSERT INTO Activity (activityName, activityPrice) VALUES ('Chasse aux papillons', 22.0);
INSERT INTO Activity (activityName, activityPrice) VALUES ('Chasse à l homme', 2550.0);
INSERT INTO Activity (activityName, activityPrice) VALUES ('Tir sportif', 80.0);
INSERT INTO Activity (activityName, activityPrice) VALUES ('Patinoire', 7.0);
INSERT INTO Activity (activityName, activityPrice) VALUES ('Kayak', 25.0);
INSERT INTO Activity (activityName, activityPrice) VALUES ('Pèche', 3.5);

-- Hotel
INSERT INTO Hotel (hotelName, hotelNbPlace, hotelPrice, hotelAddress, cityID)
VALUES ('The Continental', 80, 250, '82-92 Beaver Street at Pearl Street The Beaver Building', '1');
INSERT INTO Hotel (hotelName, hotelNbPlace, hotelPrice, hotelAddress, cityID)
VALUES ('Le Gîte à Pépé', 8, 750, 'Le carrefour (lieu dit)', '2');
INSERT INTO Hotel (hotelName, hotelNbPlace, hotelPrice, hotelAddress, cityID)
VALUES ('L Auberge du poney fringuan', 32, 40, '2 jessie street', '3');
INSERT INTO Hotel (hotelName, hotelNbPlace, hotelPrice, hotelAddress, cityID)
VALUES ('Le Crous', 300, 24, '657 avenue du 1er Bimp', '4');
INSERT INTO Hotel (hotelName, hotelNbPlace, hotelPrice, hotelAddress, cityID)
VALUES ('Allerton Hotel', 109, 122, '701 Michigan Ave', '5');
INSERT INTO Hotel (hotelName, hotelNbPlace, hotelPrice, hotelAddress, cityID)
VALUES ('Pacific hotel', 400, 68, '108 Nanjing Rd (W)', '6');
INSERT INTO Hotel (hotelName, hotelNbPlace, hotelPrice, hotelAddress, cityID)
VALUES ('Wanda Reign', 315, 190, 'Wuchang District', '7');
INSERT INTO Hotel (hotelName, hotelNbPlace, hotelPrice, hotelAddress, cityID)
VALUES ('Hilton', 220, 332, '47 Quay Street', '8');

--Traveller password = password
INSERT INTO Traveller (travellerEmail, travellerName, travellerSurname, password, roles, planetName)
VALUES ('george.foulpon@msn.pl', 'Foulpon', 'George', '$2y$10$OlLrTNFrVFH/mlWiWSIUFODkNik2doTQ9TQOHLgkGBJnc88ACfp.a', '[]', 'Plouplon');
INSERT INTO Traveller (travellerEmail, travellerName, travellerSurname, password, roles, planetName)
VALUES ('narfpclo.gz@protonmail.N', 'Narfpclo', 'Gz', '$2y$10$OlLrTNFrVFH/mlWiWSIUFODkNik2doTQ9TQOHLgkGBJnc88ACfp.a', '[]', 'N{0Az@');
INSERT INTO Traveller (travellerEmail, travellerName, travellerSurname, password, roles, planetName)
VALUES ('blou.bloublon@bloublou.blou', 'Blou', 'Bloublou', '$2y$10$OlLrTNFrVFH/mlWiWSIUFODkNik2doTQ9TQOHLgkGBJnc88ACfp.a', '[]', 'Bloublon');
INSERT INTO Traveller (travellerEmail, travellerName, travellerSurname, password, roles, planetName)
VALUES ('mxfive.32@mpx./', 'MX-FIVE', '32', '$2y$10$OlLrTNFrVFH/mlWiWSIUFODkNik2doTQ9TQOHLgkGBJnc88ACfp.a', '[]', 'P3X-542');
INSERT INTO Traveller (travellerEmail, travellerName, travellerSurname, password, roles, planetName)
VALUES ('aaaaaaaa.bbbbb@ccc.dd', 'AAaaAAAa', 'BbBBb', '$2y$10$OlLrTNFrVFH/mlWiWSIUFODkNik2doTQ9TQOHLgkGBJnc88ACfp.a', '[]', 'Felucia');
INSERT INTO Traveller (travellerEmail, travellerName, travellerSurname, password, roles, planetName)
VALUES ('zerg.grez@xyz.zyx', 'Zerg', 'Grez', '$2y$10$OlLrTNFrVFH/mlWiWSIUFODkNik2doTQ9TQOHLgkGBJnc88ACfp.a', '[]', 'Zorgulon');