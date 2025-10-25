<?php
// admin_dashboard.php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current page
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Handle actions
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;
    
    switch($action) {
        case 'delete_customer':
            if ($id) {
                $stmt = $conn->prepare("DELETE FROM customers WHERE customer_id = ?");
                if ($stmt) {
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->close();
                }
            }
            break;
            
        case 'delete_item':
            if ($id) {
                // Check if items table exists first
                $result = $conn->query("SHOW TABLES LIKE 'items'");
                if ($result && $result->num_rows > 0) {
                    $stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?");
                    if ($stmt) {
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
            }
            break;
            
        case 'update_order_status':
            if ($id && isset($_POST['status'])) {
                // Check if orders table exists first
                $result = $conn->query("SHOW TABLES LIKE 'orders'");
                if ($result && $result->num_rows > 0) {
                    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
                    if ($stmt) {
                        $status = trim($_POST['status']);
                        $stmt->bind_param("si", $status, $id);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
            }
            break;
    }
    
    header("Location: admin_dashboard.php?page=" . $page);
    exit();
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_item'])) {
        $item_name = trim($_POST['item_name']);
        $description = trim($_POST['description']);
        $price = floatval($_POST['price']);
        $category = trim($_POST['category']);
        
        // Check if items table exists
        $result = $conn->query("SHOW TABLES LIKE 'items'");
        if ($result && $result->num_rows > 0) {
            $stmt = $conn->prepare("INSERT INTO items (item_name, description, price, category) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("ssds", $item_name, $description, $price, $category);
                $stmt->execute();
                $stmt->close();
            }
        }
        
        header("Location: admin_dashboard.php?page=menu");
        exit();
    }
}

// Initialize variables
$stats = [
    'revenue' => 0,
    'orders' => 0,
    'customers' => 0,
    'reservations' => 0
];

$recent_orders = null;
$customers = null;
$menu_items = null;
$orders = null;
$reservations = null;
$sales_data = null;
$popular_items = null;

// Get data based on current page
switch($page) {
    case 'dashboard':
        // Dashboard statistics
        // Check if customers table exists
        $result = $conn->query("SHOW TABLES LIKE 'customers'");
        if ($result && $result->num_rows > 0) {
            $result = $conn->query("SELECT COUNT(*) as total FROM customers");
            if ($result) $stats['customers'] = $result->fetch_assoc()['total'];
        }
        
        // Check if orders table exists
        $result = $conn->query("SHOW TABLES LIKE 'orders'");
        if ($result && $result->num_rows > 0) {
            $result = $conn->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM orders WHERE status = 'completed'");
            if ($result) $stats['revenue'] = $result->fetch_assoc()['total'];
            
            $result = $conn->query("SELECT COUNT(*) as total FROM orders");
            if ($result) $stats['orders'] = $result->fetch_assoc()['total'];
            
            // Recent orders
            $recent_orders = $conn->query("
                SELECT o.*, c.first_name, c.last_name 
                FROM orders o 
                LEFT JOIN customers c ON o.customer_id = c.customer_id 
                ORDER BY o.order_date DESC 
                LIMIT 5
            ");
        }
        
        // Check if reservations table exists
        $result = $conn->query("SHOW TABLES LIKE 'reservations'");
        if ($result && $result->num_rows > 0) {
            $result = $conn->query("SELECT COUNT(*) as total FROM reservations");
            if ($result) $stats['reservations'] = $result->fetch_assoc()['total'];
        }
        break;
        
    case 'customers':
        $result = $conn->query("SHOW TABLES LIKE 'customers'");
        if ($result && $result->num_rows > 0) {
            $customers = $conn->query("SELECT * FROM customers ORDER BY created_at DESC");
        }
        break;
        
    case 'menu':
        $result = $conn->query("SHOW TABLES LIKE 'items'");
        if ($result && $result->num_rows > 0) {
            $menu_items = $conn->query("SELECT * FROM items ORDER BY category, item_name");
        }
        break;
        
    case 'orders':
        $result = $conn->query("SHOW TABLES LIKE 'orders'");
        if ($result && $result->num_rows > 0) {
            $orders = $conn->query("
                SELECT o.*, c.first_name, c.last_name, c.email, c.phone 
                FROM orders o 
                LEFT JOIN customers c ON o.customer_id = c.customer_id 
                ORDER BY o.order_date DESC
            ");
        }
        break;
        
    case 'reservations':
        $result = $conn->query("SHOW TABLES LIKE 'reservations'");
        if ($result && $result->num_rows > 0) {
            $reservations = $conn->query("
                SELECT r.*, c.first_name, c.last_name, c.phone 
                FROM reservations r 
                LEFT JOIN customers c ON r.customer_id = c.customer_id 
                ORDER BY r.reservation_date DESC, r.reservation_time DESC
            ");
        }
        break;
        
    case 'reports':
        // Check if orders table exists
        $result = $conn->query("SHOW TABLES LIKE 'orders'");
        if ($result && $result->num_rows > 0) {
            // Sales report data
            $sales_data = $conn->query("
                SELECT DATE(order_date) as date, SUM(total_amount) as revenue, COUNT(*) as orders 
                FROM orders 
                WHERE status = 'completed' 
                GROUP BY DATE(order_date) 
                ORDER BY date DESC 
                LIMIT 7
            ");
            
            // Check if order_items table exists for popular items
            $result = $conn->query("SHOW TABLES LIKE 'order_items'");
            if ($result && $result->num_rows > 0) {
                $popular_items = $conn->query("
                    SELECT i.item_name, COUNT(oi.item_id) as order_count, SUM(oi.quantity) as total_quantity
                    FROM order_items oi 
                    JOIN items i ON oi.item_id = i.item_id 
                    GROUP BY oi.item_id 
                    ORDER BY total_quantity DESC 
                    LIMIT 10
                ");
            }
        }
        break;
}
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
            text-decoration: none;
            color: white;
            display: flex;
        }

        .menu-item:hover, .menu-item.active {
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
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            position: relative;
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
            transition: transform 0.3s;
            border-left: 4px solid;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card.revenue { border-left-color: #10b981; }
        .stat-card.orders { border-left-color: #a74200; }
        .stat-card.customers { border-left-color: #8b5cf6; }
        .stat-card.reservations { border-left-color: #f59e0b; }

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

        .stat-icon.revenue { background: linear-gradient(135deg, #10b981 0%, #34d399 100%); }
        .stat-icon.orders { background: linear-gradient(135deg, #a74200 0%, #d97706 100%); }
        .stat-icon.customers { background: linear-gradient(135deg, #8b5cf6 0%, #c084fc 100%); }
        .stat-icon.reservations { background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); }

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

        /* Content */
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

        .status-pending { background: #fef3c7; color: #d97706; }
        .status-confirmed { background: #dbeafe; color: #3b82f6; }
        .status-completed { background: #dcfce7; color: #16a34a; }
        .status-cancelled { background: #fecaca; color: #dc2626; }

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

        .btn-secondary {
            background: white;
            color: #a74200;
            border: 1px solid #f0d5be;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #374151;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 15px;
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
            }
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #64748b;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #cbd5e1;
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
            <a href="?page=dashboard" class="menu-item <?php echo $page == 'dashboard' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i>
                <span class="menu-text">Dashboard</span>
            </a>
            <a href="?page=customers" class="menu-item <?php echo $page == 'customers' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i>
                <span class="menu-text">Customers</span>
            </a>
            <a href="?page=menu" class="menu-item <?php echo $page == 'menu' ? 'active' : ''; ?>">
                <i class="fas fa-utensils"></i>
                <span class="menu-text">Menu Management</span>
            </a>
            <a href="?page=orders" class="menu-item <?php echo $page == 'orders' ? 'active' : ''; ?>">
                <i class="fas fa-shopping-bag"></i>
                <span class="menu-text">Orders</span>
            </a>
            <a href="?page=reservations" class="menu-item <?php echo $page == 'reservations' ? 'active' : ''; ?>">
                <i class="fas fa-calendar-alt"></i>
                <span class="menu-text">Reservations</span>
            </a>
            <a href="?page=reports" class="menu-item <?php echo $page == 'reports' ? 'active' : ''; ?>">
                <i class="fas fa-chart-bar"></i>
                <span class="menu-text">Reports</span>
            </a>
        </div>
        
        <div class="sidebar-footer">
            <div class="admin-profile">
                <div class="admin-avatar">A</div>
                <div class="admin-info">
                    <div class="admin-name"><?php echo htmlspecialchars($_SESSION['admin_username']); ?></div>
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
        <?php if ($page == 'dashboard'): ?>
            <!-- Dashboard Page -->
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
            
            <div class="stats-grid">
                <div class="stat-card revenue">
                    <div class="stat-header">
                        <div class="stat-icon revenue">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo number_format($stats['revenue']); ?>frw</div>
                    <div class="stat-label">Total Revenue</div>
                </div>
                
                <div class="stat-card orders">
                    <div class="stat-header">
                        <div class="stat-icon orders">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $stats['orders']; ?></div>
                    <div class="stat-label">Total Orders</div>
                </div>
                
                <div class="stat-card customers">
                    <div class="stat-header">
                        <div class="stat-icon customers">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $stats['customers']; ?></div>
                    <div class="stat-label">Total Customers</div>
                </div>
                
                <div class="stat-card reservations">
                    <div class="stat-header">
                        <div class="stat-icon reservations">
                            <i class="fas fa-calendar"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $stats['reservations']; ?></div>
                    <div class="stat-label">Reservations</div>
                </div>
            </div>
            
            <div class="content-card">
                <div class="card-header">
                    <div class="card-title">Recent Orders</div>
                    <a href="?page=orders" class="view-all">View All</a>
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
                        <?php if ($recent_orders && $recent_orders->num_rows > 0): ?>
                            <?php while($order = $recent_orders->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['order_number'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars(($order['first_name'] ?? '') . ' ' . ($order['last_name'] ?? '')); ?></td>
                                <td><?php echo number_format($order['total_amount'] ?? 0); ?>frw</td>
                                <td><span class="status-badge status-<?php echo $order['status'] ?? 'pending'; ?>"><?php echo ucfirst($order['status'] ?? 'Pending'); ?></span></td>
                                <td><?php echo date('d M Y', strtotime($order['order_date'] ?? 'now')); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <i class="fas fa-shopping-bag"></i>
                                    <p>No orders found or orders table doesn't exist</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($page == 'customers'): ?>
            <!-- Customers Page -->
            <div class="top-bar">
                <div class="page-title">
                    <h1>Customer Management</h1>
                    <p>Manage all restaurant customers</p>
                </div>
            </div>
            
            <div class="content-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Orders</th>
                            <th>Points</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($customers && $customers->num_rows > 0): ?>
                            <?php while($customer = $customers->fetch_assoc()): ?>
                            <tr>
                                <td>#C<?php echo str_pad($customer['customer_id'], 3, '0', STR_PAD_LEFT); ?></td>
                                <td><?php echo htmlspecialchars($customer['first_name'] . ' ' . $customer['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($customer['email']); ?></td>
                                <td><?php echo htmlspecialchars($customer['phone'] ?? 'N/A'); ?></td>
                                <td><?php echo $customer['total_orders'] ?? 0; ?></td>
                                <td><?php echo number_format($customer['loyalty_points'] ?? 0); ?></td>
                                <td>
                                    <button class="btn btn-secondary">View</button>
                                    <button class="btn btn-danger" onclick="deleteItem('customer', <?php echo $customer['customer_id']; ?>)">Delete</button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <p>No customers found or customers table doesn't exist</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($page == 'menu'): ?>
            <!-- Menu Management Page -->
            <div class="top-bar">
                <div class="page-title">
                    <h1>Menu Management</h1>
                    <p>Manage restaurant menu items</p>
                </div>
                <button class="btn btn-primary" onclick="openModal()">
                    <i class="fas fa-plus"></i> Add Item
                </button>
            </div>
            
            <div class="content-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($menu_items && $menu_items->num_rows > 0): ?>
                            <?php while($item = $menu_items->fetch_assoc()): ?>
                            <tr>
                                <td>#I<?php echo str_pad($item['item_id'], 3, '0', STR_PAD_LEFT); ?></td>
                                <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                <td><?php echo htmlspecialchars(substr($item['description'], 0, 50)); ?>...</td>
                                <td><?php echo htmlspecialchars($item['category']); ?></td>
                                <td><?php echo number_format($item['price']); ?>frw</td>
                                <td>
                                    <button class="btn btn-secondary">Edit</button>
                                    <button class="btn btn-danger" onclick="deleteItem('item', <?php echo $item['item_id']; ?>)">Delete</button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="fas fa-utensils"></i>
                                    <p>No menu items found or items table doesn't exist</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($page == 'orders'): ?>
            <!-- Orders Page -->
            <div class="top-bar">
                <div class="page-title">
                    <h1>Order Management</h1>
                    <p>Manage and track all restaurant orders</p>
                </div>
            </div>
            
            <div class="content-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($orders && $orders->num_rows > 0): ?>
                            <?php while($order = $orders->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['order_number']); ?></td>
                                <td><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                                <td><?php echo number_format($order['total_amount']); ?>frw</td>
                                <td><?php echo ucfirst($order['order_type'] ?? 'delivery'); ?></td>
                                <td>
                                    <form method="POST" action="?page=orders&action=update_order_status&id=<?php echo $order['order_id']; ?>">
                                        <select name="status" onchange="this.form.submit()">
                                            <option value="pending" <?php echo ($order['status'] ?? '') == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="confirmed" <?php echo ($order['status'] ?? '') == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                            <option value="preparing" <?php echo ($order['status'] ?? '') == 'preparing' ? 'selected' : ''; ?>>Preparing</option>
                                            <option value="ready" <?php echo ($order['status'] ?? '') == 'ready' ? 'selected' : ''; ?>>Ready</option>
                                            <option value="completed" <?php echo ($order['status'] ?? '') == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                        </select>
                                    </form>
                                </td>
                                <td><?php echo date('M j, Y H:i', strtotime($order['order_date'])); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="fas fa-shopping-bag"></i>
                                    <p>No orders found or orders table doesn't exist</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($page == 'reservations'): ?>
            <!-- Reservations Page -->
            <div class="top-bar">
                <div class="page-title">
                    <h1>Reservation Management</h1>
                    <p>Manage table bookings and reservations</p>
                </div>
            </div>
            
            <div class="content-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Date & Time</th>
                            <th>Guests</th>
                            <th>Table</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($reservations && $reservations->num_rows > 0): ?>
                            <?php while($reservation = $reservations->fetch_assoc()): ?>
                            <tr>
                                <td>#R<?php echo str_pad($reservation['reservation_id'], 3, '0', STR_PAD_LEFT); ?></td>
                                <td><?php echo htmlspecialchars($reservation['first_name'] . ' ' . $reservation['last_name']); ?></td>
                                <td><?php echo date('M j, Y H:i', strtotime($reservation['reservation_date'] . ' ' . $reservation['reservation_time'])); ?></td>
                                <td><?php echo $reservation['guests']; ?></td>
                                <td><?php echo htmlspecialchars($reservation['table_number'] ?? 'N/A'); ?></td>
                                <td><span class="status-badge status-<?php echo $reservation['status']; ?>"><?php echo ucfirst($reservation['status']); ?></span></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="fas fa-calendar-alt"></i>
                                    <p>No reservations found or reservations table doesn't exist</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif ($page == 'reports'): ?>
            <!-- Reports Page -->
            <div class="top-bar">
                <div class="page-title">
                    <h1>Reports & Analytics</h1>
                    <p>Sales reports and business analytics</p>
                </div>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card revenue">
                    <div class="stat-value"><?php echo number_format($stats['revenue']); ?>frw</div>
                    <div class="stat-label">Total Revenue</div>
                </div>
                <div class="stat-card orders">
                    <div class="stat-value"><?php echo $stats['orders']; ?></div>
                    <div class="stat-label">Total Orders</div>
                </div>
                <div class="stat-card customers">
                    <div class="stat-value"><?php echo $stats['customers']; ?></div>
                    <div class="stat-label">Total Customers</div>
                </div>
                <div class="stat-card reservations">
                    <div class="stat-value"><?php echo $stats['reservations']; ?></div>
                    <div class="stat-label">Reservations</div>
                </div>
            </div>
            
            <div class="content-card">
                <div class="card-header">
                    <div class="card-title">Recent Sales</div>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Orders</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($sales_data && $sales_data->num_rows > 0): ?>
                            <?php while($sale = $sales_data->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo date('M j, Y', strtotime($sale['date'])); ?></td>
                                <td><?php echo $sale['orders']; ?></td>
                                <td><?php echo number_format($sale['revenue']); ?>frw</td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="empty-state">
                                    <i class="fas fa-chart-bar"></i>
                                    <p>No sales data found or orders table doesn't exist</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>
    </div>

    <!-- Add Item Modal -->
    <div class="modal" id="addModal">
        <div class="modal-content">
            <div class="card-header">
                <div class="card-title">Add Menu Item</div>
                <button onclick="closeModal()" style="background: none; border: none; font-size: 20px; cursor: pointer;">×</button>
            </div>
            <form method="POST" action="?page=menu">
                <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" name="item_name" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Price (FRW)</label>
                    <input type="number" name="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option value="appetizers">Appetizers</option>
                        <option value="mains">Main Courses</option>
                        <option value="desserts">Desserts</option>
                        <option value="beverages">Beverages</option>
                    </select>
                </div>
                <div style="display: flex; gap: 15px; margin-top: 20px;">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="add_item" class="btn btn-primary">Add Item</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        document.getElementById('mobileToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Modal functions
        function openModal() {
            document.getElementById('addModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('addModal').style.display = 'none';
        }

        // Delete confirmation
        function deleteItem(type, id) {
            if (confirm('Are you sure you want to delete this ' + type + '?')) {
                window.location.href = '?page=' + (type === 'customer' ? 'customers' : 'menu') + '&action=delete_' + type + '&id=' + id;
            }
        }

        // Logout
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'admin_logout.php';
            }
        }

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('mobileToggle');
            if (window.innerWidth <= 768 && !sidebar.contains(event.target) && !toggle.contains(event.target) && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            const modal = document.getElementById('addModal');
            if (event.target === modal) {
                closeModal();
            }
        });
    </script>
</body>
</html>
<?php
$conn->close();
?>