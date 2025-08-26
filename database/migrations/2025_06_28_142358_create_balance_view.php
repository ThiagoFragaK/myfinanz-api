<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
           CREATE VIEW v_balance AS
            SELECT
                COALESCE(i.month, e.month) AS month,
                COALESCE(i.user_id, e.user_id) AS user_id,
                e.payment_method_id,
                i.type_id AS income_type_id,
                COALESCE(i.total_income, 0) AS total_income,
                COALESCE(e.total_expense, 0) AS total_expense
            FROM
                (
                    -- INCOMES
                    SELECT
                        DATE_TRUNC('month', created_at) AS month,
                        user_id,
                        type_id,
                        SUM(value) AS total_income
                    FROM incomes
                    GROUP BY month, user_id, type_id
                ) i
            FULL OUTER JOIN
                (
                    -- EXPENSES
                    SELECT
                        DATE_TRUNC('month', created_at) AS month,
                        user_id,
                        payment_method_id,
                        SUM(value) AS total_expense
                    FROM expenses
                    GROUP BY month, user_id, payment_method_id
                ) e
            ON i.user_id = e.user_id AND i.month = e.month;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS v_balance");
    }
};
