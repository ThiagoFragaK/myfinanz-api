# 💰 Financial App API

This is the **backend API** for the Financial App.  
It provides endpoints to manage **income, expenses, sources, savings, payment methods**, and a **dashboard** that aggregates insights.

The frontend repository is here: [financial-app-frontend](https://github.com/your-username/financial-app-frontend)

---

## ✨ Features

- 🔑 Authentication & authorization (JWT-based)
- 💵 **Income** — create, update, delete, and list incomes
- 💸 **Expenses** — track, categorize, and manage expenses
- 🏦 **Sources** — manage income sources (salary, freelance, etc.)
- 💳 **Payment methods** — manage accounts, credit cards, and wallets
- 💼 **Savings** — create and track savings goals
- 📊 **Dashboard** — financial overview & quick stats

---

## 🛠️ Tech Stack

- **.NET 8** (Web API)
- **Entity Framework Core** (ORM)
- **SQL Server / PostgreSQL** (configurable database)
- **Swagger / OpenAPI** (API documentation)
- **JWT Authentication**
- **Docker** (for containerized deployment)

---

## 🚀 Getting Started

### Prerequisites

- [.NET 8 SDK](https://dotnet.microsoft.com/en-us/download)
- SQL Server or PostgreSQL
- Docker (optional, for containerized setup)

### Installation

```bash
# Clone repo
git clone https://github.com/your-username/financial-app-api.git

# Enter project folder
cd financial-app-api

# Run database migrations
dotnet ef database update

# Run the API
dotnet run
```

The API will run at: http://localhost:5000
Swagger docs: http://localhost:5000/swagger

## 📂 Project Structure
```bash
financial-app-api/
│── src/
│   ├── Controllers/        # API endpoints
│   ├── Models/             # Database entities
│   ├── DTOs/               # Data transfer objects
│   ├── Services/           # Business logic
│   ├── Repositories/       # Data access layer
│   └── Program.cs          # Entry point
│
│── Migrations/             # EF Core migrations
│── appsettings.json        # Config (DB, JWT, etc.)
│── README.md
```

🔗 Example Endpoints
- Auth
POST /auth/register — create account
POST /auth/login — login and receive JWT
- Income
GET /income — list incomes
POST /income — add new income
- Expenses
GET /expenses — list expenses
POST /expenses — add new expense
- Sources
GET /sources
POST /sources
- Payment Methods
GET /payment-methods
POST /payment-methods
- Savings
GET /savings
POST /savings
- Dashboard
GET /dashboard — summary of finances

##🔮 Roadmap
-✅ Core models & migrations
-✅ CRUD endpoints for income, expenses, sources, savings, payment methods
-⏳ Authentication & JWT
-⏳ Dashboard calculations
-⏳ User profiles
-⏳ Reports & analytics
-⏳ Export data (CSV, PDF)

##📜 License
MIT License © 2025 [ThiagoFraga]
---
👉 Do you want me to make the **API README** match the **frontend one in tone & style** (same badges, same emojis, etc.), or do you prefer it more **formal, developer-oriented** (like enterprise-style docs)?
