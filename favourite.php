<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Favourite Cars - CARRUS</title>
  <link rel="stylesheet" href="carrusCSS/home.css">
  <link rel="stylesheet" href="carrusCSS/favourite.css">
  <style>
    .car-card {
      display: inline-block;
      width: 250px;
      margin: 10px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 12px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      text-align: center;
    }
    .car-card img {
      width: 100%;
      border-radius: 10px;
    }
    .car-card button {
      margin-top: 8px;
      padding: 6px 12px;
      background-color: #335778;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .car-card button.unmark {
      background-color: #c0392b;
    }
  </style>
</head>
<body>

<header>
  <div class="header-container ms-5">
    <h1 style="font-family: 'Underdog', system-ui; font-weight: 700; font-size: 2.5rem; color: #9fc2e7;">
      Carr<span style="color: #335778;">Us</span>
    </h1>
    <nav>
      <ul class="nav-list">
        <li><a href="./home.html">Home</a></li>
       
        
      </ul>
    </nav>
  </div>
</header>

<h2 style="text-align: center;">Select Your Favourite Car</h2>
<div id="all-cars" style="display: flex; flex-wrap: wrap; justify-content: center;"></div>

<h3 style="text-align: center;">Your Favourite Cars</h3>
<div id="favourites" style="display: flex; flex-wrap: wrap; justify-content: center;"></div>

<script src="favourite.js"></script>
</body>
</html>
