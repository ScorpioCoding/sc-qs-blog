CREATE DATABASE IF NOT EXISTS quickstart;
USE quickstart;
CREATE TABLE IF NOT EXISTS user ( 
  id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL, 
  name VARCHAR(50) NOT NULL, 
  email VARCHAR(255) NOT NULL,
  permission VARCHAR(50) NOT NULL,
  psw_hash VARCHAR(255) NOT NULL);

CREATE TABLE IF NOT EXISTS company (
  id ENUM('') NOT NULL PRIMARY KEY,
  name VARCHAR(50),
  slogan VARCHAR(255),
  address VARCHAR(255),
  postal VARCHAR(50),
  city VARCHAR(255),
  state VARCHAR(255),
  country VARCHAR(255),
  email VARCHAR(255),
  phone VARCHAR(20),
  vat VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS website (
  id ENUM('') NOT NULL PRIMARY KEY,
  domain VARCHAR(100),
  url VARCHAR(255),
  image VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS blog (
  id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  status VARCHAR(50), 
  author VARCHAR(100),
  image_author VARCHAR(255),
  date_at VARCHAR(50),
  title VARCHAR(255),
  slug VARCHAR(255),
  image_landscape VARCHAR(255),
  image_portrait VARCHAR(255),
  description TEXT,
  content TEXT
);

