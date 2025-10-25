<?php
// admin_dashboard.php
session_start();

// Check if admin is logged in (you'll need to implement admin authentication)
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Enjoy Restaurant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            color: #333;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1e293b 0%, #334155 100%);
            color: white;
            height: 100vh;
            position: fixed;
            overflow-y: auto;
            transition: all 0.3s;
            z-index: 100;
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #a74200 0%, #d97706 100%);
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
            background: rgba(255,255,255,0.05);
        }

        .menu-item.active {
            background: rgba(167, 66, 0, 0.2);
            border-left-color: #a74200;
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
            border-top: 1px solid rgba(255,255,255,0.1);
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #a74200 0%, #d97706 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
        }

        .admin-info {
            flex: 1;
        }

        .admin-name {
            font-weight: 600;
            font-size: 15px;
        }

        .admin-role {
            font-size: 13px;
            color: #94a3b8;
        }

        .logout-btn {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 18px;
            cursor: pointer;
            transition: color 0.3s;
        }

        .logout-btn:hover {
            color: white;
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
            color: #1e293b;
            margin-bottom: 5px;
        }

        .page-title p {
            color: #64748b;
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

        .notification-icon {
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

        .notification-icon:hover {
            background: #f1f5f9;
            color: #a74200;
        }

        .notification-badge {
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

        /* Stats Grid */
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
            border-left: 4px solid;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .stat-card.revenue {
            border-left-color: #10b981;
        }

        .stat-card.orders {
            border-left-color: #a74200;
        }

        .stat-card.customers {
            border-left-color: #8b5cf6;
        }

        .stat-card.reservations {
            border-left-color: #f59e0b;
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

        .stat-icon.revenue {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }

        .stat-icon.orders {
            background: linear-gradient(135deg, #a74200 0%, #d97706 100%);
        }

        .stat-icon.customers {
            background: linear-gradient(135deg, #8b5cf6 0%, #c084fc 100%);
        }

        .stat-icon.reservations {
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

        /* Content Grid */
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

        /* Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #f1f5f9;
            color: #64748b;
            font-weight: 600;
            font-size: 14px;
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        .status-badge {
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

        .status-completed {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-cancelled {
            background: #fecaca;
            color: #dc2626;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #a74200 0%, #d97706 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(167, 66, 0, 0.3);
        }

        .btn-secondary {
            background: white;
            color: #a74200;
            border: 1px solid #f0d5be;
        }

        .btn-secondary:hover {
            border-color: #a74200;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
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

        /* Recent Activity */
        .activity-list {
            display: grid;
            gap: 15px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 10px;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #a74200 0%, #d97706 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .activity-details {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .activity-time {
            color: #64748b;
            font-size: 12px;
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
            <div class="menu-item" onclick="switchTab('customers')">
                <i class="fas fa-users"></i>
                <span class="menu-text">Customers</span>
            </div>
            <div class="menu-item" onclick="switchTab('menu')">
                <i class="fas fa-utensils"></i>
                <span class="menu-text">Menu Management</span>
            </div>
            <div class="menu-item" onclick="switchTab('orders')">
                <i class="fas fa-shopping-bag"></i>
                <span class="menu-text">Orders</span>
            </div>
            <div class="menu-item" onclick="switchTab('reservations')">
                <i class="fas fa-calendar-alt"></i>
                <span class="menu-text">Reservations</span>
            </div>
            <div class="menu-item" onclick="switchTab('reports')">
                <i class="fas fa-chart-bar"></i>
                <span class="menu-text">Reports</span>
            </div>
            <div class="menu-item" onclick="switchTab('settings')">
                <i class="fas fa-cog"></i>
                <span class="menu-text">Settings</span>
            </div>
        </div>
        
        <div class="sidebar-footer">
            <div class="admin-profile">
                <div class="admin-avatar">A</div>
                <div class="admin-info">
                    <div class="admin-name">Admin User</div>
                    <div class="admin-role">System Administrator</div>
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
                    <h1>Admin Dashboard</h1>
                    <p>Welcome back! Here's your restaurant overview</p>
                </div>
                
                <div class="top-bar-actions">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" placeholder="Search...">
                    </div>
                    <div class="notification-icon">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">5</span>
                    </div>
                </div>
            </div>
            
            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card revenue">
                    <div class="stat-header">
                        <div class="stat-icon revenue">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-trend trend-up">
                            <i class="fas fa-arrow-up"></i>
                            <span>15%</span>
                        </div>
                    </div>
                    <div class="stat-value">850,000frw</div>
                    <div class="stat-label">Total Revenue</div>
                </div>
                
                <div class="stat-card orders">
                    <div class="stat-header">
                        <div class="stat-icon orders">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="stat-trend trend-up">
                            <i class="fas fa-arrow-up"></i>
                            <span>12%</span>
                        </div>
                    </div>
                    <div class="stat-value">156</div>
                    <div class="stat-label">Total Orders</div>
                </div>
                
                <div class="stat-card customers">
                    <div class="stat-header">
                        <div class="stat-icon customers">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-trend trend-up">
                            <i class="fas fa-arrow-up"></i>
                            <span>8%</span>
                        </div>
                    </div>
                    <div class="stat-value">89</div>
                    <div class="stat-label">Total Customers</div>
                </div>
                
                <div class="stat-card reservations">
                    <div class="stat-header">
                        <div class="stat-icon reservations">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="stat-trend trend-up">
                            <i class="fas fa-arrow-up"></i>
                            <span>5%</span>
                        </div>
                    </div>
                    <div class="stat-value">42</div>
                    <div class="stat-label">Reservations</div>
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
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#ORD-0156</td>
                                    <td>John Doe</td>
                                    <td>25,000frw</td>
                                    <td><span class="status-badge status-completed">Completed</span></td>
                                    <td>15 Oct 2023</td>
                                </tr>
                                <tr>
                                    <td>#ORD-0155</td>
                                    <td>Jane Smith</td>
                                    <td>18,500frw</td>
                                    <td><span class="status-badge status-confirmed">Confirmed</span></td>
                                    <td>14 Oct 2023</td>
                                </tr>
                                <tr>
                                    <td>#ORD-0154</td>
                                    <td>Mike Johnson</td>
                                    <td>32,000frw</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td>14 Oct 2023</td>
                                </tr>
                                <tr>
                                    <td>#ORD-0153</td>
                                    <td>Sarah Wilson</td>
                                    <td>12,000frw</td>
                                    <td><span class="status-badge status-completed">Completed</span></td>
                                    <td>13 Oct 2023</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="content-card">
                        <div class="card-header">
                            <div class="card-title">Quick Actions</div>
                        </div>
                        <div class="actions-grid">
                            <div class="action-card" onclick="switchTab('menu')">
                                <div class="action-icon">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="action-title">Add Menu Item</div>
                                <div class="action-desc">Create new menu item</div>
                            </div>
                            <div class="action-card" onclick="switchTab('customers')">
                                <div class="action-icon">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="action-title">Manage Customers</div>
                                <div class="action-desc">View all customers</div>
                            </div>
                            <div class="action-card" onclick="generateReport()">
                                <div class="action-icon">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                                <div class="action-title">Generate Report</div>
                                <div class="action-desc">Sales and analytics</div>
                            </div>
                            <div class="action-card" onclick="switchTab('reservations')">
                                <div class="action-icon">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <div class="action-title">View Reservations</div>
                                <div class="action-desc">Manage bookings</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="content-column">
                    <!-- Recent Activity -->
                    <div class="content-card">
                        <div class="card-header">
                            <div class="card-title">Recent Activity</div>
                        </div>
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">New order placed</div>
                                    <div class="activity-time">2 minutes ago</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">New customer registered</div>
                                    <div class="activity-time">1 hour ago</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">Table reservation made</div>
                                    <div class="activity-time">3 hours ago</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">Menu item updated</div>
                                    <div class="activity-time">5 hours ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- System Status -->
                    <div class="content-card">
                        <div class="card-header">
                            <div class="card-title">System Status</div>
                        </div>
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-icon" style="background: #10b981;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">Database</div>
                                    <div class="activity-time">Online</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon" style="background: #10b981;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">Payment Gateway</div>
                                    <div class="activity-time">Online</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon" style="background: #10b981;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">Email Service</div>
                                    <div class="activity-time">Online</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Other tabs would be implemented similarly -->
        <!-- Customers Tab -->
        <div id="customers-tab" class="tab-content">
            <div class="top-bar">
                <div class="page-title">
                    <h1>Customer Management</h1>
                    <p>Manage all restaurant customers</p>
                </div>
                <button class="btn btn-primary">
                    <i class="fas fa-download"></i> Export CSV
                </button>
            </div>
            
            <div class="content-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Customer ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Orders</th>
                            <th>Points</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#C001</td>
                            <td>John Doe</td>
                            <td>john@example.com</td>
                            <td>+250784456456</td>
                            <td>24</td>
                            <td>1,250</td>
                            <td>
                                <button class="btn btn-secondary">View</button>
                                <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                        <!-- More customer rows -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Menu Management Tab -->
        <div id="menu-tab" class="tab-content">
            <div class="top-bar">
                <div class="page-title">
                    <h1>Menu Management</h1>
                    <p>Manage restaurant menu items</p>
                </div>
                <button class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Item
                </button>
            </div>
            
            <div class="content-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#I001</td>
                            <td>Spaghetti Carbonara</td>
                            <td>Mains</td>
                            <td>5,000frw</td>
                            <td><span class="status-badge status-completed">Available</span></td>
                            <td>
                                <button class="btn btn-secondary">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                        <!-- More menu rows -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        document.getElementById('mobileToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Tab switching
        function switchTab(tabName) {
            // Hide all tab content
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show selected tab content
            document.getElementById(`${tabName}-tab`).classList.add('active');
            
            // Update active menu item
            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
        }

        // Logout function
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'admin_logout.php';
            }
        }

        // Generate report
        function generateReport() {
            alert('Report generation feature would be implemented here');
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

        // Sample data loading (would be replaced with actual API calls)
        function loadDashboardData() {
            // This would make API calls to get real data
            console.log('Loading dashboard data...');
        }

        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            loadDashboardData();
        });
    </script>
</body>
</html>