<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Enjoy Restaurant Management System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * { 
      margin: 0; 
      padding: 0; 
      box-sizing: border-box; 
    }
    
    body { 
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
      background: linear-gradient(135deg, #fdf8f4 0%, #fae8d9 100%);
      min-height: 100vh;
      color: #333;
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* Header Navigation */
    header {
      background: linear-gradient(135deg, #a74200 0%, #d97706 100%);
      padding: 20px 50px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 12px;
      color: white;
      font-size: 24px;
      font-weight: bold;
    }

    .logo-icon {
      background: rgba(255,255,255,0.2);
      width: 40px;
      height: 40px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
    }

    nav {
      display: flex;
      gap: 30px;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-size: 16px;
      font-weight: 500;
      transition: opacity 0.3s;
      cursor: pointer;
    }

    nav a:hover {
      opacity: 0.8;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .user-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: rgba(255,255,255,0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 18px;
    }

    .login-btn {
      background: white;
      color: #a74200;
      padding: 10px 25px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: transform 0.2s;
      cursor: pointer;
    }

    .login-btn:hover {
      transform: translateY(-2px);
    }

    .register-btn {
      background: transparent;
      color: white;
      padding: 10px 25px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.2s;
      cursor: pointer;
      border: 2px solid rgba(255,255,255,0.3);
    }

    .register-btn:hover {
      background: rgba(255,255,255,0.1);
      transform: translateY(-2px);
    }

    /* Hero Section */
    .hero {
      max-width: 1200px;
      margin: 80px auto;
      padding: 0 50px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: center;
    }

    .hero-content h1 {
      font-size: 48px;
      color: #a74200;
      margin-bottom: 20px;
      line-height: 1.2;
    }

    .hero-content p {
      font-size: 18px;
      color: #555;
      line-height: 1.6;
      margin-bottom: 30px;
    }

    .hero-buttons {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }

    .btn {
      padding: 15px 30px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
      font-size: 16px;
      display: inline-flex;
      align-items: center;
      gap: 10px;
    }

    .btn-primary {
      background: linear-gradient(135deg, #a74200 0%, #d97706 100%);
      color: white;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 16px rgba(167, 66, 0, 0.3);
    }

    .btn-secondary {
      background: white;
      color: #a74200;
      border: 2px solid #f0d5be;
    }

    .btn-secondary:hover {
      border-color: #a74200;
      transform: translateY(-2px);
    }

    .stats {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-top: 40px;
    }

    .stat-card {
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
      display: flex;
      align-items: center;
      gap: 20px;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .stat-icon {
      width: 60px;
      height: 60px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      color: white;
    }

    .stat-icon.primary {
      background: linear-gradient(135deg, #a74200 0%, #d97706 100%);
    }

    .stat-icon.secondary {
      background: linear-gradient(135deg, #8b5cf6 0%, #c084fc 100%);
    }

    .stat-info h3 {
      font-size: 32px;
      color: #1f2937;
      margin-bottom: 5px;
    }

    .stat-info p {
      color: #6b7280;
      font-size: 14px;
    }

    .hero-image {
      background: linear-gradient(135deg, #fde8e4 0%, #f3e5f5 100%);
      border-radius: 20px;
      padding: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
      min-height: 400px;
    }

    .hero-image::before {
      content: '🍽️';
      font-size: 200px;
      opacity: 0.3;
      position: absolute;
    }

    /* Menu Section */
    .menu {
      max-width: 1200px;
      margin: 100px auto;
      padding: 0 50px;
      text-align: center;
    }

    .menu h2 {
      font-size: 40px;
      color: #a74200;
      margin-bottom: 20px;
    }

    .menu-subtitle {
      font-size: 18px;
      color: #6b7280;
      margin-bottom: 50px;
      line-height: 1.6;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
    }

    .menu-categories {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-bottom: 40px;
      flex-wrap: wrap;
    }

    .category-btn {
      background: white;
      border: 2px solid #f0d5be;
      padding: 12px 25px;
      border-radius: 25px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s;
    }

    .category-btn.active, .category-btn:hover {
      background: #a74200;
      color: white;
      border-color: #a74200;
    }

    .menu-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
    }

    .menu-item {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .menu-item:hover {
      transform: translateY(-10px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }

    .menu-item-image {
      height: 200px;
      background: linear-gradient(135deg, #fde8e4 0%, #f3e5f5 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 60px;
    }

    .menu-item-content {
      padding: 25px;
    }

    .menu-item h3 {
      font-size: 22px;
      color: #1f2937;
      margin-bottom: 10px;
    }

    .menu-item p {
      color: #6b7280;
      margin-bottom: 15px;
      line-height: 1.6;
    }

    .menu-item-price {
      font-size: 24px;
      color: #a74200;
      font-weight: bold;
    }

    /* Features Section */
    .features {
      max-width: 1200px;
      margin: 100px auto;
      padding: 0 50px;
      text-align: center;
    }

    .features h2 {
      font-size: 40px;
      color: #a74200;
      margin-bottom: 20px;
    }

    .features-subtitle {
      font-size: 18px;
      color: #6b7280;
      margin-bottom: 50px;
      line-height: 1.6;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
    }

    .feature-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      margin-top: 40px;
    }

    .feature-card {
      background: white;
      padding: 35px;
      border-radius: 15px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
      transition: transform 0.3s, box-shadow 0.3s;
      cursor: pointer;
      text-align: left;
    }

    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }

    .feature-icon {
      width: 60px;
      height: 60px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      margin-bottom: 20px;
      color: white;
    }

    .feature-card:nth-child(1) .feature-icon {
      background: linear-gradient(135deg, #a74200 0%, #d97706 100%);
    }

    .feature-card:nth-child(2) .feature-icon {
      background: linear-gradient(135deg, #8b5cf6 0%, #c084fc 100%);
    }

    .feature-card:nth-child(3) .feature-icon {
      background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    }

    .feature-card:nth-child(4) .feature-icon {
      background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
    }

    .feature-card h3 {
      font-size: 22px;
      color: #1f2937;
      margin-bottom: 15px;
    }

    .feature-card p {
      color: #6b7280;
      line-height: 1.6;
    }

    /* Contact Section */
    .contact {
      max-width: 1200px;
      margin: 100px auto;
      padding: 0 50px;
      text-align: center;
    }

    .contact h2 {
      font-size: 40px;
      color: #a74200;
      margin-bottom: 20px;
    }

    .contact-subtitle {
      font-size: 18px;
      color: #6b7280;
      margin-bottom: 50px;
      line-height: 1.6;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
    }

    .contact-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      margin-top: 40px;
    }

    .contact-card {
      background: white;
      padding: 35px;
      border-radius: 15px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
      transition: transform 0.3s, box-shadow 0.3s;
      text-align: center;
    }

    .contact-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .contact-icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: linear-gradient(135deg, #a74200 0%, #d97706 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      margin: 0 auto 20px;
      color: white;
    }

    .contact-card h3 {
      font-size: 22px;
      color: #1f2937;
      margin-bottom: 15px;
    }

    .contact-card p {
      color: #6b7280;
      line-height: 1.6;
    }

    /* About Section */
    .about {
      max-width: 1200px;
      margin: 100px auto;
      padding: 0 50px;
      text-align: center;
    }

    .about h2 {
      font-size: 40px;
      color: #a74200;
      margin-bottom: 20px;
    }

    .about-content {
      background: white;
      padding: 50px;
      border-radius: 15px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
      text-align: left;
    }

    .about p {
      font-size: 18px;
      color: #555;
      line-height: 1.7;
      margin-bottom: 25px;
    }

    .about-stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 30px;
      margin-top: 40px;
    }

    .about-stat {
      text-align: center;
      padding: 25px;
    }

    .about-stat h3 {
      font-size: 36px;
      color: #a74200;
      margin-bottom: 10px;
    }

    .about-stat p {
      color: #6b7280;
      font-size: 16px;
    }

    /* Footer */
    footer {
      background: #333;
      color: white;
      padding: 60px 50px;
      text-align: center;
      margin-top: 80px;
    }

    .footer-content {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: flex-start;
      gap: 30px;
      text-align: left;
    }

    .footer-brand, .footer-links, .footer-contact, .footer-social {
      flex: 1;
      min-width: 200px;
    }

    .footer-brand .logo {
      margin-bottom: 20px;
      justify-content: flex-start;
    }

    .footer-brand p {
      font-size: 14px;
      line-height: 1.6;
      color: #ccc;
    }

    .footer-links h4, .footer-contact h4, .footer-social h4 {
      font-size: 18px;
      margin-bottom: 20px;
      color: #fff;
    }

    .footer-links ul {
      list-style: none;
    }

    .footer-links ul li {
      margin-bottom: 10px;
    }

    .footer-links a, .footer-contact p, .footer-contact a {
      color: #ccc;
      text-decoration: none;
      font-size: 14px;
      transition: color 0.3s;
    }

    .footer-links a:hover, .footer-contact a:hover {
      color: #d97706;
    }

    .social-icons {
      display: flex;
      gap: 15px;
      margin-top: 15px;
    }

    .social-icons a {
      color: white;
      font-size: 24px;
      transition: color 0.3s;
    }

    .social-icons a:hover {
      color: #d97706;
    }

    .footer-bottom {
      margin-top: 40px;
      padding-top: 30px;
      border-top: 1px solid #444;
      font-size: 14px;
      color: #ccc;
      text-align: center;
    }

    /* Modal */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.6);
      justify-content: center;
      align-items: center;
      z-index: 1000;
      animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .modal-content {
      background: white;
      border-radius: 20px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
      animation: slideUp 0.3s;
      overflow: hidden;
      max-height: 90vh;
      display: flex;
      flex-direction: column;
    }

    @keyframes slideUp {
      from { transform: translateY(50px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
      padding: 40px 40px 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .modal-header h3 {
      font-size: 28px;
      color: #1f2937;
    }

    .close-btn {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      background: #f3f4f6;
      border: none;
      cursor: pointer;
      font-size: 20px;
      color: #6b7280;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s;
    }

    .close-btn:hover {
      background: #e5e7eb;
      transform: rotate(90deg);
    }

    .modal-body {
      padding: 0 40px;
      overflow-y: auto;
      flex: 1;
      max-height: 60vh;
    }

    /* Registration form specific styling - FIXED SCROLLING */
    #registerModal .modal-body {
      max-height: 400px;
      overflow-y: auto;
      padding-right: 20px;
    }

    #registerModal .modal-body::-webkit-scrollbar {
      width: 8px;
    }

    #registerModal .modal-body::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    #registerModal .modal-body::-webkit-scrollbar-thumb {
      background: #d97706;
      border-radius: 10px;
    }

    #registerModal .modal-body::-webkit-scrollbar-thumb:hover {
      background: #a74200;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      color: #374151;
      font-weight: 600;
      margin-bottom: 8px;
      font-size: 14px;
    }

    .form-group input {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid #e5e7eb;
      border-radius: 10px;
      font-size: 15px;
      transition: all 0.2s;
    }

    .form-group input:focus {
      outline: none;
      border-color: #a74200;
      box-shadow: 0 0 0 3px rgba(167, 66, 0, 0.1);
    }

    .modal-footer {
      padding: 30px 40px;
      display: flex;
      gap: 15px;
      background: #f9fafb;
      border-top: 1px solid #e5e7eb;
    }

    .modal-footer button {
      flex: 1;
      padding: 12px;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
    }

    .login-submit-btn {
      background: linear-gradient(135deg, #a74200 0%, #d97706 100%);
      color: white;
      border: none;
    }

    .login-submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 16px rgba(167, 66, 0, 0.3);
    }

    .register-submit-btn {
      background: linear-gradient(135deg, #8b5cf6 0%, #c084fc 100%);
      color: white;
      border: none;
    }

    .register-submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 16px rgba(139, 92, 246, 0.3);
    }

    .cancel-btn {
      background: white;
      color: #6b7280;
      border: 2px solid #e5e7eb;
    }

    .cancel-btn:hover {
      border-color: #cbd5e1;
    }

    /* Notification */
    .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      background: white;
      padding: 15px 25px;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
      border-left: 4px solid #10b981;
      display: none;
      z-index: 1000;
      animation: slideInRight 0.5s;
    }

    @keyframes slideInRight {
      from { transform: translateX(100px); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }

    @keyframes fadeOut {
      from { opacity: 1; transform: translateX(0); }
      to { opacity: 0; transform: translateX(100px); }
    }

    /* Chat Button */
    .chat-btn {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: linear-gradient(135deg, #a74200 0%, #d97706 100%);
      color: white;
      border: none;
      font-size: 24px;
      cursor: pointer;
      box-shadow: 0 8px 16px rgba(167, 66, 0, 0.3);
      transition: transform 0.2s;
      z-index: 99;
    }

    .chat-btn:hover {
      transform: scale(1.1);
    }

    @media (max-width: 768px) {
      .hero {
        grid-template-columns: 1fr;
        text-align: center;
      }
      
      .hero-content h1 {
        font-size: 36px;
      }
      
      .stats {
        grid-template-columns: 1fr;
      }

      .hero-buttons {
        justify-content: center;
      }

      .footer-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .footer-brand, .footer-links, .footer-contact, .footer-social {
        min-width: unset;
        width: 100%;
      }
      
      .footer-brand .logo {
        justify-content: center;
      }

      .social-icons {
        justify-content: center;
      }
      
      header {
        padding: 15px 20px;
      }
      
      nav {
        gap: 15px;
      }
      
      .hero, .menu, .features, .contact, .about {
        padding: 0 20px;
      }
      
      .modal-content {
        width: 95%;
        max-height: 85vh;
      }
      
      .modal-header, .modal-body, .modal-footer {
        padding: 20px;
      }
      
      #registerModal .modal-body {
        max-height: 350px;
        padding-right: 10px;
      }
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <div class="logo">
      <div class="logo-icon">🍽️</div>
      <span>Enjoy Restaurant</span>
    </div>
    <nav>
      <a onclick="scrollToSection('home')">Home</a>
      <a onclick="scrollToSection('menu')">Menu</a>
      <a onclick="scrollToSection('features')">Features</a>
      <a onclick="scrollToSection('contact')">Contact</a>
      <a onclick="scrollToSection('about')">About</a>
    </nav>
    <div class="header-right">
      <div class="register-btn" onclick="openModal('registerModal')">Register</div>
      <div class="login-btn" onclick="openModal('loginModal')">Login</div>
      <div class="user-icon">👤</div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero" id="home">
    <div class="hero-content">
      <h1>Streamline Your Restaurant Operations</h1>
      <p>From order management to staff coordination, Enjoy Restaurant provides everything you need to run a successful restaurant. Focus on creating amazing culinary experiences while we handle the rest.</p>
      
      <div class="hero-buttons">
        <a href="dashboard.html" class="btn btn-primary">
          <i class="fas fa-rocket"></i> Get Started
        </a>
        <a onclick="scrollToSection('features')" class="btn btn-secondary">
          <i class="fas fa-play-circle"></i> Watch Demo
        </a>
      </div>

      <div class="stats">
        <div class="stat-card">
          <div class="stat-icon primary">📊</div>
          <div class="stat-info">
            <h3>24K+</h3>
            <p>Orders Processed</p>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon secondary">👥</div>
          <div class="stat-info">
            <h3>1.2K+</h3>
            <p>Restaurants Served</p>
          </div>
        </div>
      </div>
    </div>

    <div class="hero-image">
      <!-- Restaurant illustration -->
    </div>
  </section>

  <!-- Menu Section -->
  <section class="menu" id="menu">
    <h2>Our Menu</h2>
    <p class="menu-subtitle">Discover our delicious offerings crafted with the finest ingredients</p>

    <div class="menu-categories">
      <button class="category-btn active" onclick="filterMenu('all')">All Items</button>
      <button class="category-btn" onclick="filterMenu('appetizers')">Appetizers</button>
      <button class="category-btn" onclick="filterMenu('mains')">Main Courses</button>
      <button class="category-btn" onclick="filterMenu('desserts')">Desserts</button>
      <button class="category-btn" onclick="filterMenu('beverages')">Beverages</button>
    </div>

    <div class="menu-grid">
      <div class="menu-item" data-category="appetizers">
        <div class="menu-item-image">🍞</div>
        <div class="menu-item-content">
          <h3>Garlic Bread</h3>
          <p>Fresh baked bread with garlic butter and herbs</p>
          <div class="menu-item-price">1500frw</div>
        </div>
      </div>

      <div class="menu-item" data-category="appetizers">
        <div class="menu-item-image">🍅</div>
        <div class="menu-item-content">
          <h3>Bruschetta</h3>
          <p>Toasted bread topped with fresh tomatoes, basil, and olive oil</p>
          <div class="menu-item-price">3000frw</div>
        </div>
      </div>

      <div class="menu-item" data-category="mains">
        <div class="menu-item-image">🍝</div>
        <div class="menu-item-content">
          <h3>Spaghetti Carbonara</h3>
          <p>Classic pasta with creamy sauce, bacon, and parmesan cheese</p>
          <div class="menu-item-price">5000frw</div>
        </div>
      </div>

      <div class="menu-item" data-category="mains">
        <div class="menu-item-image">🐟</div>
        <div class="menu-item-content">
          <h3>Grilled Salmon</h3>
          <p>Fresh salmon with lemon butter sauce and seasonal vegetables</p>
          <div class="menu-item-price">15000frw</div>
        </div>
      </div>

      <div class="menu-item" data-category="desserts">
        <div class="menu-item-image">🍰</div>
        <div class="menu-item-content">
          <h3>Tiramisu</h3>
          <p>Italian coffee-flavored dessert with mascarpone cream</p>
          <div class="menu-item-price">5000frw</div>
        </div>
      </div>

      <div class="menu-item" data-category="desserts">
        <div class="menu-item-image">🎂</div>
        <div class="menu-item-content">
          <h3>Chocolate Cake</h3>
          <p>Rich chocolate layered cake with ganache frosting</p>
          <div class="menu-item-price">15000frw</div>
        </div>
      </div>

      <div class="menu-item" data-category="beverages">
        <div class="menu-item-image">☕</div>
        <div class="menu-item-content">
          <h3>Fresh Coffee</h3>
          <p>Premium roasted coffee beans brewed to perfection</p>
          <div class="menu-item-price">2000frw</div>
        </div>
      </div>

      <div class="menu-item" data-category="beverages">
        <div class="menu-item-image">🥤</div>
        <div class="menu-item-content">
          <h3>Fresh Juice</h3>
          <p>Seasonal fruits squeezed into refreshing beverages</p>
          <div class="menu-item-price">2000frw</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features" id="features">
    <h2>System Features</h2>
    <p class="features-subtitle">Enjoy Restaurant provides comprehensive tools to manage every aspect of your restaurant efficiently</p>

    <div class="feature-grid">
      <div class="feature-card" onclick="showFeature('order')">
        <div class="feature-icon">🧾</div>
        <h3>Order Management</h3>
        <p>Efficiently handle dine-in, takeaway, and delivery orders with our intuitive order management system.</p>
      </div>

      <div class="feature-card" onclick="showFeature('customer')">
        <div class="feature-icon">👥</div>
        <h3>Customer Management</h3>
        <p>Build customer relationships with loyalty programs, preferences tracking, and personalized service.</p>
      </div>

      <div class="feature-card" onclick="showFeature('staff')">
        <div class="feature-icon">👨‍🍳</div>
        <h3>Staff Coordination</h3>
        <p>Manage schedules, track performance, and streamline communication with your restaurant team.</p>
      </div>

      <div class="feature-card" onclick="showFeature('inventory')">
        <div class="feature-icon">📦</div>
        <h3>Inventory Control</h3>
        <p>Track ingredients, manage suppliers, and minimize waste with smart inventory solutions.</p>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section class="contact" id="contact">
    <h2>Contact Us</h2>
    <p class="contact-subtitle">Get in touch with our team for any inquiries or support</p>

    <div class="contact-grid">
      <div class="contact-card">
        <div class="contact-icon">📧</div>
        <h3>Email Us</h3>
        <p>enjoy01@gmail.com</p>
        <p>We'll respond within 24 hours</p>
      </div>

      <div class="contact-card">
        <div class="contact-icon">📞</div>
        <h3>Call Us</h3>
        <p>+250784456456</p>
        <p>Mon-Fri from 8am to 6pm</p>
      </div>

      <div class="contact-card">
        <div class="contact-icon">💬</div>
        <h3>Live Chat</h3>
        <p>Available 24/7</p>
        <p>Get instant support from our team</p>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section class="about" id="about">
    <h2>About Enjoy Restaurant system</h2>
    <div class="about-content">
      <p>Founded with a passion for great food and technology, Enjoy Restaurant was created to solve the complex challenges restaurant owners face every day. Our mission is to provide intuitive, powerful tools that help restaurants thrive in a competitive market.</p>
      
      <p>With years of experience in both the restaurant industry and software development, our team understands the unique needs of modern restaurants. We've designed Enjoy Restaurant to be the all-in-one solution that grows with your business.</p>
      
      <p>Our commitment to excellence drives us to continuously improve our platform, adding new features and enhancements based on customer feedback and industry trends.</p>

      <div class="about-stats">
        <div class="about-stat">
          <h3>5+</h3>
          <p>Years of Experience</p>
        </div>
        <div class="about-stat">
          <h3>1,200+</h3>
          <p>Restaurants Served</p>
        </div>
        <div class="about-stat">
          <h3>24/7</h3>
          <p>Customer Support</p>
        </div>
        <div class="about-stat">
          <h3>99%</h3>
          <p>Customer Satisfaction</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="footer-content">
      <div class="footer-brand">
        <div class="logo">
          <div class="logo-icon">🍽️</div>
          <span>Enjoy Restaurant</span>
        </div>
        <p>Streamlining restaurant operations with innovative technology solutions. Helping you focus on what matters most - creating unforgettable dining experiences.</p>
      </div>
      
      <div class="footer-links">
        <h4>Quick Links</h4>
        <ul>
          <li><a onclick="scrollToSection('home')">Home</a></li>
          <li><a onclick="scrollToSection('menu')">Menu</a></li>
          <li><a onclick="scrollToSection('features')">Features</a></li>
          <li><a onclick="scrollToSection('contact')">Contact</a></li>
          <li><a onclick="scrollToSection('about')">About</a></li>
        </ul>
      </div>
      
      <div class="footer-contact">
        <h4>Contact Info</h4>
        <p>📧 enjoy01@gmail.com</p>
        <p>📞 +250782344538</p>
        <p>📍 12 Restaurant field,Musanze City, Muhoza sector</p>
      </div>
      
      <div class="footer-social">
        <h4>Follow Us</h4>
        <div class="social-icons">
          <a href="#"><i class="fab fa-facebook"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-linkedin"></i></a>
        </div>
      </div>
    </div>
    
    <div class="footer-bottom">
      <p>&copy; 2024 Enjoy Restaurant Management System. All rights reserved.</p>
    </div>
  </footer>

  <!-- Login Modal - FIXED -->
  <div class="modal" id="loginModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Login to Enjoy Restaurant</h3>
        <button class="close-btn" onclick="closeModal('loginModal')">×</button>
      </div>
      <form id="loginForm" onsubmit="handleLogin(event)">
        <div class="modal-body">
          <div class="form-group">
            <label>Email Address</label>
            <input type="email" id="login_email" name="login_email" placeholder="Enter your email" required>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" id="login_password" name="login_password" placeholder="Enter your password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="cancel-btn" onclick="closeModal('loginModal')">Cancel</button>
          <button type="submit" class="login-submit-btn">Login</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Register Modal -->
  <div class="modal" id="registerModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Create Customer Account</h3>
        <button class="close-btn" onclick="closeModal('registerModal')">×</button>
      </div>
      <form id="registerForm" onsubmit="handleRegister(event)">
        <div class="modal-body">
          <div class="form-group">
            <label>First Name</label>
            <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
          </div>
          <div class="form-group">
            <label>Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
          </div>
          <div class="form-group">
            <label>Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
          </div>
          <div class="form-group">
            <label>Address</label>
            <input type="text" id="address" name="address" placeholder="Enter your address" required>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" id="password" name="password" placeholder="Create a password" required>
          </div>
          <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="cancel-btn" onclick="closeModal('registerModal')">Cancel</button>
          <button type="submit" class="register-submit-btn">Create Account</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Notification -->
  <div class="notification" id="notification"></div>

  <!-- Chat Button -->
  <button class="chat-btn" onclick="openChat()">
    <i class="fas fa-comments"></i>
  </button>

  <script>
    // Navigation function
    function scrollToSection(sectionId) {
      document.getElementById(sectionId).scrollIntoView({
        behavior: 'smooth'
      });
    }

    // Modal functions
    function openModal(modalId) {
      document.getElementById(modalId).style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
      document.getElementById(modalId).style.display = 'none';
      document.body.style.overflow = 'auto';
    }

    // Notification system
    function showNotification(message, type = 'success') {
      const notification = document.getElementById('notification');
      notification.textContent = message;
      notification.style.borderLeftColor = type === 'success' ? '#10b981' : '#ef4444';
      notification.style.display = 'block';
      
      setTimeout(() => {
        notification.style.animation = 'fadeOut 0.5s';
        setTimeout(() => {
          notification.style.display = 'none';
          notification.style.animation = '';
        }, 500);
      }, 3000);
    }

    // Menu filtering
    function filterMenu(category) {
      document.querySelectorAll('.category-btn').forEach(btn => {
        btn.classList.remove('active');
      });
      event.target.classList.add('active');
      
      const menuItems = document.querySelectorAll('.menu-item');
      menuItems.forEach(item => {
        if (category === 'all' || item.dataset.category === category) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
      });
    }

    // Feature demonstration
    function showFeature(feature) {
      const features = {
        order: "Our order management system streamlines the entire order process from placement to completion.",
        customer: "Build lasting relationships with comprehensive customer management tools.",
        staff: "Coordinate your team efficiently with smart scheduling and performance tracking.",
        inventory: "Keep your inventory optimized with real-time tracking and automated reordering."
      };
      
      showNotification(features[feature] || "Explore this feature in our demo!");
    }

    // FIXED: Login handler with AJAX
    function handleLogin(event) {
      event.preventDefault();
      
      const formData = {
        login_email: document.getElementById('login_email').value,
        login_password: document.getElementById('login_password').value
      };

      // Show loading state
      const submitBtn = event.target.querySelector('.login-submit-btn');
      const originalText = submitBtn.textContent;
      submitBtn.textContent = 'Logging in...';
      submitBtn.disabled = true;

      // Send AJAX request to login.php
      fetch('login.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(formData)
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          showNotification(data.message, 'success');
          setTimeout(() => {
            closeModal('loginModal');
            // Clear form
            document.getElementById('loginForm').reset();
            // Redirect to dashboard
            window.location.href = data.redirect || 'customer_dashboard.php';
          }, 1500);
        } else {
          showNotification(data.message, 'error');
          submitBtn.textContent = originalText;
          submitBtn.disabled = false;
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showNotification('Login failed. Please try again.', 'error');
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
      });
    }

    // Register handler
    function handleRegister(event) {
      event.preventDefault();
      
      const formData = {
        first_name: document.getElementById('first_name').value,
        last_name: document.getElementById('last_name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        address: document.getElementById('address').value,
        password: document.getElementById('password').value,
        confirm_password: document.getElementById('confirm_password').value
      };

      if (formData.password !== formData.confirm_password) {
        showNotification('Passwords do not match!', 'error');
        return;
      }

      if (formData.password.length < 6) {
        showNotification('Password must be at least 6 characters long!', 'error');
        return;
      }

      // Show loading state
      const submitBtn = event.target.querySelector('.register-submit-btn');
      const originalText = submitBtn.textContent;
      submitBtn.textContent = 'Creating Account...';
      submitBtn.disabled = true;

      // Simulate registration process
      setTimeout(() => {
        showNotification('Account created successfully! Welcome to Enjoy Restaurant!');
        
        setTimeout(() => {
          closeModal('registerModal');
          document.getElementById('registerForm').reset();
          window.location.href = 'customer_dashboard.php';
        }, 2000);
      }, 1000);
    }

    // Chat function
    function openChat() {
      showNotification('Chat support coming soon! Please contact us at support@enjoyrms.com');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
      if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
        document.body.style.overflow = 'auto';
      }
    }
  </script>
</body>
</html>