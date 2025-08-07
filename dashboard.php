<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="bs">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard | Projekat za učenje</title>
  <link rel="stylesheet" href="dashboard.css" />
</head>
<body>
  <!-- Floating background elements -->
  <div class="floating-icon">📝</div>
  <div class="floating-icon">⌨️</div>
  <div class="floating-icon">🤖</div>
  <div class="floating-icon">💻</div>
  
  <header>
    <h1>Izaberi aktivnost</h1>
  </header>

  <main>
    <div class="dashboard-grid">
      <a href="quiz.html" class="btn">
        <span>📝</span>
        Kviz programiranja
      </a>
      
      <a href="typing.html" class="btn">
        <span>⌨️</span>
        Vježba brzog kucanja
      </a>
      
      <a href="#" class="btn coming-soon">
        <span>🤖</span>
        AI pomoćnik
      </a>
    </div>
    
    <section class="tasks-section">
      <h2 class="section-title">Zadaci za vježbu</h2>
      <div class="tasks-grid">
        <a href="zadaci/programiranje.html" class="task-btn">
          <span>💻</span>
          Programiranje
        </a>
        <a href="zadaci/logika.html" class="task-btn">
          <span>🧩</span>
          Logički zadaci
        </a>
        <a href="zadaci/matematika.html" class="task-btn">
          <span>📐</span>
          Matematički zadaci
        </a>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Projekat za učenje. Sva prava zadržana.</p>
  </footer>
</body>
</html>
