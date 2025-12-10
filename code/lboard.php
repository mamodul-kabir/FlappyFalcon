<?php
    session_start();
    $stylesheet_url = 'css/index.css'; 
    $add_line = ['<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">', '<link rel="stylesheet" href="css/lboard.css">']; 
    include 'header.php';           
?>
    <nav class="navbar">
        <ul class="nav-list">
            <li class="nav-item"><a href="play.php">Play</a></li>
            <li class="nav-item"><a href="shop.php">Shop</a></li>
            <li class="nav-item active"><a href="#">Leaderboard</a></li>
        </ul>
    </nav>
    <div class="content">
        <h2><strong>Your High Score: <?php echo isset($_SESSION['high_score']) ? intval($_SESSION['high_score']) : 0; ?></strong></h2>
        <h1>Global Leaderboard</h1>
        <?php
            include "db_connect.php"; 
            $stmt = $db->prepare("SELECT username, high_score FROM users ORDER BY high_score DESC LIMIT 5"); 
            $res = $stmt->execute(); 
        ?>
        <div class="segement">
            <table>
                <tr id="top-row">
                    <th>Rank</th>
                    <th>Username</th>
                    <th>High Score</th>
                </tr>
            <?php 
                $rank = 1;
                while ($row = $res->fetchArray(SQLITE3_ASSOC)){
                    echo "<tr>"; 
                    echo "<td>$rank</td>"; 
                    echo "<td>{$row['username']}</td>"; 
                    echo "<td>{$row['high_score']}</td>"; 
                    echo "</tr>";
                    $rank++;  
                }
            ?>
            </table>
        </div>
        <div class="segment">
            <form method="GET">
                <input type="text" name="search_user" placeholder="Search Username...">
                <button type="submit">Search</button>
                <a href="lboard.php"><button type="button">Reset</button></a>
            </form>     

            <?php
            if (isset($_GET['search_user'])) {
                $search = trim($_GET['search_user']);
                
                // If search is not empty, run the query
                if (!empty($search)) {
                    // Exact match query
                    $stmt = $db->prepare("SELECT username, high_score FROM users WHERE username = :name");
                    $stmt->bindValue(':name', $search, SQLITE3_TEXT);
                    $res = $stmt->execute();
                    $foundUser = $res->fetchArray(SQLITE3_ASSOC);

                    echo "<div id='result-div'>";
                    if ($foundUser) {
                        echo "<h3>Search Result</h3>";
                        echo "<table>";
                        echo "<tr id='top-row'><th>Username</th><th>High Score</th></tr>";
                        echo "<tr>";
                        echo "<td>{$foundUser['username']}</td>";
                        echo "<td>{$foundUser['high_score']}</td>";
                        echo "</tr>";
                        echo "</table>";
                    } else {
                        echo "<p>No user found!</p>";
                    }
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>
<?php
    include "footer.php"; 
?>