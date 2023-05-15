INSERT INTO categories (id, name, parent_id) VALUES
  (1, 'Electronics', NULL),
  (2, 'Laptops', 1),
  (3, 'Smartphones', 1),
  (4, 'Cameras', 1),
  (5, 'Digital Cameras', 4),
  (6, 'DSLR Cameras', 4),
  (7, 'Point and Shoot Cameras', 4),
  (8, 'Clothing', NULL),
  (9, 'Mens Clothing', 8),
  (10, 'Womens Clothing', 8),
  (11, 'Shoes', 8),
  (12, 'Accessories', NULL),
  (13, 'Jewelry', 12),
  (14, 'Watches', 12),
  (15, 'Bags and Luggage', 12),
  (16, 'Headphones', 1),
  (17, 'Bikes', NULL);

INSERT INTO products (name, image_url, price, category_id, description) VALUES
  ('Apple MacBook Air', 'macbookair.jpeg', 999.99, 2, 'The Apple MacBook Air is a sleek and powerful laptop with a high-resolution Retina display and long battery life.'),
  ('HP Envy x360', 'hpenvy.jpg', 849.99, 2, 'The HP Envy x360 is a versatile 2-in-1 laptop with a powerful AMD Ryzen processor and a durable aluminum chassis.'),
  ('Samsung Galaxy S21', 'samsungs21.jpg', 899.99, 3, 'The Samsung Galaxy S21 is a top-of-the-line smartphone with a stunning AMOLED display and a high-quality camera system.'),
  ('Google Pixel 5', 'pixel5.jpeg', 699.99, 3, 'The Google Pixel 5 is a popular smartphone with a beautiful OLED display and advanced camera features.'),
  ('Canon EOS Rebel T8i', 'canont8i.jpg', 899.99, 6, 'The Canon EOS Rebel T8i is a versatile DSLR camera with a powerful 24.2 megapixel sensor and a vari-angle touchscreen LCD.'),
  ('Nikon D850', 'nikond850.png', 2799.99, 6, 'The Nikon D850 is a professional-grade DSLR camera with a massive 45.7 megapixel sensor and 4K UHD video recording.'),
  ('Sony Cyber-shot DSC-RX100 VII', 'sonyrx100.jpeg', 1199.99, 7, 'The Sony Cyber-shot DSC-RX100 VII is a powerful compact camera with a large 1-inch sensor and advanced autofocus technology.'),
  ('Levis 501 Original Fit Jeans', 'levis501.jpg', 79.99, 10, 'The Levis 501 Original Fit Jeans are a timeless classic made from high-quality denim with a straight leg and regular fit.'),
  ('Lululemon Wunder Under High-Rise Leggings', 'lululemon.jpg', 98.00, 10, 'The Lululemon Wunder Under High-Rise Leggings are a popular choice for yoga and other athletic activities, made from high-stretch fabric with a comfortable high-rise waist.'),
  ('Nike Air Zoom Pegasus 38', 'nikepegasus38.png', 119.99, 11, 'The Nike Air Zoom Pegasus 38 is a comfortable and supportive running shoe with responsive Zoom Air cushioning and a breathable mesh upper.'),
  ('Rolex Submariner Date', 'rolex.png', 8995.00, 14, 'The Rolex Submariner Date is a luxurious and iconic diving watch with a sleek design and advanced features, including a date window and rotating bezel.'),
  ('Tissot Le Locle Automatic', 'tissot.jpg', 525.00, 14, 'The Tissot Le Locle Automatic is a sophisticated and elegant dress watch with a Swiss-made automatic movement and a classic silver-tone dial.'),
  ('Michael Kors Large Pebbled Leather Shoulder Bag', 'kors.jpeg', 298.00, 15, 'The Michael Kors Large Pebbled Leather Shoulder Bag is a stylish and practical accessory for everyday use, made from high-quality leather with a spacious interior and multiple pockets.'),
  ('Samsonite Omni PC Hardside Spinner 28"', 'samsonite.jpg', 119.99, 15, 'The Samsonite Omni PC Hardside Spinner 28" is a durable and lightweight suitcase with a hard-shell exterior and a spacious interior with organizational pockets.'),
  ('Apple iPhone 13 Pro', 'ip13.jpg', 1099.99, 3, 'The Apple iPhone 13 Pro is the latest and greatest smartphone from Apple, featuring a stunning Super Retina XDR display and an advanced camera system with three lenses.'),
  ('Bose QuietComfort 35 II Wireless Headphones', 'bose35.png', 299.99, 16, 'The Bose QuietComfort 35 II Wireless Headphones are a popular choice for audiophiles, featuring noise-cancellation technology and a comfortable over-ear design.'),
  ('Sony WH-1000XM4 Wireless Headphones', 'sony1000xm4.png', 349.99, 16, 'The Sony WH-1000XM4 Wireless Headphones are a high-end option for music lovers, with advanced noise-cancellation technology and a powerful sound system.'),
  ('Fitbit Charge 5', 'fitbit.jpg', 179.99, 14, 'The Fitbit Charge 5 is a sleek and stylish fitness tracker with advanced health monitoring features, including an ECG app and a skin temperature sensor.'),
  ('Peloton Bike', 'bike.jpg', 1895.00, 17, 'The Peloton Bike is a high-tech indoor exercise bike with a built-in touchscreen display and access to live and on-demand workout classes.'),
  ('Garmin Forerunner 945 GPS Smartwatch', 'garmin.jpg', 599.99, 14, 'The Garmin Forerunner 945 GPS Smartwatch is a powerful and feature-packed device for runners, with advanced GPS tracking and performance metrics.'),
  ('Nest Learning Thermostat', 'nest.jpg', 249.99, 1, 'The Nest Learning Thermostat is a smart and energy-efficient device that learns your habits and preferences to automatically adjust the temperature of your home.'),
  ('Dyson V11 Torque Drive Cordless Vacuum', 'dyson.jpeg', 699.99, 1, 'The Dyson V11 Torque Drive Cordless Vacuum is a powerful and versatile cleaning tool, with advanced suction technology and up to 60 minutes of run time.'),
  ('KitchenAid Artisan Stand Mixer', 'artisan.jpeg', 399.99, 1, 'The KitchenAid Artisan Stand Mixer is a classic and versatile appliance for home cooks and bakers, with a powerful motor and a variety of attachments.'),
  ('Cuisinart 14-Cup Food Processor', 'foodprocessor.jpg', 199.99, 1, 'The Cuisinart 14-Cup Food Processor is a must-have tool for any serious home chef, with a powerful motor and a range of slicing and shredding blades.'),
  ('Vitamix 5200 Blender', 'vitamix5200.jpeg', 449.99, 1, 'The Vitamix 5200 Blender is a high-performance appliance for blending, pureeing, and chopping, with a powerful motor and a range of speed settings.');

  INSERT INTO users (first_name, last_name, email, password, address, city, country, zip_code, confirmed) VALUES ('Filan', 'Fisteku', 'filan@fisteku.com', '$2y$10$Umqzl3miLG9WqwwhiXnmDOtij5feNl9/61g9fCUgbouTHhMCFOx0K', 'Bill Clinton s.t', 'Prishtina', 'Kosove', '10000', 1);








