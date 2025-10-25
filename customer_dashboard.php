<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Customer Dashboard - Enjoy Restaurant</title>
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
      display: flex;
    }

    /* Sidebar Navigation */
    .sidebar {
      width: 260px;
      background: linear-gradient(180deg, #a74200 0%, #d97706 100%);
      color: white;
      height: 100vh;
      position: fixed;
      overflow-y: auto;
      transition: all 0.3s;
      z-index: 100;
      box-shadow: 4px 0 10px rgba(0,0,0,0.1);
    }

    .sidebar-header {
      padding: 25px 20px;
      border-bottom: 1px solid rgba(255,255,255,0.2);
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .logo-icon {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: rgba(255,255,255,0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
    }

    .logo-text {
      font-size: 20px;
      font-weight: bold;
    }

    .sidebar-menu {
      padding: 20px 0;
    }

    .menu-item {
      padding: 15px 25px;
      display: flex;
      align-items: center;
      gap: 15px;
      cursor: pointer;
      transition: all 0.3s;
      border-left: 4px solid transparent;
    }

    .menu-item:hover {
      background: rgba(255,255,255,0.1);
    }

    .menu-item.active {
      background: rgba(255,255,255,0.15);
      border-left-color: white;
    }

    .menu-item i {
      width: 20px;
      text-align: center;
      font-size: 18px;
    }

    .menu-text {
      font-size: 16px;
      font-weight: 500;
    }

    .sidebar-footer {
      padding: 20px;
      border-top: 1px solid rgba(255,255,255,0.2);
      position: absolute;
      bottom: 0;
      width: 100%;
    }

    .user-profile {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: rgba(255,255,255,0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }

    .user-info {
      flex: 1;
    }

    .user-name {
      font-weight: 600;
      font-size: 15px;
    }

    .user-role {
      font-size: 13px;
      opacity: 0.8;
    }

    .logout-btn {
      background: none;
      border: none;
      color: white;
      font-size: 18px;
      cursor: pointer;
      transition: color 0.3s;
    }

    .logout-btn:hover {
      opacity: 0.8;
    }

    /* Main Content */
    .main-content {
      flex: 1;
      margin-left: 260px;
      padding: 30px;
      transition: all 0.3s;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .page-title h1 {
      font-size: 28px;
      color: #a74200;
      margin-bottom: 5px;
    }

    .page-title p {
      color: #6b7280;
    }

    .top-bar-actions {
      display: flex;
      gap: 15px;
      align-items: center;
    }

    .search-box {
      position: relative;
    }

    .search-box input {
      padding: 12px 15px 12px 40px;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      width: 250px;
      font-size: 14px;
      background: white;
      transition: all 0.3s;
    }

    .search-box input:focus {
      outline: none;
      border-color: #a74200;
      box-shadow: 0 0 0 3px rgba(167, 66, 0, 0.1);
    }

    .search-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
    }

    .notification-icon, .cart-icon-top {
      width: 45px;
      height: 45px;
      border-radius: 10px;
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      color: #64748b;
      cursor: pointer;
      transition: all 0.3s;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      position: relative;
    }

    .notification-icon:hover, .cart-icon-top:hover {
      background: #f1f5f9;
      color: #a74200;
    }

    .notification-badge, .cart-badge-top {
      position: absolute;
      top: -5px;
      right: -5px;
      background: #ef4444;
      color: white;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      font-size: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Dashboard Stats */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 25px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: white;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .stat-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }

    .stat-icon {
      width: 50px;
      height: 50px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      color: white;
    }

    .stat-icon.orders {
      background: linear-gradient(135deg, #a74200 0%, #d97706 100%);
    }

    .stat-icon.points {
      background: linear-gradient(135deg, #8b5cf6 0%, #c084fc 100%);
    }

    .stat-icon.spent {
      background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    }

    .stat-icon.visits {
      background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
    }

    .stat-trend {
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 14px;
      font-weight: 600;
    }

    .trend-up {
      color: #10b981;
    }

    .trend-down {
      color: #ef4444;
    }

    .stat-value {
      font-size: 28px;
      font-weight: bold;
      color: #1e293b;
      margin-bottom: 5px;
    }

    .stat-label {
      color: #64748b;
      font-size: 14px;
    }

    /* Dashboard Content Grid */
    .content-grid {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 25px;
    }

    .content-card {
      background: white;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
      margin-bottom: 25px;
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .card-title {
      font-size: 20px;
      color: #1e293b;
      font-weight: 600;
    }

    .view-all {
      color: #a74200;
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
      cursor: pointer;
    }

    /* Recent Orders */
    .orders-table {
      width: 100%;
      border-collapse: collapse;
    }

    .orders-table th {
      text-align: left;
      padding: 15px;
      border-bottom: 2px solid #f1f5f9;
      color: #64748b;
      font-weight: 600;
      font-size: 14px;
    }

    .orders-table td {
      padding: 15px;
      border-bottom: 1px solid #f1f5f9;
    }

    .order-status {
      display: inline-block;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
    }

    .status-pending {
      background: #fef3c7;
      color: #d97706;
    }

    .status-confirmed {
      background: #dbeafe;
      color: #3b82f6;
    }

    .status-preparing {
      background: #f3e8ff;
      color: #8b5cf6;
    }

    .status-ready {
      background: #dcfce7;
      color: #16a34a;
    }

    .status-completed {
      background: #dcfce7;
      color: #16a34a;
    }

    .status-cancelled {
      background: #fecaca;
      color: #dc2626;
    }

    /* Quick Actions */
    .actions-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }

    .action-card {
      background: #f8fafc;
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s;
      border: 1px solid #e2e8f0;
    }

    .action-card:hover {
      background: white;
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      border-color: #a74200;
    }

    .action-icon {
      width: 50px;
      height: 50px;
      border-radius: 12px;
      background: linear-gradient(135deg, #a74200 0%, #d97706 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      color: white;
      margin: 0 auto 15px;
    }

    .action-title {
      font-weight: 600;
      margin-bottom: 5px;
      color: #1e293b;
    }

    .action-desc {
      color: #64748b;
      font-size: 13px;
    }

    /* Popular Items */
    .popular-items {
      display: grid;
      gap: 20px;
    }

    .popular-item {
      display: flex;
      align-items: center;
      gap: 15px;
      padding: 15px;
      border-radius: 12px;
      background: #f8fafc;
      transition: all 0.3s;
      cursor: pointer;
    }

    .popular-item:hover {
      background: white;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .item-image {
      width: 50px;
      height: 50px;
      border-radius: 10px;
      background: linear-gradient(135deg, #fde8e4 0%, #f3e5f5 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
    }

    .item-details {
      flex: 1;
    }

    .item-name {
      font-weight: 600;
      margin-bottom: 5px;
    }

    .item-price {
      color: #a74200;
      font-weight: 600;
    }

    .add-btn {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      background: #a74200;
      color: white;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: background 0.3s;
    }

    .add-btn:hover {
      background: #d97706;
    }

    /* Loyalty Card */
    .loyalty-card {
      background: linear-gradient(135deg, #a74200 0%, #d97706 100%);
      border-radius: 15px;
      padding: 25px;
      color: white;
      margin-bottom: 25px;
    }

    .loyalty-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .loyalty-title {
      font-size: 18px;
      font-weight: 600;
    }

    .loyalty-icon {
      font-size: 24px;
    }

    .loyalty-points {
      font-size: 32px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .loyalty-desc {
      font-size: 14px;
      opacity: 0.9;
      margin-bottom: 20px;
    }

    .progress-bar {
      height: 8px;
      background: rgba(255,255,255,0.2);
      border-radius: 4px;
      margin-bottom: 10px;
      overflow: hidden;
    }

    .progress {
      height: 100%;
      background: white;
      border-radius: 4px;
      width: 65%;
    }

    .progress-text {
      display: flex;
      justify-content: space-between;
      font-size: 12px;
    }

    /* Tab Content */
    .tab-content {
      display: none;
    }

    .tab-content.active {
      display: block;
    }

    /* Menu Grid */
    .menu-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 25px;
    }

    .menu-item-card {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .menu-item-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }

    .menu-item-image {
      height: 160px;
      background: linear-gradient(135deg, #fde8e4 0%, #f3e5f5 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 60px;
    }

    .menu-item-content {
      padding: 20px;
    }

    .menu-item-card h3 {
      font-size: 18px;
      color: #1e293b;
      margin-bottom: 10px;
    }

    .menu-item-card p {
      color: #6b7280;
      margin-bottom: 15px;
      line-height: 1.6;
      font-size: 14px;
    }

    .menu-item-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .menu-item-price {
      font-size: 20px;
      color: #a74200;
      font-weight: bold;
    }

    /* Form Styles */
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

    .form-group input, .form-group textarea, .form-group select {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid #e5e7eb;
      border-radius: 10px;
      font-size: 15px;
      transition: all 0.2s;
    }

    .form-group input:focus, .form-group textarea:focus, .form-group select:focus {
      outline: none;
      border-color: #a74200;
      box-shadow: 0 0 0 3px rgba(167, 66, 0, 0.1);
    }

    .form-actions {
      display: flex;
      gap: 15px;
      margin-top: 30px;
    }

    .btn {
      padding: 12px 25px;
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

    /* Mobile Toggle */
    .mobile-toggle {
      display: none;
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 101;
      background: #a74200;
      color: white;
      border: none;
      width: 45px;
      height: 45px;
      border-radius: 10px;
      font-size: 20px;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .content-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }
      
      .sidebar.active {
        transform: translateX(0);
      }
      
      .main-content {
        margin-left: 0;
        padding: 20px;
      }
      
      .mobile-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
      }
      
      .search-box input {
        width: 200px;
      }
      
      .stats-grid {
        grid-template-columns: 1fr 1fr;
      }
    }

    @media (max-width: 576px) {
      .stats-grid {
        grid-template-columns: 1fr;
      }
      
      .search-box input {
        width: 150px;
      }
      
      .actions-grid {
        grid-template-columns: 1fr;
      }
      
      .menu-grid {
        grid-template-columns: 1fr;
      }
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

    /* Favorites */
    .favorites-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 25px;
    }

    .favorite-item {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 6px rgba(0,0,0,0.05);
      transition: transform 0.3s, box-shadow 0.3s;
      position: relative;
    }

    .favorite-item:hover {
      transform: translateY(-10px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }

    .favorite-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      background: #ef4444;
      color: white;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
    }

    /* Loading Spinner */
    .loading {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 3px solid #f3f3f3;
      border-radius: 50%;
      border-top: 3px solid #a74200;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>
<body>
  <!-- Mobile Toggle -->
  <button class="mobile-toggle" id="mobileToggle">
    <i class="fas fa-bars"></i>
  </button>

  <!-- Sidebar Navigation -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="logo-icon">🍽️</div>
      <div class="logo-text">Enjoy Restaurant</div>
    </div>
    
    <div class="sidebar-menu">
      <div class="menu-item active" onclick="switchTab('dashboard')">
        <i class="fas fa-home"></i>
        <span class="menu-text">Dashboard</span>
      </div>
      <div class="menu-item" onclick="switchTab('orders')">
        <i class="fas fa-list-alt"></i>
        <span class="menu-text">My Orders</span>
      </div>
      <div class="menu-item" onclick="switchTab('menu')">
        <i class="fas fa-utensils"></i>
        <span class="menu-text">Menu</span>
      </div>
      <div class="menu-item" onclick="switchTab('reservations')">
        <i class="fas fa-calendar-alt"></i>
        <span class="menu-text">Reservations</span>
      </div>
      <div class="menu-item" onclick="switchTab('favorites')">
        <i class="fas fa-heart"></i>
        <span class="menu-text">Favorites</span>
      </div>
      <div class="menu-item" onclick="switchTab('profile')">
        <i class="fas fa-user"></i>
        <span class="menu-text">Profile</span>
      </div>
      <div class="menu-item" onclick="switchTab('settings')">
        <i class="fas fa-cog"></i>
        <span class="menu-text">Settings</span>
      </div>
    </div>
    
    <div class="sidebar-footer">
      <div class="user-profile">
        <div class="user-avatar" id="userAvatar">JD</div>
        <div class="user-info">
          <div class="user-name" id="userName">Loading...</div>
          <div class="user-role" id="userRole">Customer</div>
        </div>
        <button class="logout-btn" onclick="logout()">
          <i class="fas fa-sign-out-alt"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Dashboard Tab -->
    <div id="dashboard-tab" class="tab-content active">
      <div class="top-bar">
        <div class="page-title">
          <h1 id="welcomeTitle">Welcome back!</h1>
          <p>Here's what's happening with your restaurant experience</p>
        </div>
        
        <div class="top-bar-actions">
          <div class="search-box">
            <i class="fas fa-search search-icon"></i>
            <input type="text" placeholder="Search..." id="searchInput">
          </div>
          <div class="notification-icon">
            <i class="fas fa-bell"></i>
            <span class="notification-badge" id="notificationCount">0</span>
          </div>
          <div class="cart-icon-top" onclick="openCart()">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-badge-top" id="cartCount">0</span>
          </div>
        </div>
      </div>
      
      <!-- Stats Grid -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-icon orders">
              <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="stat-trend trend-up">
              <i class="fas fa-arrow-up"></i>
              <span id="ordersTrend">0%</span>
            </div>
          </div>
          <div class="stat-value" id="totalOrders">0</div>
          <div class="stat-label">Total Orders</div>
        </div>
        
        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-icon points">
              <i class="fas fa-star"></i>
            </div>
            <div class="stat-trend trend-up">
              <i class="fas fa-arrow-up"></i>
              <span id="pointsTrend">0%</span>
            </div>
          </div>
          <div class="stat-value" id="loyaltyPoints">0</div>
          <div class="stat-label">Loyalty Points</div>
        </div>
        
        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-icon spent">
              <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-trend trend-up">
              <i class="fas fa-arrow-up"></i>
              <span id="spentTrend">0%</span>
            </div>
          </div>
          <div class="stat-value" id="totalSpent">0frw</div>
          <div class="stat-label">Total Spent</div>
        </div>
        
        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-icon visits">
              <i class="fas fa-utensils"></i>
            </div>
            <div class="stat-trend trend-up">
              <i class="fas fa-arrow-up"></i>
              <span id="visitsTrend">0%</span>
            </div>
          </div>
          <div class="stat-value" id="totalVisits">0</div>
          <div class="stat-label">Restaurant Visits</div>
        </div>
      </div>
      
      <!-- Content Grid -->
      <div class="content-grid">
        <div class="content-column">
          <!-- Recent Orders -->
          <div class="content-card">
            <div class="card-header">
              <div class="card-title">Recent Orders</div>
              <a class="view-all" onclick="switchTab('orders')">View All</a>
            </div>
            <div id="recentOrders">
              <table class="orders-table">
                <thead>
                  <tr>
                    <th>Order #</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Amount</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="recentOrdersBody">
                  <tr>
                    <td colspan="5" style="text-align: center; padding: 40px;">
                      <div class="loading"></div>
                      <p style="margin-top: 10px;">Loading orders...</p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          
          <!-- Quick Actions -->
          <div class="content-card">
            <div class="card-header">
              <div class="card-title">Quick Actions</div>
            </div>
            <div class="actions-grid">
              <div class="action-card" onclick="switchTab('menu')">
                <div class="action-icon">
                  <i class="fas fa-utensils"></i>
                </div>
                <div class="action-title">Order Food</div>
                <div class="action-desc">Browse our menu</div>
              </div>
              <div class="action-card" onclick="switchTab('reservations')">
                <div class="action-icon">
                  <i class="fas fa-calendar-plus"></i>
                </div>
                <div class="action-title">Make Reservation</div>
                <div class="action-desc">Book a table</div>
              </div>
              <div class="action-card" onclick="redeemPoints()">
                <div class="action-icon">
                  <i class="fas fa-gift"></i>
                </div>
                <div class="action-title">Redeem Points</div>
                <div class="action-desc">Use your loyalty points</div>
              </div>
              <div class="action-card" onclick="getHelp()">
                <div class="action-icon">
                  <i class="fas fa-question-circle"></i>
                </div>
                <div class="action-title">Get Help</div>
                <div class="action-desc">Contact support</div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="content-column">
          <!-- Loyalty Card -->
          <div class="loyalty-card">
            <div class="loyalty-header">
              <div class="loyalty-title">Loyalty Status</div>
              <div class="loyalty-icon" id="loyaltyIcon">
                <i class="fas fa-crown"></i>
              </div>
            </div>
            <div class="loyalty-points" id="loyaltyPointsDisplay">0 Points</div>
            <div class="loyalty-desc" id="loyaltyDescription">Start earning points with your first order!</div>
            <div class="progress-bar">
              <div class="progress" id="loyaltyProgress"></div>
            </div>
            <div class="progress-text">
              <span id="currentTier">Bronze</span>
              <span id="nextTier">Silver</span>
            </div>
          </div>
          
          <!-- Popular Items -->
          <div class="content-card">
            <div class="card-header">
              <div class="card-title">Popular Items</div>
            </div>
            <div class="popular-items" id="popularItems">
              <div class="popular-item">
                <div class="item-image">🍝</div>
                <div class="item-details">
                  <div class="item-name">Spaghetti Carbonara</div>
                  <div class="item-price">5,000frw</div>
                </div>
                <button class="add-btn" onclick="addToCart('Spaghetti Carbonara', 5000)">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
              <div class="popular-item">
                <div class="item-image">🐟</div>
                <div class="item-details">
                  <div class="item-name">Grilled Salmon</div>
                  <div class="item-price">15,000frw</div>
                </div>
                <button class="add-btn" onclick="addToCart('Grilled Salmon', 15000)">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
              <div class="popular-item">
                <div class="item-image">🍕</div>
                <div class="item-details">
                  <div class="item-name">Pizza Margherita</div>
                  <div class="item-price">12,000frw</div>
                </div>
                <button class="add-btn" onclick="addToCart('Pizza Margherita', 12000)">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Orders Tab -->
    <div id="orders-tab" class="tab-content">
      <div class="top-bar">
        <div class="page-title">
          <h1>My Orders</h1>
          <p>View your order history and track current orders</p>
        </div>
      </div>
      
      <div class="content-card">
        <div class="card-header">
          <div class="card-title">Order History</div>
        </div>
        <div id="allOrders">
          <table class="orders-table">
            <thead>
              <tr>
                <th>Order #</th>
                <th>Date</th>
                <th>Items</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="allOrdersBody">
              <tr>
                <td colspan="6" style="text-align: center; padding: 40px;">
                  <div class="loading"></div>
                  <p style="margin-top: 10px;">Loading orders...</p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Menu Tab -->
    <div id="menu-tab" class="tab-content">
      <div class="top-bar">
        <div class="page-title">
          <h1>Our Menu</h1>
          <p>Discover our delicious offerings</p>
        </div>
      </div>
      
      <div class="menu-grid" id="menuItems">
        <!-- Menu items will be loaded dynamically -->
      </div>
    </div>

    <!-- Reservations Tab -->
    <div id="reservations-tab" class="tab-content">
      <div class="top-bar">
        <div class="page-title">
          <h1>My Reservations</h1>
          <p>Manage your table bookings</p>
        </div>
        <button class="btn btn-primary" onclick="openReservationModal()">
          <i class="fas fa-plus"></i> New Reservation
        </button>
      </div>
      
      <div class="content-card">
        <div class="card-header">
          <div class="card-title">Upcoming Reservations</div>
        </div>
        <div id="upcomingReservations">
          <table class="orders-table">
            <thead>
              <tr>
                <th>Date & Time</th>
                <th>Guests</th>
                <th>Table</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="upcomingReservationsBody">
              <tr>
                <td colspan="5" style="text-align: center; padding: 40px;">
                  <div class="loading"></div>
                  <p style="margin-top: 10px;">Loading reservations...</p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      
      <div class="content-card">
        <div class="card-header">
          <div class="card-title">Past Reservations</div>
        </div>
        <div id="pastReservations">
          <table class="orders-table">
            <thead>
              <tr>
                <th>Date & Time</th>
                <th>Guests</th>
                <th>Table</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="pastReservationsBody">
              <tr>
                <td colspan="4" style="text-align: center; padding: 40px;">
                  <div class="loading"></div>
                  <p style="margin-top: 10px;">Loading reservations...</p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Favorites Tab -->
    <div id="favorites-tab" class="tab-content">
      <div class="top-bar">
        <div class="page-title">
          <h1>My Favorites</h1>
          <p>Your most-loved menu items</p>
        </div>
      </div>
      
      <div class="favorites-grid" id="favoritesList">
        <!-- Favorites will be loaded dynamically -->
      </div>
    </div>

    <!-- Profile Tab -->
    <div id="profile-tab" class="tab-content">
      <div class="top-bar">
        <div class="page-title">
          <h1>My Profile</h1>
          <p>Manage your personal information</p>
        </div>
      </div>
      
      <div class="content-card">
        <form id="profileForm">
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" required>
          </div>
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" required>
          </div>
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" required>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <textarea id="address" name="address" rows="3" required></textarea>
          </div>
          <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="resetProfileForm()">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Settings Tab -->
    <div id="settings-tab" class="tab-content">
      <div class="top-bar">
        <div class="page-title">
          <h1>Settings</h1>
          <p>Customize your experience</p>
        </div>
      </div>
      
      <div class="content-card">
        <div class="card-header">
          <div class="card-title">Notification Preferences</div>
        </div>
        <div class="form-group">
          <label>
            <input type="checkbox" id="notifOrders" checked> Order updates
          </label>
        </div>
        <div class="form-group">
          <label>
            <input type="checkbox" id="notifReservations" checked> Reservation reminders
          </label>
        </div>
        <div class="form-group">
          <label>
            <input type="checkbox" id="notifOffers"> Special offers and promotions
          </label>
        </div>
        <div class="form-group">
          <label>
            <input type="checkbox" id="notifLoyalty" checked> Loyalty program updates
          </label>
        </div>
      </div>
      
      <div class="content-card">
        <div class="card-header">
          <div class="card-title">Privacy Settings</div>
        </div>
        <div class="form-group">
          <label>
            <input type="checkbox" id="privacyRecommendations" checked> Allow personalized recommendations
          </label>
        </div>
        <div class="form-group">
          <label>
            <input type="checkbox" id="privacyDataSharing"> Share my data with partners
          </label>
        </div>
      </div>
      
      <div class="form-actions">
        <button type="button" class="btn btn-secondary" onclick="resetSettings()">Reset to Defaults</button>
        <button type="button" class="btn btn-primary" onclick="saveSettings()">Save Settings</button>
      </div>
    </div>
  </div>

  <!-- Notification -->
  <div class="notification" id="notification"></div>

  <script>
    // Global variables
    let userData = {};
    let cartItems = [];
    let menuItems = [];
    let userOrders = [];
    let userReservations = [];

    // Initialize dashboard when page loads
    document.addEventListener('DOMContentLoaded', function() {
      loadUserData();
      loadDashboardData();
      loadMenuItems();
      loadUserOrders();
      loadUserReservations();
      loadUserFavorites();
    });

    // Load user data from session
    async function loadUserData() {
      try {
        // Simulate API call - replace with actual PHP endpoint
        const userDataResponse = await simulateApiCall('get_user_data');
        if (userDataResponse.success) {
          userData = userDataResponse.user;
          updateUserInterface();
        } else {
          showNotification('Error loading user data', 'error');
        }
      } catch (error) {
        console.error('Error:', error);
        showNotification('Error loading user data', 'error');
      }
    }

    // Update UI with user data
    function updateUserInterface() {
      document.getElementById('userName').textContent = `${userData.first_name} ${userData.last_name}`;
      document.getElementById('userAvatar').textContent = `${userData.first_name[0]}${userData.last_name[0]}`;
      document.getElementById('welcomeTitle').textContent = `Welcome back, ${userData.first_name}!`;
      
      // Update profile form
      document.getElementById('first_name').value = userData.first_name;
      document.getElementById('last_name').value = userData.last_name;
      document.getElementById('email').value = userData.email;
      document.getElementById('phone').value = userData.phone || '';
      document.getElementById('address').value = userData.address || '';
    }

    // Load dashboard statistics
    async function loadDashboardData() {
      try {
        const dashboardResponse = await simulateApiCall('get_dashboard_data');
        if (dashboardResponse.success) {
          updateDashboardStats(dashboardResponse.stats);
          updateLoyaltyCard(dashboardResponse.loyalty);
        } else {
          showNotification('Error loading dashboard data', 'error');
        }
      } catch (error) {
        console.error('Error:', error);
        showNotification('Error loading dashboard data', 'error');
      }
    }

    // Update dashboard statistics
    function updateDashboardStats(stats) {
      document.getElementById('totalOrders').textContent = stats.total_orders;
      document.getElementById('loyaltyPoints').textContent = stats.loyalty_points;
      document.getElementById('totalSpent').textContent = `${stats.total_spent}frw`;
      document.getElementById('totalVisits').textContent = stats.total_visits;
    }

    // Update loyalty card
    function updateLoyaltyCard(loyalty) {
      document.getElementById('loyaltyPointsDisplay').textContent = `${loyalty.points} Points`;
      document.getElementById('loyaltyDescription').textContent = loyalty.description;
      document.getElementById('loyaltyProgress').style.width = `${loyalty.progress}%`;
      document.getElementById('currentTier').textContent = loyalty.current_tier;
      document.getElementById('nextTier').textContent = loyalty.next_tier;
      
      // Update loyalty icon based on tier
      const loyaltyIcon = document.getElementById('loyaltyIcon');
      if (loyalty.current_tier === 'Platinum') {
        loyaltyIcon.innerHTML = '<i class="fas fa-crown"></i>';
      } else if (loyalty.current_tier === 'Gold') {
        loyaltyIcon.innerHTML = '<i class="fas fa-award"></i>';
      } else {
        loyaltyIcon.innerHTML = '<i class="fas fa-star"></i>';
      }
    }

    // Load menu items
    async function loadMenuItems() {
      try {
        const menuResponse = await simulateApiCall('get_menu_items');
        if (menuResponse.success) {
          menuItems = menuResponse.menu_items;
          displayMenuItems();
        } else {
          showNotification('Error loading menu items', 'error');
        }
      } catch (error) {
        console.error('Error:', error);
        showNotification('Error loading menu items', 'error');
      }
    }

    // Display menu items in the menu tab
    function displayMenuItems() {
      const menuGrid = document.getElementById('menuItems');
      menuGrid.innerHTML = '';
      
      menuItems.forEach(item => {
        const menuItemCard = document.createElement('div');
        menuItemCard.className = 'menu-item-card';
        menuItemCard.innerHTML = `
          <div class="menu-item-image">${item.emoji || '🍽️'}</div>
          <div class="menu-item-content">
            <h3>${item.name}</h3>
            <p>${item.description}</p>
            <div class="menu-item-footer">
              <div class="menu-item-price">${item.price}frw</div>
              <button class="add-btn" onclick="addToCart('${item.name}', ${item.price})">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
        `;
        menuGrid.appendChild(menuItemCard);
      });
    }

    // Load user orders
    async function loadUserOrders() {
      try {
        const ordersResponse = await simulateApiCall('get_user_orders');
        if (ordersResponse.success) {
          userOrders = ordersResponse.orders;
          displayRecentOrders();
          displayAllOrders();
        } else {
          showNotification('Error loading orders', 'error');
        }
      } catch (error) {
        console.error('Error:', error);
        showNotification('Error loading orders', 'error');
      }
    }

    // Display recent orders in dashboard
    function displayRecentOrders() {
      const recentOrdersBody = document.getElementById('recentOrdersBody');
      recentOrdersBody.innerHTML = '';
      
      const recentOrders = userOrders.slice(0, 3); // Show only 3 most recent
      
      if (recentOrders.length === 0) {
        recentOrdersBody.innerHTML = `
          <tr>
            <td colspan="5" style="text-align: center; padding: 40px;">
              <p>No orders yet. Start ordering now!</p>
            </td>
          </tr>
        `;
        return;
      }
      
      recentOrders.forEach(order => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>#${order.order_number}</td>
          <td>${formatDate(order.order_date)}</td>
          <td>${order.items}</td>
          <td>${order.amount}frw</td>
          <td><span class="order-status status-${order.status}">${order.status}</span></td>
        `;
        recentOrdersBody.appendChild(row);
      });
    }

    // Display all orders in orders tab
    function displayAllOrders() {
      const allOrdersBody = document.getElementById('allOrdersBody');
      allOrdersBody.innerHTML = '';
      
      if (userOrders.length === 0) {
        allOrdersBody.innerHTML = `
          <tr>
            <td colspan="6" style="text-align: center; padding: 40px;">
              <p>No orders yet. Start ordering now!</p>
            </td>
          </tr>
        `;
        return;
      }
      
      userOrders.forEach(order => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>#${order.order_number}</td>
          <td>${formatDate(order.order_date)}</td>
          <td>${order.items}</td>
          <td>${order.amount}frw</td>
          <td><span class="order-status status-${order.status}">${order.status}</span></td>
          <td><button class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px;" onclick="reorder('${order.order_number}')">Reorder</button></td>
        `;
        allOrdersBody.appendChild(row);
      });
    }

    // Load user reservations
    async function loadUserReservations() {
      try {
        const reservationsResponse = await simulateApiCall('get_user_reservations');
        if (reservationsResponse.success) {
          userReservations = reservationsResponse.reservations;
          displayReservations();
        } else {
          showNotification('Error loading reservations', 'error');
        }
      } catch (error) {
        console.error('Error:', error);
        showNotification('Error loading reservations', 'error');
      }
    }

    // Display reservations
    function displayReservations() {
      const upcomingReservationsBody = document.getElementById('upcomingReservationsBody');
      const pastReservationsBody = document.getElementById('pastReservationsBody');
      
      upcomingReservationsBody.innerHTML = '';
      pastReservationsBody.innerHTML = '';
      
      const now = new Date();
      const upcoming = userReservations.filter(res => new Date(res.date_time) > now);
      const past = userReservations.filter(res => new Date(res.date_time) <= now);
      
      // Upcoming reservations
      if (upcoming.length === 0) {
        upcomingReservationsBody.innerHTML = `
          <tr>
            <td colspan="5" style="text-align: center; padding: 40px;">
              <p>No upcoming reservations</p>
            </td>
          </tr>
        `;
      } else {
        upcoming.forEach(reservation => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${formatDateTime(reservation.date_time)}</td>
            <td>${reservation.guests} people</td>
            <td>Table #${reservation.table_number}</td>
            <td><span class="order-status status-${reservation.status}">${reservation.status}</span></td>
            <td><button class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px;" onclick="modifyReservation(${reservation.id})">Modify</button></td>
          `;
          upcomingReservationsBody.appendChild(row);
        });
      }
      
      // Past reservations
      if (past.length === 0) {
        pastReservationsBody.innerHTML = `
          <tr>
            <td colspan="4" style="text-align: center; padding: 40px;">
              <p>No past reservations</p>
            </td>
          </tr>
        `;
      } else {
        past.forEach(reservation => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${formatDateTime(reservation.date_time)}</td>
            <td>${reservation.guests} people</td>
            <td>Table #${reservation.table_number}</td>
            <td><span class="order-status status-${reservation.status}">${reservation.status}</span></td>
          `;
          pastReservationsBody.appendChild(row);
        });
      }
    }

    // Load user favorites
    async function loadUserFavorites() {
      try {
        const favoritesResponse = await simulateApiCall('get_user_favorites');
        if (favoritesResponse.success) {
          displayFavorites(favoritesResponse.favorites);
        }
      } catch (error) {
        console.error('Error:', error);
        // Don't show error for favorites as they might not exist
      }
    }

    // Display favorites
    function displayFavorites(favorites) {
      const favoritesList = document.getElementById('favoritesList');
      favoritesList.innerHTML = '';
      
      if (favorites.length === 0) {
        favoritesList.innerHTML = `
          <div style="text-align: center; padding: 40px; grid-column: 1 / -1;">
            <p>No favorites yet. Start adding items to your favorites!</p>
          </div>
        `;
        return;
      }
      
      favorites.forEach(item => {
        const favoriteItem = document.createElement('div');
        favoriteItem.className = 'favorite-item';
        favoriteItem.innerHTML = `
          <div class="favorite-badge">
            <i class="fas fa-heart"></i>
          </div>
          <div class="menu-item-image">${item.emoji || '🍽️'}</div>
          <div class="menu-item-content">
            <h3>${item.name}</h3>
            <p>${item.description}</p>
            <div class="menu-item-footer">
              <div class="menu-item-price">${item.price}frw</div>
              <button class="add-btn" onclick="addToCart('${item.name}', ${item.price})">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
        `;
        favoritesList.appendChild(favoriteItem);
      });
    }

    // Simulate API calls - replace with actual fetch calls to your PHP files
    function simulateApiCall(endpoint) {
      return new Promise((resolve) => {
        setTimeout(() => {
          // Sample data - replace with actual data from your database
          const sampleData = {
            'get_user_data': {
              success: true,
              user: {
                customer_id: 1,
                first_name: 'John',
                last_name: 'Doe',
                email: 'john.doe@example.com',
                phone: '+250784456456',
                address: '12 Restaurant field, Musanze City, Muhoza sector',
                loyalty_points: 1250,
                total_orders: 24,
                total_spent: 85000,
                total_visits: 18
              }
            },
            'get_dashboard_data': {
              success: true,
              stats: {
                total_orders: 24,
                loyalty_points: 1250,
                total_spent: 85000,
                total_visits: 18
              },
              loyalty: {
                points: 1250,
                current_tier: 'Gold',
                next_tier: 'Platinum',
                progress: 25,
                description: 'Earn 750 more points to reach Platinum status'
              }
            },
            'get_menu_items': {
              success: true,
              menu_items: [
                {
                  item_id: 1,
                  name: "Spaghetti Carbonara",
                  description: "Classic pasta with creamy sauce, bacon, and parmesan cheese",
                  price: 5000,
                  category: "pasta",
                  emoji: "🍝"
                },
                {
                  item_id: 2,
                  name: "Grilled Salmon",
                  description: "Fresh salmon with lemon butter sauce and seasonal vegetables",
                  price: 15000,
                  category: "seafood",
                  emoji: "🐟"
                },
                {
                  item_id: 3,
                  name: "Pizza Margherita",
                  description: "Traditional pizza with tomato sauce, mozzarella, and fresh basil",
                  price: 12000,
                  category: "pizza",
                  emoji: "🍕"
                },
                {
                  item_id: 4,
                  name: "Grilled Chicken",
                  description: "Juicy chicken breast with herbs and served with roasted potatoes",
                  price: 10000,
                  category: "chicken",
                  emoji: "🍗"
                },
                {
                  item_id: 5,
                  name: "Caesar Salad",
                  description: "Fresh romaine lettuce with Caesar dressing, croutons, and parmesan",
                  price: 8000,
                  category: "salad",
                  emoji: "🥗"
                },
                {
                  item_id: 6,
                  name: "Tiramisu",
                  description: "Classic Italian dessert with coffee-soaked ladyfingers and mascarpone",
                  price: 5000,
                  category: "dessert",
                  emoji: "🍰"
                }
              ]
            },
            'get_user_orders': {
              success: true,
              orders: [
                {
                  order_number: "ORD-0125",
                  order_date: "2023-10-15",
                  items: "Spaghetti, Garlic Bread",
                  amount: 6500,
                  status: "completed"
                },
                {
                  order_number: "ORD-0124",
                  order_date: "2023-10-12",
                  items: "Grilled Salmon, Juice",
                  amount: 17000,
                  status: "completed"
                },
                {
                  order_number: "ORD-0123",
                  order_date: "2023-10-10",
                  items: "Pizza, Tiramisu",
                  amount: 20000,
                  status: "completed"
                }
              ]
            },
            'get_user_reservations': {
              success: true,
              reservations: [
                {
                  id: 1,
                  date_time: "2023-10-25T19:00:00",
                  guests: 4,
                  table_number: 12,
                  status: "confirmed"
                },
                {
                  id: 2,
                  date_time: "2023-10-28T20:30:00",
                  guests: 2,
                  table_number: 5,
                  status: "confirmed"
                }
              ]
            },
            'get_user_favorites': {
              success: true,
              favorites: [
                {
                  item_id: 1,
                  name: "Spaghetti Carbonara",
                  description: "Classic pasta with creamy sauce, bacon, and parmesan cheese",
                  price: 5000,
                  emoji: "🍝"
                },
                {
                  item_id: 2,
                  name: "Grilled Salmon",
                  description: "Fresh salmon with lemon butter sauce and seasonal vegetables",
                  price: 15000,
                  emoji: "🐟"
                }
              ]
            }
          };
          
          resolve(sampleData[endpoint] || { success: false, message: 'Endpoint not found' });
        }, 500); // Simulate network delay
      });
    }

    // Add item to cart
    function addToCart(itemName, itemPrice) {
      cartItems.push({ name: itemName, price: itemPrice });
      updateCartCount();
      showNotification(`${itemName} added to cart!`);
    }

    // Update cart count
    function updateCartCount() {
      document.getElementById('cartCount').textContent = cartItems.length;
    }

    // Format date for display
    function formatDate(dateString) {
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('en-US', options);
    }

    // Format date and time for display
    function formatDateTime(dateTimeString) {
      const options = { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      };
      return new Date(dateTimeString).toLocaleDateString('en-US', options);
    }

    // Mobile sidebar toggle
    document.getElementById('mobileToggle').addEventListener('click', function() {
      document.getElementById('sidebar').classList.toggle('active');
    });

    // Tab switching
    function switchTab(tabName) {
      // Update active menu item
      document.querySelectorAll('.menu-item').forEach(item => {
        item.classList.remove('active');
      });
      event.currentTarget.classList.add('active');
      
      // Hide all tab content
      document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
      });
      
      // Show selected tab content
      document.getElementById(`${tabName}-tab`).classList.add('active');
    }

    // Logout function
    function logout() {
      if (confirm('Are you sure you want to logout?')) {
        window.location.href = 'logout.php';
      }
    }

    // Open cart function
    function openCart() {
      if (cartItems.length === 0) {
        showNotification('Your cart is empty. Add some items first!');
        return;
      }
      showNotification(`Cart has ${cartItems.length} items. Checkout functionality would open here.`);
    }

    // Notification system
    function showNotification(message, type = 'success') {
      const notification = document.getElementById('notification');
      notification.textContent = message;
      notification.style.borderLeftColor = type === 'success' ? '#10b981' : '#ef4444';
      notification.style.display = 'block';
      
      setTimeout(() => {
        notification.style.display = 'none';
      }, 3000);
    }

    // Profile form submission
    document.getElementById('profileForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      
      try {
        // Simulate API call - replace with actual fetch to update_profile.php
        const response = await simulateApiCall('update_profile');
        
        if (response.success) {
          showNotification('Profile updated successfully!');
          // Update local user data
          userData.first_name = document.getElementById('first_name').value;
          userData.last_name = document.getElementById('last_name').value;
          userData.email = document.getElementById('email').value;
          userData.phone = document.getElementById('phone').value;
          userData.address = document.getElementById('address').value;
          updateUserInterface();
        } else {
          showNotification(response.message || 'Error updating profile', 'error');
        }
      } catch (error) {
        console.error('Error:', error);
        showNotification('Error updating profile', 'error');
      }
    });

    // Reset profile form
    function resetProfileForm() {
      document.getElementById('first_name').value = userData.first_name;
      document.getElementById('last_name').value = userData.last_name;
      document.getElementById('email').value = userData.email;
      document.getElementById('phone').value = userData.phone || '';
      document.getElementById('address').value = userData.address || '';
    }

    // Save settings
    async function saveSettings() {
      const settings = {
        notifOrders: document.getElementById('notifOrders').checked,
        notifReservations: document.getElementById('notifReservations').checked,
        notifOffers: document.getElementById('notifOffers').checked,
        notifLoyalty: document.getElementById('notifLoyalty').checked,
        privacyRecommendations: document.getElementById('privacyRecommendations').checked,
        privacyDataSharing: document.getElementById('privacyDataSharing').checked
      };
      
      try {
        // Simulate API call - replace with actual fetch to save_settings.php
        const response = await simulateApiCall('save_settings');
        
        if (response.success) {
          showNotification('Settings saved successfully!');
        } else {
          showNotification('Error saving settings', 'error');
        }
      } catch (error) {
        console.error('Error:', error);
        showNotification('Error saving settings', 'error');
      }
    }

    // Reset settings to defaults
    function resetSettings() {
      document.getElementById('notifOrders').checked = true;
      document.getElementById('notifReservations').checked = true;
      document.getElementById('notifOffers').checked = false;
      document.getElementById('notifLoyalty').checked = true;
      document.getElementById('privacyRecommendations').checked = true;
      document.getElementById('privacyDataSharing').checked = false;
    }

    // Redeem points
    function redeemPoints() {
      showNotification('Points redemption feature coming soon!');
    }

    // Get help
    function getHelp() {
      showNotification('Contact support at enjoy01@gmail.com or call +250784456456');
    }

    // Reorder function
    function reorder(orderNumber) {
      showNotification(`Reordering items from order ${orderNumber}`);
    }

    // Open reservation modal
    function openReservationModal() {
      showNotification('New reservation modal would open here');
    }

    // Modify reservation
    function modifyReservation(reservationId) {
      showNotification(`Modifying reservation #${reservationId}`);
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
      const sidebar = document.getElementById('sidebar');
      const toggle = document.getElementById('mobileToggle');
      
      if (window.innerWidth <= 768 && 
          !sidebar.contains(event.target) && 
          !toggle.contains(event.target) && 
          sidebar.classList.contains('active')) {
        sidebar.classList.remove('active');
      }
    });
  </script>
</body>
</html>