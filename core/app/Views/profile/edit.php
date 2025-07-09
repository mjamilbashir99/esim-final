<style>
    body {
        background: #f0f2f5;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-container {
        max-width: 600px;
        margin: 120px auto 40px auto;
        padding: 40px 30px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .form-header {
        text-align: center;
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 35px;
        color: #001c34;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 6px;
    }

    .form-control {
        padding: 12px 15px;
        font-size: 1rem;
        border: 1.7px solid #ccc;
        border-radius: 8px;
        background-color: #E8F0FE;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #0d6efd;
        background-color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
        outline: none;
    }

    .btn-primary,
    .btn-search {
        background-color: #001c34;
        border: none;
        padding: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 8px;
        transition: background-color 0.3s ease;
        width: 100%;
        color: white;
    }

    .btn-primary:hover,
    .btn-search:hover {
        background-color: #003d66;
    }

    .alert {
        font-size: 0.95rem;
    }

    .alert ul {
        margin-bottom: 0;
        padding-left: 20px;
    }
</style>



<div class="form-container">
    <h2 class="form-header">Edit Profile</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors = session()->getFlashdata('errors'))): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                <?php foreach ($errors as $field => $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('profile/update') ?>" method="post" enctype="multipart/form-data" novalidate>
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control"
                value="<?= esc($user['name']) ?>" required placeholder="Enter your full name" />
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control"
                value="<?= esc($user['phone']) ?>" required placeholder="3001234567" />
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control"
                value="<?= esc($user['email']) ?>" required placeholder="example@mail.com" />
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">New Password <small class="text-muted">(optional)</small></label>
            <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" />
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>