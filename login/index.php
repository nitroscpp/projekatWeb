<?php
session_start();
?>
<?php if (isset($_SESSION['error'])): ?>
  <div class="message error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
  <div class="message success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="bs">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Prijava / Registracija</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    :root {
      --primary: #4361ee;
      --primary-dark: #3a0ca3;
      --secondary: #f72585;
      --accent: #4cc9f0;
      --success: #2ec4b6;
      --warning: #ff9f1c;
      --dark: #1a1a2e;
      --light: #f8f9fa;
      --gradient: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
      --gradient-alt: linear-gradient(45deg, #ff6a00, #ee0979);
    }
    
    body {
      background: var(--gradient);
      color: var(--light);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
      position: relative;
      padding: 20px;
    }
    
    body::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        radial-gradient(circle at 10% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 20%),
        radial-gradient(circle at 90% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 20%);
      z-index: -1;
    }
    
    .floating-icon {
      position: absolute;
      font-size: 3rem;
      opacity: 0.1;
      z-index: -1;
      animation: float 15s infinite ease-in-out;
    }
    
    .floating-icon:nth-child(1) {
      top: 15%;
      left: 10%;
      animation-delay: 0s;
    }
    
    .floating-icon:nth-child(2) {
      top: 25%;
      right: 15%;
      animation-delay: 2s;
    }
    
    .floating-icon:nth-child(3) {
      bottom: 20%;
      left: 20%;
      animation-delay: 4s;
    }
    
    .floating-icon:nth-child(4) {
      bottom: 30%;
      right: 25%;
      animation-delay: 6s;
    }
    
    @keyframes float {
      0%, 100% {
        transform: translateY(0) translateX(0) rotate(0deg);
      }
      25% {
        transform: translateY(-20px) translateX(10px) rotate(5deg);
      }
      50% {
        transform: translateY(10px) translateX(-15px) rotate(-5deg);
      }
      75% {
        transform: translateY(-15px) translateX(15px) rotate(3deg);
      }
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
      width: 100%;
    }
    
    header {
      text-align: center;
      padding: 30px 20px;
      margin-bottom: 30px;
    }
    
    header h1 {
      font-size: 2.8rem;
      font-weight: 700;
      margin-bottom: 10px;
      text-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }
    
    header p {
      font-size: 1.2rem;
      max-width: 600px;
      margin: 0 auto;
      opacity: 0.9;
    }
    
    .app-container {
      display: grid;
      grid-template-columns: 1fr;
      gap: 30px;
    }
    
    @media (min-width: 992px) {
      .app-container {
        grid-template-columns: 1fr 1fr;
      }
    }
    
    .form-section {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      animation: fadeIn 0.8s ease-out;
    }
    
    .form-title {
      font-size: 2rem;
      margin-bottom: 25px;
      text-align: center;
      position: relative;
      padding-bottom: 15px;
    }
    
    .form-title::after {
      content: "";
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 3px;
      background: var(--accent);
      border-radius: 2px;
    }
    
    .message {
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
      text-align: center;
      font-weight: 500;
      animation: slideIn 0.5s ease;
    }
    
    .message.error {
      background: rgba(247, 37, 133, 0.2);
      border: 1px solid var(--secondary);
    }
    
    .message.success {
      background: rgba(46, 196, 182, 0.2);
      border: 1px solid var(--success);
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      display: flex;
      align-items: center;
    }
    
    .form-group label i {
      margin-right: 10px;
      color: var(--accent);
    }
    
    .form-group input {
      width: 100%;
      padding: 14px 20px;
      background: rgba(255, 255, 255, 0.1);
      border: 2px solid rgba(255, 255, 255, 0.15);
      border-radius: 12px;
      color: white;
      font-size: 1rem;
      transition: all 0.3s ease;
    }
    
    .form-group input:focus {
      outline: none;
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(76, 201, 240, 0.2);
    }
    
    .btn {
      padding: 16px 30px;
      background: var(--primary);
      color: white;
      border: none;
      border-radius: 50px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      width: 100%;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .btn:hover {
      background: var(--primary-dark);
      transform: translateY(-3px);
    }
    
    .btn.secondary {
      background: rgba(255, 255, 255, 0.15);
    }
    
    .btn.secondary:hover {
      background: rgba(255, 255, 255, 0.25);
    }
    
    .form-footer {
      text-align: center;
      margin-top: 20px;
      font-size: 0.9rem;
      opacity: 0.8;
    }
    
    .form-footer a {
      color: var(--accent);
      text-decoration: none;
      transition: all 0.3s ease;
    }
    
    .form-footer a:hover {
      text-decoration: underline;
    }
    
    /* Dashboard styles */
    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 30px;
      background: rgba(255, 255, 255, 0.08);
      border-radius: 20px;
      margin-bottom: 30px;
    }
    
    .dashboard-content {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      animation: fadeIn 0.8s ease-out;
    }
    
    .welcome-message {
      font-size: 2.5rem;
      margin-bottom: 20px;
      text-align: center;
    }
    
    .dashboard-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      margin-top: 40px;
    }
    
    .dashboard-card {
      background: rgba(255, 255, 255, 0.1);
      padding: 30px;
      border-radius: 20px;
      text-align: center;
      transition: all 0.3s ease;
      cursor: pointer;
    }
    
    .dashboard-card:hover {
      transform: translateY(-10px);
      background: rgba(255, 255, 255, 0.15);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }
    
    .dashboard-card i {
      font-size: 3.5rem;
      margin-bottom: 20px;
      color: var(--accent);
    }
    
    .dashboard-card h3 {
      font-size: 1.8rem;
      margin-bottom: 15px;
    }
    
    .dashboard-card p {
      opacity: 0.8;
      line-height: 1.6;
    }
    
    .logout-btn {
      padding: 10px 25px;
      background: rgba(247, 37, 133, 0.2);
      color: white;
      border: none;
      border-radius: 50px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .logout-btn:hover {
      background: rgba(247, 37, 133, 0.3);
      transform: translateY(-3px);
    }
    
    /* Animations */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateX(-20px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }
    
    @media (max-width: 768px) {
      .app-container {
        grid-template-columns: 1fr;
      }
      
      header h1 {
        font-size: 2.2rem;
      }
      
      .form-title {
        font-size: 1.8rem;
      }
      
      .welcome-message {
        font-size: 2rem;
      }
    }
    
    @media (max-width: 480px) {
      header h1 {
        font-size: 2rem;
      }
      
      .form-title {
        font-size: 1.6rem;
      }
      
      .welcome-message {
        font-size: 1.8rem;
      }
    }
  </style>
</head>
<body>
  <div class="floating-icon">👤</div>
  <div class="floating-icon">🔐</div>
  <div class="floating-icon">💻</div>
  <div class="floating-icon">🚀</div>

  <div class="container">
    <header>
      <h1><i class="fas fa-user-lock"></i> Dobrodošli u Learning App</h1>
      <p>Prijavite se na svoj račun ili registrujte novi</p>
    </header>

    <div class="app-container">
      <div class="form-section">
        <h2 class="form-title">Prijava</h2>

        <?php if (isset($_SESSION['error']) && strpos($_SERVER['REQUEST_URI'], '#login') !== false): ?>
          <div class="message error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success']) && strpos($_SERVER['REQUEST_URI'], '#login') !== false): ?>
          <div class="message success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST" id="login">
          <div class="form-group">
            <label for="username"><i class="fas fa-user"></i> Korisničko ime:</label>
            <input type="text" name="username" required />
          </div>

          <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Lozinka:</label>
            <input type="password" name="password" required />
          </div>

          <button type="submit" class="btn">
            <i class="fas fa-sign-in-alt"></i> Prijavi se
          </button>
        </form>

        <div class="form-footer">
          Nemate račun? <a href="#signup">Registrujte se ovdje</a>
        </div>
      </div>

      <div class="form-section">
        <h2 class="form-title">Registracija</h2>

        <?php if (isset($_SESSION['error']) && strpos($_SERVER['REQUEST_URI'], '#signup') !== false): ?>
          <div class="message error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="signup.php" method="POST" id="signup">
          <div class="form-group">
            <label for="username"><i class="fas fa-user"></i> Korisničko ime:</label>
            <input type="text" name="username" required />
          </div>

          <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email:</label>
            <input type="email" name="email" required />
          </div>

          <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Lozinka:</label>
            <input type="password" name="password" required />
          </div>

          <div class="form-group">
            <label for="password_confirm"><i class="fas fa-lock"></i> Potvrdi lozinku:</label>
            <input type="password" name="password_confirm" required />
          </div>

          <button type="submit" class="btn secondary">
            <i class="fas fa-user-plus"></i> Registruj se
          </button>
        </form>

        <div class="form-footer">
          Već imate račun? <a href="#login">Prijavite se ovdje</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({ behavior: 'smooth' });
      });
    });

    // Form animations
    const formSections = document.querySelectorAll('.form-section');
    formSections.forEach(section => {
      section.addEventListener('mouseenter', () => {
        section.style.transform = 'translateY(-5px)';
      });
      section.addEventListener('mouseleave', () => {
        section.style.transform = 'translateY(0)';
      });
    });
  </script>
</body>
</html>
