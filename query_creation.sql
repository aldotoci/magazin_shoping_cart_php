CREATE TABLE magazines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    magazine_name VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL,
    language VARCHAR(50) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    COLUMN image_url VARCHAR(500);
);
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255), -- Use a secure hash function like bcrypt in a real application
    email VARCHAR(100) UNIQUE,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    phone_number VARCHAR(20),
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    total_price DECIMAL(10, 2),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    magazine_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    user_id INT, -- Added user_id column
    magazine_id INT,
    quantity INT,
    price DECIMAL(10, 2),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (user_id) REFERENCES users(id), -- Assuming a users table for user information
    FOREIGN KEY (magazine_id) REFERENCES magazines(id)
); 

ALTER TABLE magazines ADD COLUMN image_url VARCHAR(500);

INSERT INTO magazines (magazine_name, category, language, quantity, price, image_url)
VALUES
('National Geographic', 'Science & Nature', 'English', 50, 9.99, 'https://i.natgeofe.com/n/17515bb0-5f72-4e7b-b5e6-30184eea6ff5/national-geographic-magazine-september-2023-dome_2x3.jpg?w=346.50000751018524&h=520.3000112771988'),
('Shkencë për të gjithë', 'Shkencë', 'Albanian', 30, 14.99, 'https://www.mountvisual.no/wp-content/uploads/2021/01/Science_mock-up_web.jpg'),
('Vogue', 'Fashion & Lifestyle', 'English', 20, 19.99, 'https://assets.vogue.in/photos/658e8113420a5e2d2a4678a5/1:1/w_640,h_1200,c_limit/67518417_485124968932015_78128208042197355_n.jpg'),
('Koha Ditore', 'Aktualitet', 'Albanian', 25, 12.99, 'https://resources.koha.net/images/2019/July/16/riri1563259420.jpg?w=250&h=140&r=fill'),
('Tech Crunch', 'Technology', 'English', 40, 8.99, 'https://assets.bizclikmedia.net/138/88d583cad0f020cc4b0de7a02753e41f:b175156ac346a451d78976f82aa595f3/screenshot-2022-10-06-110739.webp'),
('Revista Anabel', 'Bukuri & Stil', 'Albanian', 15, 24.99, 'https://scontent.ftia19-1.fna.fbcdn.net/v/t31.18172-8/1263975_520906521326794_884895074_o.jpg?_nc_cat=103&ccb=1-7&_nc_sid=be3454&_nc_eui2=AeFwUZUNrNzFrHFipuZU3A77z9OlwVywkarP06XBXLCRqqgHyZPQzi0K1vURd-Z42DIXi2_N_qlyHIY-nupw3MV6&_nc_ohc=tgwLetHIlxcAX8n4v-b&_nc_ht=scontent.ftia19-1.fna&oh=00_AfBDhHpAwjwoXpRlluVsSE6CZcOmsGbXo1IDrZwlL3E1lg&oe=65CA7942'),
('The Economist', 'Business & Finance', 'English', 10, 29.99, 'https://thecsspoint.com/wp-content/uploads/2021/02/The-Economist-Magazine-5th-February-2021-450.jpg'),
('Burda Style', 'Fashion & Sewing', 'German', 35, 11.99, 'https://www.newsstand.co.uk/issueimages/535x745/2745190.jpg'),
('Historia e Popullit', 'Histori', 'Albanian', 28, 16.99, 'https://b3c4r2f7.stackpathcdn.com/13101-large_default/historia-e-popullit-shqiptar-vellimi-1.jpg'),
('Wired', 'Science & Technology', 'English', 18, 22.99, 'https://m.media-amazon.com/images/I/61i-Hc2F8HL._AC_UF1000,1000_QL80_.jpg');
