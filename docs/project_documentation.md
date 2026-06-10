# Mini Inventory Management System Documentation

## 1. Project Overview

This project is a small office inventory management system developed using Core PHP, MySQL, PDO, and XAMPP server. It supports basic stock control for product categories, product records, stock-in transactions, stock-out transactions, current stock reporting, date-wise reporting, and browser print.

## 2. Database Design

### users
Stores application login users.

| Column | Type | Description |
|---|---|---|
| id | INT PK | User ID |
| name | VARCHAR | Full name |
| username | VARCHAR UNIQUE | Login username |
| password | VARCHAR | Hashed password |
| role | ENUM | admin/staff |
| created_at | TIMESTAMP | Creation time |

### categories
Stores product category data.

| Column | Type | Description |
|---|---|---|
| id | INT PK | Category ID |
| category_name | VARCHAR UNIQUE | Category name |
| description | TEXT | Category details |
| status | TINYINT | Active/inactive |
| created_at | TIMESTAMP | Creation time |

### products
Stores product master data.

| Column | Type | Description |
|---|---|---|
| id | INT PK | Product ID |
| category_id | INT FK | Category reference |
| product_name | VARCHAR | Product name |
| sku | VARCHAR UNIQUE | Product code |
| unit | VARCHAR | Unit, example pcs/kg/litre |
| opening_stock | INT | Initial stock |
| status | TINYINT | Active/inactive |
| created_at | TIMESTAMP | Creation time |

### stock_transactions
Stores stock-in and stock-out records.

| Column | Type | Description |
|---|---|---|
| id | INT PK | Transaction ID |
| product_id | INT FK | Product reference |
| transaction_type | ENUM | IN or OUT |
| quantity | INT | Transaction quantity |
| transaction_date | DATE | Transaction date |
| remarks | VARCHAR | Optional note |
| created_by | INT FK | User reference |
| created_at | TIMESTAMP | Creation time |

## 3. Page List

| Page | Purpose |
|---|---|
| auth/login.php | User login |
| auth/logout.php | Logout |
| dashboard.php | Summary dashboard |
| categories/index.php | Category list |
| categories/create.php | Add category |
| categories/edit.php | Edit category |
| categories/delete.php | Delete category |
| products/index.php | Product list |
| products/create.php | Add product |
| products/edit.php | Edit product |
| products/delete.php | Delete product |
| stock/stock_in.php | Add stock |
| stock/stock_out.php | Remove stock |
| reports/current_stock.php | Current stock report |
| reports/date_wise.php | Date-wise stock transaction report |

## 4. Basic Flowchart

```text
Start
  |
Login Page
  |
Valid Login?
  |---- No ----> Show Error
  |
 Yes
  |
Dashboard
  |
Menu Selection
  |
  |-- Category CRUD
  |-- Product CRUD
  |-- Stock In
  |-- Stock Out
  |-- Current Stock Report
  |-- Date-wise Report
  |
Print Report if Required
  |
Logout
  |
End
```

## 5. Development Timeline

| Day | Task |
|---|---|
| Day 1 | Requirement analysis, database design, page list |
| Day 2 | Project folder setup, database connection, login system |
| Day 3 | Category CRUD and product CRUD |
| Day 4 | Stock-in and stock-out module with validation |
| Day 5 | Current stock report and date-wise report |
| Day 6 | Print option, UI improvement, testing |
| Day 7 | Bug fixing, documentation, final delivery |

## 6. Company Development Standard Notes

- Use PDO prepared statements to reduce SQL injection risk.
- Separate configuration, includes, modules, assets, database, and documentation.
- Use common header, sidebar, footer layout files.
- Apply server-side validation before database insert/update.
- Use meaningful table and column names.
- Keep reports query-based instead of storing duplicate current stock values.
- Use browser print CSS for print-friendly reports.
