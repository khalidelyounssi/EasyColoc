# 🏠 EasyColoc - Shared Living Expense Manager

**EasyColoc** is a minimalist SaaS platform designed to simplify financial management within roommates (colocations). Inspired by **Apple's minimalist design philosophy**, it focuses on transparency, accountability, and user-friendly expense tracking.

---

## 🚀 Core Features

### 🛠️ Financial Management
* **Smart Dashboard:** A centralized view of active spaces, pending invitations, and global reputation.
* **Automated Debt Splitting:** Expenses are automatically divided among members and tracked as pending settlements.
* **Category Isolation:** Each colocation has its own custom categories, ensuring data privacy and organization.

### ⚖️ Accountability System (Reputation Score)
* **Trust Tracking:** Every user has a `reputation_score` that increases with successful settlements and decreases when leaving with unpaid debts.
* **Debt Transfer:** When a member leaves a colocation with pending debts, those debts are automatically transferred to the **Owner** as the guarantor, and the leaver's reputation is penalized.

### 🛡️ Roles & Permissions
* **Owner Controls:** Only the colocation creator (Owner) can invite new members, create categories, or transfer ownership.
* **Leave Restriction:** Owners are restricted from leaving a colocation unless they transfer their role to another active member.
* **Historical Archives:** Users can access a "Grayscale" archive of their past colocations to view historical data without modification rights.

---

## 💻 Tech Stack

* **Framework:** Laravel 12
* **Language:** PHP 8.3
* **Database:** MySQL (Structured with Foreign Keys & Cascading Deletes)
* **Styling:** Tailwind CSS (Custom Apple Minimalist UI)

---

## 🛠️ Installation

1. **Clone the project:**
   ```bash
   git clone [https://github.com/your-username/EasyColoc.git](https://github.com/your-username/EasyColoc.git)