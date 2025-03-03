<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table with Gaps</title>
    <style>
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px; /* Adds gap between rows */
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .row-container {
            background: white;
            border: 1px solid #ccc;
        }

        .bold {
            font-weight: bold;
        }

        .small-text {
            font-size: 12px;
            color: gray;
        }
    </style>
</head>
<body>

    <table>
        <tbody>
            <tr class="row-container">
                <td class="bold">Han Isaac Bascao</td>
                <td>Eddie, Ebi</td>
                <td>Gold</td>
                <td class="small-text">
                    <strong>Registered Date:</strong> 06/05/2024<br>
                    <strong>Expiry Date:</strong> 06/05/2026
                </td>
            </tr>
            <tr class="row-container">
                <td class="bold">Joanne Joaquin</td>
                <td>Kucci</td>
                <td>Silver</td>
                <td class="small-text">
                    <strong>Registered Date:</strong> 01/10/2023<br>
                    <strong>Expiry Date:</strong> 01/10/2025
                </td>
            </tr>
            <tr class="row-container">
                <td class="bold">Vince Delos Santos</td>
                <td>Haku</td>
                <td><input type="text" value="Silver"></td>
                <td class="small-text">
                    <strong>Registered Date:</strong> 05/10/2024<br>
                    <strong>Expiry Date:</strong> 05/10/2026
                </td>
            </tr>
            <tr class="row-container">
                <td class="bold">Vince Delos Santos</td>
                <td>Haku</td>
                <td>Silver</td>
                <td class="small-text">
                    <strong>Registered Date:</strong> 05/10/2024<br>
                    <strong>Expiry Date:</strong> 05/10/2026
                </td>
            </tr>
        </tbody>
    </table>

</body>
</html>
