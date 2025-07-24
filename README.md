# Ternary Diagram Tool

This repository contains a small PHP page that lets you input the sand, silt and clay fractions of a soil sample and shows the point on a USDA soil texture triangle.

## Running the page

1. Make sure PHP is installed.
2. Start the built-in PHP server from the project directory:
   
   ```bash
   php -S localhost:8000
   ```
3. Open `http://localhost:8000/index.php` in your browser.

The form accepts the values in millimetres, normalises them and plots the location on the ternary diagram.

The page uses inline styles only. You can further adjust the look by editing `index.php` and modifying the CSS block near the top of the file.
