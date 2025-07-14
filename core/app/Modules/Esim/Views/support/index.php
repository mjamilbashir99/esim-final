<style>
    body {
        background-color: #f7fdf9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
    }

    .containerSupport {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 15px;
    }

    .section-title {
        color: #1b5e20;
        font-weight: 700;
        font-size: 2rem;
        text-align: center;
        margin-bottom: 2rem;
    }

    .card {
        border: none;
        border-left: 4px solid #2e7d32;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: box-shadow 0.3s ease;
        margin-bottom: 20px;
    }

    .card:hover {
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 1.2rem 1.5rem;
    }

    .card-title {
        color: #2e7d32;
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .list-unstyled li {
        color: #444;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .support-footer {
        text-align: center;
        margin: 3rem 0 2rem;
    }

    .support-footer p {
        font-weight: 600;
        color: #2e7d32;
        margin-bottom: 1rem;
    }

    .btn-outline-primary {
        border: 2px solid #2e7d32;
        color: #2e7d32;
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        border-radius: 6px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-outline-primary:hover {
        background-color: #2e7d32;
        color: #fff;
    }

    .support-form {
        background-color: #fff;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        margin-top: 3rem;
    }

    .support-form label {
        display: block;
        font-weight: 600;
        color: #2e7d32;
        margin-bottom: 0.5rem;
    }

    .support-form input,
    .support-form textarea {
        width: 100%;
        padding: 0.75rem;
        margin-bottom: 1.2rem;
        border: 1px solid #c8e6c9;
        border-radius: 8px;
        font-size: 1rem;
        background-color: #f9fefb;
    }

    .support-form input:focus,
    .support-form textarea:focus {
        outline: none;
        border-color: #2e7d32;
        background-color: #fff;
        box-shadow: 0 0 4px rgba(46, 125, 50, 0.3);
    }

    .submit-btn {
        background-color: #2e7d32;
        color: white;
        font-size: 1rem;
        padding: 0.75rem;
        width: 100%;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #256428;
    }

    .recent-views {
        margin-top: 3rem;
        background: #ffffff;
        border-left: 6px solid #2e7d32;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.15);
        padding: 1rem 1.5rem;
    }

    .recent-views h5 {
        color: #2e7d32;
        font-weight: 700;
        font-size: 1.35rem;
        margin-bottom: 1.2rem;
    }

    .recent-views ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .recent-views li {
        display: flex;
        align-items: center;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 10px;
        transition: background-color 0.2s ease;
    }

    .recent-views li:hover {
        background-color: #e8f5e9;
    }

    .recent-views img {
        width: 30px;
        height: 30px;
        margin-right: 12px;
        border-radius: 6px;
    }

    .recent-views a {
        color: #2e7d32;
        text-decoration: none;
        font-weight: 600;
        flex-grow: 1;
    }

    .recent-views a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .containerSupport {
            margin: 20px;
        }
    }
</style>

<div class="containerSupport">
    <h2 class="section-title">🌬️ Welcome to <strong>eSIM Support</strong></h2>

    <!-- Support Categories -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">📱 Device Management</h5>
                    <ul class="list-unstyled">
                        <li>How to install your eSIM</li>
                        <li>Switching devices</li>
                        <li>Deleting or resetting your eSIM</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">📲 eSIM Compatible Devices</h5>
                    <ul class="list-unstyled">
                        <li>iOS Devices supported</li>
                        <li>Android Devices supported</li>
                        <li>How to check device compatibility</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">❓ FAQ’s & Troubleshooting</h5>
                    <ul class="list-unstyled">
                        <li>Common activation issues</li>
                        <li>eSIM not working?</li>
                        <li>Can't scan QR code?</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">👤 Managing My Account</h5>
                    <ul class="list-unstyled">
                        <li>Change email or password</li>
                        <li>View my plans & usage</li>
                        <li>Cancel or pause subscription</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="support-footer">
        <p>💬 Still need help?</p>
        <!-- <a href="#contact" class="btn btn-outline-primary">Contact Us</a> -->
    </div>

    <!-- Contact Form -->
    <div id="contact" class="support-form">
        <h4 style="color: #2e7d32; text-align: center;">💬 Contact eSIM Support</h4>
        <form action="<?= site_url('support/submit') ?>" method="POST">
            <label for="name">Your Name</label>
            <input type="text" name="name" id="name" required placeholder="Enter your full name">

            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" required placeholder="Enter your email">

            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" required placeholder="Subject of your query">

            <label for="message">Message</label>
            <textarea name="message" id="message" rows="6" required placeholder="Describe your issue or question"></textarea>

            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </div>
    <?php if (session()->getFlashdata('success')): ?>
        <div style="color: green; font-weight: 600; margin-bottom: 1rem;">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div style="color: red; font-weight: 600; margin-bottom: 1rem;">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php $recent = session()->get('recent_views') ?? []; ?>
    <?php if (!empty($recent)): ?>
        <div class="recent-views">
            <h5>🕘 Recently Viewed Articles</h5>
            <ul>
                <?php foreach ($recent as $brand): ?>
                    <li>
                        <a href="<?= site_url('compatibility/' . $brand) ?>" style="display: inline-flex; align-items: center; text-decoration: none; color: inherit;">
                            <img
                                src="<?= base_url('assets/img/article_img.png') ?>"
                                alt="Article logo"
                                loading="lazy"
                                style="width: 30px; height: 30px; margin-right: 8px; vertical-align: middle;">
                            <?= ucfirst($brand) ?>
                        </a>


                    </li>
                <?php endforeach; ?>
            </ul>

        </div>
    <?php endif; ?>





</div>