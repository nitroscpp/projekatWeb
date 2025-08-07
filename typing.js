document.addEventListener('DOMContentLoaded', () => {
      // Elements
      const textDisplay = document.getElementById('text-display');
      const typingInput = document.getElementById('typing-input');
      const startBtn = document.getElementById('start-btn');
      const resetBtn = document.getElementById('reset-btn');
      const newTextBtn = document.getElementById('new-text-btn');
      const timerDisplay = document.getElementById('timer');
      const wpmDisplay = document.getElementById('wpm');
      const accuracyDisplay = document.getElementById('accuracy');
      const timeDisplay = document.getElementById('time');
      const charsDisplay = document.getElementById('chars');
      const accuracyCircle = document.getElementById('accuracy-display');
      const historyList = document.getElementById('history-list');
      const chartContainer = document.getElementById('chart-container');
      
      // State
      let originalText = '';
      let words = [];
      let currentIndex = 0;
      let startTime = null;
      let timerInterval = null;
      let timeLeft = 60;
      let isActive = false;
      let correctChars = 0;
      let totalChars = 0;
      let results = [];
      
      // Nasumični riječi za generisanje tekstova
      const wordsList = [
        "programiranje", "računar", "tastatura", "aplikacija", "vještina", 
        "brzina", "tačnost", "tipkanje", "kod", "algoritam", 
        "struktura", "podataka", "internet", "web", "stranica",
        "jezik", "bosanski", "hrvatski", "srpski", "tehnologija",
        "informacija", "sistem", "softver", "hardver", "monitor",
        "miš", "tajmer", "rezultat", "historija", "grafikon",
        "progres", "učenje", "vježba", "test", "vrijeme",
        "sekunda", "minuta", "sat", "dan", "nedjelja",
        "mjesec", "godina", "poboljšanje", "razvoj", "performanse",
        "interfejs", "korisnik", "iskušenje", "desktop", "laptop",
        "mobilni", "uređaj", "tablet", "telefon", "pametni",
        "tipka", "slovo", "broj", "simbol", "interpunkcija",
        "razmak", "enter", "shift", "ctrl", "alt",
        "delete", "backspace", "escape", "tab", "caps",
        "lock", "funkcija", "taster", "dijakritik", "znak",
        "kombinacija", "komanda", "opcija", "meni", "prozor",
        "aplikativni", "softverski", "hardverski", "periferija", "ulaz",
        "izlaz", "procesor", "memorija", "disk", "baterija",
        "napajanje", "konektor", "usb", "hdmi", "bluetooth",
        "wifi", "mreža", "internet", "povezivanje", "komunikacija"
      ];
      
      // Generisanje nasumičnog teksta
      function generateRandomText(length = 100) {
        let text = '';
        while (text.length < length) {
          const word = wordsList[Math.floor(Math.random() * wordsList.length)];
          text += (text.length === 0 ? word.charAt(0).toUpperCase() + word.slice(1) : ' ' + word);
          
          // Dodaj tačku na kraju rečenice svakih 5-10 riječi
          if (Math.random() < 0.15 && text.length > 50) {
            text += '.';
          }
        }
        return text + '.';
      }
      
      // Initialize the app
      function init() {
        loadNewText();
        loadHistory();
        renderChart();
      }
      
      // Load a new random text
      function loadNewText() {
        originalText = generateRandomText(120);
        renderText();
      }
      
      // Render the text with styling
      function renderText() {
        textDisplay.innerHTML = '';
        words = originalText.split('');
        
        words.forEach((char, index) => {
          const charSpan = document.createElement('span');
          charSpan.innerText = char;
          textDisplay.appendChild(charSpan);
        });
        
        updateActiveChar();
      }
      
      // Update active character
      function updateActiveChar() {
        const spans = textDisplay.querySelectorAll('span');
        spans.forEach((span, index) => {
          span.classList.remove('active', 'correct', 'incorrect');
          
          if (index === currentIndex) {
            span.classList.add('active');
          } else if (index < currentIndex) {
            const char = words[index];
            span.classList.add(typingInput.value[index] === char ? 'correct' : 'incorrect');
          }
        });
      }
      
      // Start the test
      function startTest() {
        if (isActive) return;
        
        isActive = true;
        typingInput.disabled = false;
        typingInput.focus();
        startBtn.disabled = true;
        resetBtn.disabled = false;
        currentIndex = 0;
        correctChars = 0;
        totalChars = 0;
        timeLeft = 60;
        timerDisplay.textContent = `00:${timeLeft.toString().padStart(2, '0')}`;
        
        // Start timer
        startTime = new Date();
        timerInterval = setInterval(updateTimer, 1000);
        
        // Clear input
        typingInput.value = '';
        renderText();
      }
      
      // Update the timer
      function updateTimer() {
        timeLeft--;
        timerDisplay.textContent = `00:${timeLeft.toString().padStart(2, '0')}`;
        timeDisplay.textContent = timeLeft;
        
        if (timeLeft <= 0) {
          finishTest();
        }
      }
      
      // Finish the test
      function finishTest() {
        clearInterval(timerInterval);
        isActive = false;
        typingInput.disabled = true;
        startBtn.disabled = false;
        
        // Calculate WPM
        const timeInMinutes = 1; // 60 seconds = 1 minute
        const wordsTyped = typingInput.value.trim().split(/\s+/).length;
        const wpm = Math.round(wordsTyped / timeInMinutes);
        
        // Calculate accuracy
        const accuracy = Math.round((correctChars / totalChars) * 100) || 0;
        
        // Update displays
        wpmDisplay.textContent = wpm;
        accuracyDisplay.textContent = `${accuracy}%`;
        accuracyCircle.textContent = `${accuracy}%`;
        charsDisplay.textContent = totalChars;
        
        // Save result
        saveResult(wpm, accuracy);
      }
      
      // Save result to history
      function saveResult(wpm, accuracy) {
        const now = new Date();
        const dateStr = now.toLocaleDateString('bs-BA', {
          day: 'numeric',
          month: 'numeric',
          year: 'numeric'
        });
        const timeStr = now.toLocaleTimeString('bs-BA', {
          hour: '2-digit',
          minute: '2-digit'
        });
        
        const result = {
          date: `${dateStr}, ${timeStr}`,
          wpm,
          accuracy
        };
        
        results.unshift(result);
        if (results.length > 5) results.pop();
        
        saveHistory();
        renderHistory();
        renderChart();
      }
      
      // Save history to localStorage
      function saveHistory() {
        localStorage.setItem('typingResults', JSON.stringify(results));
      }
      
      // Load history from localStorage
      function loadHistory() {
        const savedResults = localStorage.getItem('typingResults');
        results = savedResults ? JSON.parse(savedResults) : [];
        renderHistory();
      }
      
      // Render history list
      function renderHistory() {
        historyList.innerHTML = '';
        
        results.forEach(result => {
          const historyItem = document.createElement('li');
          historyItem.className = 'history-item';
          
          historyItem.innerHTML = `
            <div class="history-date">${result.date}</div>
            <div class="history-stats">
              <div class="history-stat">
                <div class="history-value">${result.wpm}</div>
                <div class="history-label">WPM</div>
              </div>
              <div class="history-stat">
                <div class="history-value">${result.accuracy}%</div>
                <div class="history-label">Tačnost</div>
              </div>
            </div>
          `;
          
          historyList.appendChild(historyItem);
        });
      }
      
      // Render progress chart
      function renderChart() {
        chartContainer.innerHTML = '';
        
        if (results.length === 0) return;
        
        const maxWpm = Math.max(...results.map(r => r.wpm));
        const chartHeight = 150;
        const barWidth = 30;
        const gap = 20;
        const totalWidth = results.length * (barWidth + gap) - gap;
        const startX = (chartContainer.offsetWidth - totalWidth) / 2;
        
        results.forEach((result, index) => {
          const barHeight = (result.wpm / maxWpm) * chartHeight;
          
          const bar = document.createElement('div');
          bar.className = 'chart-bar';
          bar.style.height = `${barHeight}px`;
          bar.style.left = `${startX + index * (barWidth + gap)}px`;
          bar.style.backgroundColor = index === 0 ? 'var(--accent)' : 'var(--success)';
          
          const label = document.createElement('div');
          label.className = 'chart-label';
          label.textContent = result.wpm;
          label.style.left = `${startX + index * (barWidth + gap)}px`;
          
          chartContainer.appendChild(bar);
          chartContainer.appendChild(label);
        });
      }
      
      // Reset the test
      function resetTest() {
        clearInterval(timerInterval);
        isActive = false;
        typingInput.disabled = false;
        startBtn.disabled = false;
        resetBtn.disabled = true;
        currentIndex = 0;
        timeLeft = 60;
        timerDisplay.textContent = `00:${timeLeft.toString().padStart(2, '0')}`;
        typingInput.value = '';
        renderText();
      }
      
      // Event listeners
      startBtn.addEventListener('click', startTest);
      resetBtn.addEventListener('click', resetTest);
      newTextBtn.addEventListener('click', () => {
        loadNewText();
        resetTest();
      });
      
      typingInput.addEventListener('input', () => {
        if (!isActive) return;
        
        const typedValue = typingInput.value;
        totalChars = typedValue.length;
        charsDisplay.textContent = totalChars;
        
        // Calculate correct characters
        correctChars = 0;
        for (let i = 0; i < typedValue.length; i++) {
          if (i < words.length && typedValue[i] === words[i]) {
            correctChars++;
          }
        }
        
        // Update current index
        currentIndex = Math.min(typedValue.length, words.length);
        updateActiveChar();
        
        // Calculate and update WPM
        const elapsedTime = (new Date() - startTime) / 1000; // in seconds
        const minutes = elapsedTime / 60;
        const wordsTyped = typedValue.trim().split(/\s+/).length;
        const wpm = Math.round(wordsTyped / minutes);
        wpmDisplay.textContent = wpm || 0;
        
        // Update accuracy
        const accuracy = Math.round((correctChars / totalChars) * 100) || 100;
        accuracyDisplay.textContent = `${accuracy}%`;
      });
      
      // Initialize the app
      init();
    });