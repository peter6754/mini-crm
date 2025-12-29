<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="tel"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Contact Form</h1>
    <form id="contactForm" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" pattern="^\+[1-9]\d{1,14}$" placeholder="+3735454433" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" required>
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" required></textarea>
        </div>

        <div class="form-group">
            <label for="files">Files</label>
            <input type="file" id="files" name="files" multiple>
        </div>

        <button type="submit" id="submitBtn">Submit</button>
        <div id="result" style="margin-top: 15px;"></div>
    </form>

    <script>
        document.getElementById('contactForm').addEventListener('submit', async function (e) {
            const phone = document.getElementById('phone').value;
            const phoneRegex = /^\+[1-9]\d{1,14}$/;

            if (!phoneRegex.test(phone)) {
                e.preventDefault();
                const resultDiv = document.getElementById('result');
                resultDiv.textContent = 'Error: Phone must be in E.164 format (e.g. +14155552671)';
                resultDiv.style.color = 'red';
                return;
            }


            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const resultDiv = document.getElementById('result');
            const formData = new FormData();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;
            const files = document.getElementById('files').files;

            const data = {
                name: name,
                phone: phone,
                email: email,
                theme: subject,
                text: message,
                status: 'new'
            };

            Object.keys(data).forEach(key => {
                formData.append(key, data[key]);
            });

            for (let i = 0; i < files.length; i++) {
                formData.append('attachments[]', files[i]);
            }

            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';
            resultDiv.textContent = '';
            resultDiv.className = '';

            try {
                const response = await fetch('/api/tickets', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    resultDiv.textContent = 'Ticket created successfully!';
                    resultDiv.style.color = 'green';
                    document.getElementById('contactForm').reset();
                } else {
                    resultDiv.textContent = 'Error: ' + (result.message || JSON.stringify(result.errors));
                    resultDiv.style.color = 'red';
                }
            } catch (error) {
                resultDiv.textContent = 'Error: ' + error.message;
                resultDiv.style.color = 'red';
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit';
            }
        });
    </script>
</body>

</html>