<?php
$conn = mysqli_connect("localhost", "root", "", "egzamin");
$query = "SELECT id, informacja, wart_min FROM bmi";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twój wskaźnik BMI</title>
    <link rel="stylesheet" href="styl4.css">
</head>
<body>
    <header>
        <div>
            <h2>Oblicz wskaźnik BMI</h2>
        </div>
        <div>
            <img src="wzor.png" alt="liczymy BMI!">
        </div>
    </header>
    <div class="container">
        <div class="Left">
            <img src="rys1.png" alt="zrzuć kalorie!">
        </div>
        <div class="Right">
            <h1>Podaj dane</h1>
            <form action="waga.php" method="POST">
                <label for="weight" name="weight">Waga:</label>
                <input type="number" name="weight" id="weight">
                <label for="height" name="height">Wzrost [cm]:</label>
                <input type="number" name="height" id="height">
                <button type="submit">Licz BMI i zapisz wynik</button>
            </form>
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST") {
                    $weight = $_POST['weight'];
                    $height = $_POST['height'];
                    if(!empty($weight) || !empty($height)) {
                        $bmi_result = $weight / (($height / 100) ** 2);
                        $bmi_result = round($bmi_result, 2);
                        if ($bmi_result < 18.5) {
                            $bmi_id = 1;
                        } elseif ($bmi_result < 25) {
                            $bmi_id = 2;
                        } elseif ($bmi_result < 30) {
                            $bmi_id = 3;
                        } else {
                            $bmi_id = 4;
                        }
                        $data = DATE("Y-m-d");
                        echo "Twoja waga: $weight, Twój wzrost: $height<br/>BMI wynosi: $bmi_result";
                        $BMI_query = "INSERT INTO wynik (id, bmi_id, data_pomiaru, wynik) VALUES (NULL, $bmi_id, '$data', $bmi_result)";
                        mysqli_query($conn, $BMI_query);
                    }
                }
            ?>
        </div>
    </div>
    <main>
        <table>
            <tr>
                <th>lp.</th>
                <th>Intrepretacja</th>
                <th>zaczyna się od...</th>
            </tr>
            <?php
                while ($row = mysqli_fetch_row($result)) {
                    echo "<tr>";
                    for ($i = 0; $i < mysqli_num_fields($result); $i++) {
                        echo "<td>$row[$i]</td>";
                    }
                    echo "</tr>";
                    }
                mysqli_close($conn);
            ?>
        </table>
    </main>
    <footer>
        <p>Autor: 000000000000000</p>
        <a href="kw2.jpg">Wynik działania kwerendy 2</a>
    </footer>
</body>
</html>