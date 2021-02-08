<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <table style="width: 100%;"> 
        <tr>
            <td>Hora</td>
            <td>Lunes</td>
            <td>Martes</td>
            <td>Miercoles</td>
            <td>Jueves</td> 
            <td>Viernes</td>
            <td>Sábado</td>
        </tr>
        <?php
        $dias = ["lunes", "martes", "miercoles", "jueves", "viernes", "sabado"];
        $horas = [
            "07:00", "07:30", "08:00", "08:30", "09:00", "09:30",  "10:00", "10:30",  "11:00", "11:30",  "12:00", "12:30",  "13:00", "13:30",  "14:00", "14:30",
            "15:00", "15:30",  "16:00", "17:30",  "18:00", "18:30",  "19:00", "19:30",  "20:00", "20:30",  "21:00", "21:30", "22:00", "22:30"
        ];
        foreach ($horas as $hora) {
            echo " <tr> <td>" . $hora . "</td>";
            foreach ($dias as $dia) {
                $resultado = $this->modelo->horariotramos($hora, $dia);
                if ($resultado == "nada") {
                    echo "<td> </td>";
                } else {
                    $resultadoact = $this->modelo->buscaractividad($resultado["actividad_id"]);
                    echo "<td>" . $resultadoact["nombre"] .
                        "</td>";
                }
            }
            echo "</tr>";
        }

        ?>

    </table>

</body>

</html>