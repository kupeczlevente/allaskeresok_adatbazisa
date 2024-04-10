<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Álláskeresők adatbázisa</title>
     <link href="styles.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2 class="mb-4">Álláskeresők adatbázisa</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="addForm">
    <div class="form-group">
        <label for="nev">Név</label>
        <input type="text" class="form-control" id="nev" name="nev" required>
    </div>
    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="telefonszam">Telefonszám</label>
        <input type="tel" pattern="[0-9]+" class="form-control" id="telefonszam" name="telefonszam" required>
    </div>
    <div class="form-group">
        <label for="iskolai_vegzettseg">Iskolai végzettség</label>
        <input type="text" class="form-control" id="iskolai_vegzettseg" name="iskolai_vegzettseg" required>
    </div>
    <div class="form-group">
        <label for="allaskereso">Álláskereső</label>
        <select class="form-control" id="allaskereso" name="allaskereso" required>
            <option value="1">Igen</option>
            <option value="0">Nem</option>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Hozzáadás</button>
    </div>
</form>
    <div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>Név</th>
            <th>E-mail</th>
            <th>Telefonszám</th>
            <th>Végzettség</th>
            <th>Álláskereső</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "emberek_adatbazis";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['delete_id'])) {
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Kapcsolódási hiba: " . $conn->connect_error);
                }
                $delete_id = $_POST['delete_id'];
                $delete_sql = "DELETE FROM emberek WHERE id = $delete_id";
                if ($conn->query($delete_sql) === TRUE) {
                    echo "Sikeres törlés";
                } else {
                    echo "Hiba történt a törlés közben: " . $conn->error;
                }
                $conn->close();
            } elseif (isset($_POST['edit_id'])) {
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Kapcsolódási hiba: " . $conn->connect_error);
                }

                $edit_id = $_POST['edit_id'];
                $edit_nev = $_POST['edit_nev'];
                $edit_email = $_POST['edit_email'];
                $edit_telefonszam = $_POST['edit_telefonszam'];
                $edit_iskolai_vegzettseg = $_POST['edit_iskolai_vegzettseg'];
                $edit_allaskereso = $_POST['edit_allaskereso'];

                $edit_sql = "UPDATE emberek SET nev='$edit_nev', email='$edit_email', telefonszam='$edit_telefonszam', iskolai_vegzettseg='$edit_iskolai_vegzettseg', allaskereso='$edit_allaskereso' WHERE id='$edit_id'";

                if ($conn->query($edit_sql) === TRUE) {
                    header("Location: {$_SERVER['PHP_SELF']}");
                    exit();
                } else {
                    echo "Hiba történt a személy szerkesztése közben: " . $conn->error;
                }
                $conn->close();
            } else {
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Kapcsolódási hiba: " . $conn->connect_error);
                }
                $nev = $_POST['nev'];
                $email = $_POST['email'];
                $telefonszam = $_POST['telefonszam'];
                $iskolai_vegzettseg = $_POST['iskolai_vegzettseg'];
                $allaskereso = $_POST['allaskereso'];
                $sql = "INSERT INTO emberek (nev, email, telefonszam, iskolai_vegzettseg, allaskereso)
                VALUES ('$nev', '$email', '$telefonszam', '$iskolai_vegzettseg', '$allaskereso')";

                if ($conn->query($sql) === TRUE) {
                    header("Location: {$_SERVER['PHP_SELF']}");
                    exit();
                } else {
                    echo "Hiba történt a személy hozzáadása közben: " . $conn->error;
                }
                $conn->close();
            }
        }
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Kapcsolódási hiba: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM emberek";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nev'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['telefonszam'] . "</td>";
                echo "<td>" . $row['iskolai_vegzettseg'] . "</td>";
                echo "<td>" . ($row['allaskereso'] ? "Igen" : "Nem") . "</td>";
                echo "<td><form method='POST' action='{$_SERVER['PHP_SELF']}'><input type='hidden' name='delete_id' value='" . $row['id'] . "'><button type='submit' class='btn btn-danger'>Törlés</button></form></td>";
                echo "<td> <button type='button' class='btn btn-primary edit-btn' data-id='" . $row['id'] . "' data-toggle='modal' data-target='#editModal'>Szerkesztés</button>  </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nincs találat</td></tr>";
        }
        $conn->close();
        ?>
        </tbody>
    </table>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Adatok szerkesztése</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="modal-body">
          <input type="hidden" name="edit_id" id="edit_id">
          <div class="form-group">
            <label for="edit_nev">Név</label>
            <input type="text" class="form-control" id="edit_nev" name="edit_nev" required>
          </div>
          <div class="form-group">
            <label for="edit_email">E-mail</label>
            <input type="email" class="form-control" id="edit_email" name="edit_email" required>
          </div>
          <div class="form-group">
            <label for="edit_telefonszam">Telefonszám</label>
            <input type="text" class="form-control" id="edit_telefonszam" name="edit_telefonszam" required>
          </div>
          <div class="form-group">
            <label for="edit_iskolai_vegzettseg">Iskolai végzettség</label>
            <input type="text" class="form-control" id="edit_iskolai_vegzettseg" name="edit_iskolai_vegzettseg" required>
          </div>
          <div class="form-group">
            <label for="edit_allaskereso">Álláskereső</label>
            <select class="form-control" id="edit_allaskereso" name="edit_allaskereso" required>
              <option value="1">Igen</option>
              <option value="0">Nem</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezárás</button>
          <button type="submit" class="btn btn-primary">Mentés</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
  $(".edit-btn").click(function(){
    var id = $(this).data("id");
    var nev = $(this).closest("tr").find("td:eq(0)").text();
    var email = $(this).closest("tr").find("td:eq(1)").text();
    var telefonszam = $(this).closest("tr").find("td:eq(2)").text();
    var iskolai_vegzettseg = $(this).closest("tr").find("td:eq(3)").text();
    var allaskereso = $(this).closest("tr").find("td:eq(4)").text() == "Igen" ? 1 : 0;

    $("#edit_id").val(id);
    $("#edit_nev").val(nev);
    $("#edit_email").val(email);
    $("#edit_telefonszam").val(telefonszam);
    $("#edit_iskolai_vegzettseg").val(iskolai_vegzettseg);
    $("#edit_allaskereso").val(allaskereso);
    $("#editModal").modal("show");
  });
});
</script>
</body>
</html>
