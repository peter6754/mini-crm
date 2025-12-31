<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма поддержки</title>
    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100vh;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: transparent;
            padding: 15px;
            line-height: 1.5;
        }

        .widget-container {
            max-width: 450px;
            margin: 0 auto;
        }

        .widget-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .form-group {
            margin-bottom: 12px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            font-size: 14px;
            color: #555;
        }

        input[type="text"],
        input[type="tel"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #007bff;
        }

        textarea {
            min-height: 80px;
            resize: vertical;
        }

        input[type="file"] {
            font-size: 13px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            width: 100%;
            transition: background-color 0.2s;
        }

        button:hover:not(:disabled) {
            background-color: #0056b3;
        }

        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .result {
            margin-top: 12px;
            padding: 10px;
            border-radius: 4px;
            font-size: 14px;
        }

        .result.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .result.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <div class="widget-container">
        <div class="widget-title">Форма поддержки</div>
        <form id="contactForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Имя *</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="phone">Телефон *</label>
                <input type="tel" id="phone" name="phone" placeholder="+380991234567" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="subject">Тема *</label>
                <input type="text" id="subject" name="subject" required>
            </div>

            <div class="form-group">
                <label for="message">Сообщение *</label>
                <textarea id="message" name="message" required></textarea>
            </div>

            <div class="form-group">
                <label for="files">Файлы</label>
                <input type="file" id="files" name="files" multiple>
            </div>

            <button type="submit" id="submitBtn">Отправить</button>
            <div id="result"></div>
        </form>
    </div>

    <script>
        (function() {
            // Get base URL from current location for API calls
            const apiBaseUrl = window.location.origin;

            document.getElementById('contactForm').addEventListener('submit', async function (e) {
                e.preventDefault();

                const phone = document.getElementById('phone').value;
                const phoneRegex = /^\+[1-9]\d{1,14}$/;

                if (!phoneRegex.test(phone)) {
                    showResult('Ошибка: Телефон должен быть в формате E.164 (например: +380991234567)', 'error');
                    return;
                }

                const submitBtn = document.getElementById('submitBtn');
                const formData = new FormData();

                const data = {
                    name: document.getElementById('name').value,
                    phone: phone,
                    email: document.getElementById('email').value,
                    theme: document.getElementById('subject').value,
                    text: document.getElementById('message').value,
                    status: 'new'
                };

                Object.keys(data).forEach(key => {
                    formData.append(key, data[key]);
                });

                const files = document.getElementById('files').files;
                for (let i = 0; i < files.length; i++) {
                    formData.append('attachments[]', files[i]);
                }

                submitBtn.disabled = true;
                submitBtn.textContent = 'Отправка...';
                clearResult();

                try {
                    const response = await fetch(apiBaseUrl + '/api/tickets', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok) {
                        showResult('Заявка успешно создана!', 'success');
                        document.getElementById('contactForm').reset();
                    } else {
                        const errorMsg = result.message
                            ? result.message
                            : (result.errors ? Object.values(result.errors).flat().join(', ') : 'Неизвестная ошибка');
                        showResult('Ошибка: ' + errorMsg, 'error');
                    }
                } catch (error) {
                    showResult('Ошибка соединения: ' + error.message, 'error');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Отправить';
                }
            });

            function showResult(message, type) {
                const resultDiv = document.getElementById('result');
                resultDiv.textContent = message;
                resultDiv.className = 'result ' + type;
            }

            function clearResult() {
                const resultDiv = document.getElementById('result');
                resultDiv.textContent = '';
                resultDiv.className = '';
            }
        })();
    </script>
</body>

</html>
