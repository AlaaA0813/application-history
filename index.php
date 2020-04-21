<?php
include_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="styles.css">
        <title>Home</title>
        <script>
            // set max date to current date
            $(function() {
                var today = new Date();
                // without + 1, would return previous month
                var month = today.getMonth() + 1;
                var day = today.getDate();
                var year = today.getFullYear();

                if (month < 10)
                    month = '0' + month.toString();
                if (day < 10)
                    day = '0' + day.toString();

                var maxDate = year + '-' + month + '-' + day;
                $('#date-input').attr('max', maxDate);
            });

            // turn work history form on and off
            function addButton(item) {
                if (document.getElementById('item').checked) {
                    document.getElementById("form-box").style.display = "block";
                } else {
                    document.getElementById("form-box").style.display = "none";
                }
            };
        </script>
    </head>

    <body>
    
        <?php
            // submit information into database
            if (isset($_POST['submit'])) {
                $company = $_POST['company'];
                $company = ucwords(strtolower($company));

                $position = $_POST['position'];
                $position = ucwords(strtolower($position));

                $internStatus = $_POST['intern-status'];
                $appDate = $_POST['app-date'];

                $city = $_POST['city'];
                $city = ucwords(strtolower($city));

                $state = $_POST['state'];
                $phone = $_POST['phone'] ?? '';

                // ensure certain inputs are not empty
                if (($company != '') && ($position != '') && ($internStatus != '') && ($appDate != '') && ($city != '') && ($state != '')) {
                    
                    //  set submitted intern-status values equal to 1 or 0
                    if ($internStatus == 'yes') {
                        $internStatus = 1;
                    } else if ($internStatus == 'no') {
                        $internStatus = 0;
                    }
                    
                    // sql query to add user input into company table
                    $insertInfo = "INSERT INTO `Company`(Company, Position, Internship, Application_Date, City, Company_State,  Phone_Number)
                                   VALUES ('$company', '$position', '$internStatus', '$appDate', '$city','$state', '$phone')";
                    if (mysqli_query($conn, $insertInfo)) {
                        echo "You applied for the position as a(n) " . $position . " " . "for the company" . " " . $company . " " . "on the date of" . " " . $appDate . ".";
                    } else {
                        echo "There was an error with adding to your application history.";
                    }
                }
            }

            // remove item button logic
            if (isset($_POST['rmv-row-btn'])) {
                if(isset($_POST['check'])) {
                    foreach ($_POST['check'] as $value) {
                        $selectDeletedCompany = "SELECT Company FROM `Company` WHERE ID='$value'";
                        $result = mysqli_query($conn, $selectDeletedCompany);
                        while ($row = mysqli_fetch_array($result)) {
                            $selectedCompanyName = $row['Company'];
                            $deleteItem = "DELETE FROM `Company` WHERE ID='$value'";
                            if (mysqli_query($conn, $deleteItem)) {
                                echo "You have removed " . $selectedCompanyName . " from the Application History.<br>";
                            } else {
                                echo "Error with removing " . $selectedCompanyName . " from the Application History." . mysqli_error($conn);
                            }
                        }
                    }
                }
            }
            
            // section off title with page description
            echo "
                <section class='welcome-banner'> 
                    <h1 class='welc-txt'>Welcome</h1>
                </section>";
            // company/position information form
            echo "
                <section id='switch-wrapper'>
                    <h2 id='switch-drctns'>Toggle the switch to use the form.</h2>
                    <label class='switch'>
                        <input name='item'  id='item' type='checkbox' onclick='addButton(this)' unchecked>
                        <span class='slider round'></span>
                    </label>
                </section>
                <section id='form-box' class='form-box'>
                    <form id='company' action='index.php' method='POST'>
                        <p class='home-drctns'>Enter information about the positions you have applied for.</p>
                        <fieldset>
                            <input type='text' name='company' placeholder='Company*' required/>
                        </fieldset>

                        <fieldset>
                            <input type='text' name='position' placeholder='Position*' required/>
                        </fieldset>

                        <fieldset>
                            <label>Internship*
                                <label>Yes</label>
                                    <input type='radio' name='intern-status' value='yes'/>
                                <label>No</label>
                                    <input type='radio' name='intern-status' value='no'/>
                            </label>
                        </fieldset>

                        <fieldset>
                            <label>Date of Application Submission*</label><br>
                                <input id='date-input' type='date' name='app-date' required/><br>
                        </fieldset>


                        <fieldset>
                            <input type='text' name='city' placeholder='City*' required/>
                        </fieldset>

                        <fieldset>
                            <select name='state' id='state' required>
                                <option value='' selected='selected'>Select a State*</option>
                                <option value='AL'>Alabama</option>
                                <option value='AK'>Alaska</option>
                                <option value='AZ'>Arizona</option>
                                <option value='AR'>Arkansas</option>
                                <option value='CA'>California</option>
                                <option value='CO'>Colorado</option>
                                <option value='CT'>Connecticut</option>
                                <option value='DE'>Delaware</option>
                                <option value='DC'>District Of Columbia</option>
                                <option value='FL'>Florida</option>
                                <option value='GA'>Georgia</option>
                                <option value='HI'>Hawaii</option>
                                <option value='ID'>Idaho</option>
                                <option value='IL'>Illinois</option>
                                <option value='IN'>Indiana</option>
                                <option value='IA'>Iowa</option>
                                <option value='KS'>Kansas</option>
                                <option value='KY'>Kentucky</option>
                                <option value='LA'>Louisiana</option>
                                <option value='ME'>Maine</option>
                                <option value='MD'>Maryland</option>
                                <option value='MA'>Massachusetts</option>
                                <option value='MI'>Michigan</option>
                                <option value='MN'>Minnesota</option>
                                <option value='MS'>Mississippi</option>
                                <option value='MO'>Missouri</option>
                                <option value='MT'>Montana</option>
                                <option value='NE'>Nebraska</option>
                                <option value='NV'>Nevada</option>
                                <option value='NH'>New Hampshire</option>
                                <option value='NJ'>New Jersey</option>
                                <option value='NM'>New Mexico</option>
                                <option value='NY'>New York</option>
                                <option value='NC'>North Carolina</option>
                                <option value='ND'>North Dakota</option>
                                <option value='OH'>Ohio</option>
                                <option value='OK'>Oklahoma</option>
                                <option value='OR'>Oregon</option>
                                <option value='PA'>Pennsylvania</option>
                                <option value='RI'>Rhode Island</option>
                                <option value='SC'>South Carolina</option>
                                <option value='SD'>South Dakota</option>
                                <option value='TN'>Tennessee</option>
                                <option value='TX'>Texas</option>
                                <option value='UT'>Utah</option>
                                <option value='VT'>Vermont</option>
                                <option value='VA'>Virginia</option>
                                <option value='WA'>Washington</option>
                                <option value='WV'>West Virginia</option>
                                <option value='WI'>Wisconsin</option>
                                <option value='WY'>Wyoming</option>
                            </select>
                        </fieldset>

                        <fieldset>
                            <input type='tel' name='phone' placeholder='Phone Number (optional)'/>
                        </fieldset>

                        <fieldset>
                            <input id='submit' type='submit' name='submit' value='Submit'/>
                        </fieldset>
                    </form>
                </section>";

            // grab information from database to display in table
            $getAppInfo = "SELECT * FROM `Company`";
            $getAppInfoResult = mysqli_query($conn, $getAppInfo);
            $i = 1;  // counter for checkboxes

            // create table, put inside a form for delete operation
                // THIS IS A PENCIL ICON - IT CAN BE USED FOR AN EDIT BUTTON ------------> &#9998;
            echo "
                <section class='tbl-wrapper'>
                    <form action='index.php' method='POST'>
                        <table>
                            <thead class='tbl-header'>
                                <tr>
                                    <th>Company</th>
                                    <th>Position</th>
                                    <th>Internship Status</th>
                                    <th>Date of Application Submission</th>
                                    <th>City, State</th>
                                    <th>Phone Number</th>
                                    <th>&#10060;</th>
                                </tr>
                            </thead>";
            while ($row = mysqli_fetch_array($getAppInfoResult)) {
                $ID = $row['ID'];
                $comp = $row['Company'];
                $pos = $row['Position'];
                $int = $row['Internship'];
                if ($int == 0) {
                    $int = 'Yes';
                } else {
                    $int = 'No';
                }
                $aDate = $row['Application_Date'];
                $cit = $row['City'];
                $st = $row['Company_State'];
                $phoneNo = $row['Phone_Number'];
                echo "      <tbody class='tbl-content'>
                                <tr>";
                echo "              <td name='company'>" . $comp . "</td>
                                    <td name='position'>" . $pos . "</td>
                                    <td name='internship'>" . $int . "</td>
                                    <td name='app-date'>" . $aDate . "</td>
                                    <td name='address'>" . $cit . ", " . $st . "</td>
                                    <td name='phone'>" . $phoneNo . "</td>
                                    <td><input type='checkbox' name='check[$i]' value='" . $ID . "'/></td>
                                <tr>";
                    $i++;
                echo "      </tbody>";
            }
            echo "      </table>";
            echo "  
                        <fieldset>
                            <input id='rmv-row-btn' type='submit' name='rmv-row-btn' value='Remove item(s)'/>
                        </fieldset>
                    </form>
                </section>";
            mysqli_close($conn);
        ?>

    </body>

</html>
