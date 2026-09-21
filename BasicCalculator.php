<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Numpad Calculator</title>
<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #1e1e2f;
        transition: background-color 0.6s ease;
    }

    .calculator {
        width: 300px;
        background: #2b2b3d;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    }

    .display {
        background: #101018;
        color: #fff;
        border-radius: 10px;
        padding: 20px 15px;
        margin-bottom: 15px;
        text-align: right;
        min-height: 70px;
        word-wrap: break-word;
    }

    .display .expression {
        font-size: 14px;
        color: #9a9ac0;
        min-height: 18px;
    }

    .display .current {
        font-size: 32px;
        font-weight: bold;
        overflow-x: auto;
    }

    .pad {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }

    button {
        border: none;
        border-radius: 10px;
        padding: 18px 0;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        color: #fff;
        background: #3a3a55;
        transition: transform 0.08s ease, filter 0.2s ease;
    }

    button:active {
        transform: scale(0.94);
    }

    button:hover {
        filter: brightness(1.15);
    }

    .btn-num {
        background: #3a3a55;
    }

    .btn-op {
        background: #4d5bd9;
    }

    .btn-func {
        background: #565676;
    }

    .btn-equals {
        background: #16a34a;
        grid-column: span 2;
    }

    .btn-zero {
        grid-column: span 2;
    }
</style>
</head>
<body>

<div class="calculator">
    <div class="display">
        <div class="expression" id="expression"></div>
        <div class="current" id="current">0</div>
    </div>

    <div class="pad">
        <button class="btn-func" onclick="clearAll()">C</button>
        <button class="btn-func" onclick="backspace()">⌫</button>
        <button class="btn-func" onclick="chooseOperation('%')">%</button>
        <button class="btn-op" onclick="chooseOperation('/')">÷</button>

        <button class="btn-num" onclick="appendNumber('7')">7</button>
        <button class="btn-num" onclick="appendNumber('8')">8</button>
        <button class="btn-num" onclick="appendNumber('9')">9</button>
        <button class="btn-op" onclick="chooseOperation('*')">×</button>

        <button class="btn-num" onclick="appendNumber('4')">4</button>
        <button class="btn-num" onclick="appendNumber('5')">5</button>
        <button class="btn-num" onclick="appendNumber('6')">6</button>
        <button class="btn-op" onclick="chooseOperation('-')">−</button>

        <button class="btn-num" onclick="appendNumber('1')">1</button>
        <button class="btn-num" onclick="appendNumber('2')">2</button>
        <button class="btn-num" onclick="appendNumber('3')">3</button>
        <button class="btn-op" onclick="chooseOperation('+')">+</button>

        <button class="btn-num btn-zero" onclick="appendNumber('0')">0</button>
        <button class="btn-num" onclick="appendNumber('.')">.</button>
        <button class="btn-equals" onclick="calculate()">=</button>
    </div>
</div>

<script>
let currentValue = '0';
let previousValue = '';
let operation = null;

const currentEl = document.getElementById('current');
const expressionEl = document.getElementById('expression');

function updateDisplay() {
    currentEl.textContent = currentValue;
    expressionEl.textContent = previousValue !== '' ? `${previousValue} ${operation ?? ''}` : '';
}

function appendNumber(digit) {
    if (digit === '.' && currentValue.includes('.')) return;
    if (currentValue === '0' && digit !== '.') {
        currentValue = digit;
    } else {
        currentValue += digit;
    }
    updateDisplay();
}

function chooseOperation(op) {
    if (currentValue === '' ) return;
    if (previousValue !== '') {
        calculate();
    }
    operation = op;
    previousValue = currentValue;
    currentValue = '0';
    updateDisplay();
}

function clearAll() {
    currentValue = '0';
    previousValue = '';
    operation = null;
    updateDisplay();
}

function backspace() {
    currentValue = currentValue.length > 1 ? currentValue.slice(0, -1) : '0';
    updateDisplay();
}

function calculate() {
    let result;
    const prev = parseFloat(previousValue);
    const curr = parseFloat(currentValue);
    if (isNaN(prev) || isNaN(curr) || operation === null) return;

    switch (operation) {
        case '+':
            result = prev + curr;
            break;
        case '-':
            result = prev - curr;
            break;
        case '*':
            result = prev * curr;
            break;
        case '/':
            result = curr === 0 ? 'Error' : prev / curr;
            break;
        case '%':
            result = prev % curr;
            break;
        default:
            return;
    }

    currentValue = result.toString();
    operation = null;
    previousValue = '';
    updateDisplay();

    // Unique feature: flash a fresh random background color every time "=" is pressed
    changeBackgroundColor();
}

function changeBackgroundColor() {
    const hue = Math.floor(Math.random() * 360);
    document.body.style.backgroundColor = `hsl(${hue}, 55%, 20%)`;
}
</script>

</body>
</html>