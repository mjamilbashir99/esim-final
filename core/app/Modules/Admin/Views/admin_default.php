<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Esim</title>

    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700,900" rel="stylesheet" />
    <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet" />

    <style>
        #accordionSidebar {
            background: linear-gradient(145deg, #0f2027, #203a43, #2c5364);
            transition: all 0.3s ease;
            width: 250px;
            color: #ffffff;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar .nav-item {
            border-radius: 10px;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: scale(1.02);
        }

        .sidebar .nav-link {
            color: #ffffff;
            font-weight: 500;
            white-space: nowrap;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            color: #ffce00;
            transition: color 0.3s ease;
        }

        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .sidebar-brand-text,
        .sidebar.collapsed .sidebar-heading {
            display: none;
        }

        .sidebar-brand-icon {
            color: #38bdf8;
            font-size: 1.5rem;
        }

        .sidebar-brand-text {
            color: #38bdf8;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .sidebar-heading {
            color: #ffffff;
            padding-left: 20px;
            font-size: 14px;
            text-transform: uppercase;
            margin-top: 15px;
        }

        .collapse-inner {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }

        .collapse-inner a {
            color: #fff;
            padding: 8px 20px;
            display: block;
            transition: background 0.2s ease;
        }

        .collapse-inner a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .toggle-sidebar-btn {
            position: fixed;
            top: 15px;
            left: 240px;
            z-index: 1000;
            background-color: linear-gradient(135deg, #1d3557, #457b9d);
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed~.toggle-sidebar-btn {
            left: 110px !important;
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-4px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .scroll-to-top {
            background: #1e1f26;
            color: white;
            border: 2px solid #ffce00;
        }

        .scroll-to-top:hover {
            background: #2b2c34;
            color: #fff;
        }
    </style>

</head>

<body id="page-top">

    <button class="toggle-sidebar-btn" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div id="wrapper">

        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('admin/dashboard') ?>" style="padding: 15px 10px;">
                <div class="sidebar-brand-icon" style="animation: float 2s ease-in-out infinite;">
                    <i class="fas fa-satellite-dish"></i>
                </div>
                <div class="sidebar-brand-text mx-2">Admin Panel</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="<?= site_url('admin/dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Hotel Panel</div>

            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/all-hotel-bookings') ?>">
                    <i class="fas fa-hotel"></i>
                    <span>Hotel Bookings</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">ESIM Panel</div>

            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/all-bookings') ?>">
                    <i class="fas fa-sim-card"></i>
                    <span>ESIM Bookings</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('admin/all-users') ?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Users</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Settings</div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#settingsCollapse" aria-expanded="true" aria-controls="settingsCollapse">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Settings</span>
                </a>
                <div id="settingsCollapse" class="collapse" aria-labelledby="headingSettings" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= site_url('admin/hotels') ?>">Markups</a>
                        <a class="collapse-item" href="<?= site_url('admin/email-templates') ?>">Email Templates</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 p-2">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto align-items-center">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle d-flex align-items-center text-gray-700" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-secondary"></i>
                                <span class="mr-2 d-none d-lg-inline small font-weight-semibold">Admin</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item text-gray-700" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-secondary"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>


                <div class="container-fluid">
                    <?= $content ?>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto text-center">
                    <span>Copyright &copy; Esim <?= date('Y'); ?></span>
                </div>
            </footer>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">Click "Logout" to end your session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('admin/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>
    <script>
        const sidebar = document.getElementById('accordionSidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');

            if (sidebar.classList.contains('collapsed')) {
                toggleBtn.style.left = '110px';
            } else {
                toggleBtn.style.left = '240px';
            }
        });
    </script>
</body>

</html>