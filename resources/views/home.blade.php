@extends('layouts.app')

@section('admin_layout')

    <div class="container-fluid py-4">
        <div class="container mt-5">
            <!-- Main Content -->
            <div class="main-content">

                <!-- Header -->
                <header class="header">
                    <h1>Welcome, Baudouin!</h1>
                </header>

                <!-- Cards Summary -->
                <section class="dashboard">
                    <h2>Overall Summary</h2>
                    <div class="stats">
                        <div class="card card-total-balance">
                            <h3>Total Balance</h3>
                            <p id="total-balance">0 XOF</p>
                        </div>
                        <div class="card card-monthly-expenses">
                            <h3>Monthly Expenses</h3>
                            <p id="monthly-expenses">0 XOF</p>
                        </div>
                        <div class="card card-income">
                            <h3>Income</h3>
                            <p id="income">0 XOF</p>
                        </div>
                        <div class="card card-savings-goal">
                            <h3>Savings Goal</h3>
                            <p id="savings-goal">0 XOF</p>
                            <div class="progress-bar">
                                <div id="savings-progress"></div>
                            </div>
                        </div>
                    </div><br><br><br>


                </section>
                <h2>Financial Analysis</h2>
                <!-- Charts -->
                <section class="charts">
                    <div class="chart-container">
                        <h3>Expense Breakdown by Category</h3>
                        <canvas id="categoriesChart"></canvas>
                    </div>

                    <div class="chart-container">
                        <h3>Income Breakdown by Category</h3>
                        <canvas id="incomeChart"></canvas>
                    </div>

                    <div class="chart-container" style="width: 50%;" id="t">
                        <h3>Transaction Trends</h3>
                        <canvas id="transactionsChart"></canvas>
                    </div>

                </section>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('assets/js/dashboard.js')}}"></script>
@endsection