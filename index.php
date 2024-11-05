<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Ejecución de Comandos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container my-5">
        <h1 class="text-center">Panel de Administración</h1>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="command">Ingrese un comando de bash</label>
                    <input type="text" id="command" class="form-control" placeholder="ls -lh">
                </div>
                <button id="execute" class="btn btn-primary btn-block">Ejecutar</button>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-10">
                <h3 class="text-center">Salida</h3>
                <pre id="command-output" class="bg-dark text-white p-3 rounded"></pre>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('execute').addEventListener('click', function () {
            const command = document.getElementById('command').value;

            if (!command) {
                alert('Por favor, introduce un comando.');
                return;
            }

            const url = 'http://www.vh7.lan/controller.php';  // Asegúrate de que la URL esté correcta
            const postData = { command: command };

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(postData)
            })
            .then(response => response.json())
            .then(data => {
                const outputElement = document.getElementById('command-output');
                outputElement.innerHTML = data.output ? data.output.join('\n') : "Error ejecutando el comando";
                if (data.status === 'error') {
                    outputElement.classList.add('bg-danger');
                } else {
                    outputElement.classList.add('bg-success');
                }
            })
            .catch(error => console.error('Error en la solicitud POST:', error));
        });
    </script>

</body>
</html>
