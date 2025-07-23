<style>
    .dashboard-card {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
        padding: 20px;
        color: #333;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    .dashboard-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6e8efb, #a777e3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        margin-right: 15px;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .dashboard-card-title {
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        color: #666;
        margin-bottom: 5px;
    }

    .dashboard-card-value {
        font-size: 24px;
        font-weight: 700;
        color: #222;
    }

    .dashboard-flex {
        display: flex;
        align-items: center;
    }
</style>

<div class="container-fluid">
    <div class="row g-4">
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card">
                <div class="dashboard-flex">
                    <div class="dashboard-icon" style="background: linear-gradient(135deg, #4e73df, #1cc88a);">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <div class="dashboard-card-title">Monthly Bookings</div>
                        <div class="dashboard-card-value"><?= $monthly_bookings ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card">
                <div class="dashboard-flex">
                    <div class="dashboard-icon" style="background: linear-gradient(135deg, #1cc88a, #20c997);">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div>
                        <div class="dashboard-card-title">Total Bookings</div>
                        <div class="dashboard-card-value"><?= $total_bookings ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card">
                <div class="dashboard-flex">
                    <div class="dashboard-icon" style="background: linear-gradient(135deg, #36b9cc, #4e73df);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <div class="dashboard-card-title">Total Users</div>
                        <div class="dashboard-card-value"><?= $total_users ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card">
                <div class="dashboard-flex">
                    <div class="dashboard-icon" style="background: linear-gradient(135deg, #f6c23e, #fd7e14);">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div>
                        <div class="dashboard-card-title">B2C %</div>
                        <div class="dashboard-card-value"><?= $b2c_percentage ?>%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
